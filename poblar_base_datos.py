#!/usr/bin/env python3
"""
Script para poblar la base de datos del sistema de gestión de eventos.
Genera datos de ejemplo para todas las tablas respetando las relaciones.
"""

import psycopg2
from psycopg2.extras import execute_batch
from faker import Faker
import random
from datetime import datetime, timedelta
from bcrypt import hashpw, gensalt

# Configuración de la base de datos (desde .env)
DB_CONFIG = {
    'host': 'localhost',
    'port': 5435,
    'database': 'Gestion_Eventos',
    'user': 'sail',
    'password': 'password'
}

# Inicializar Faker en español
fake = Faker('es_MX')

# Cantidades de registros a generar
CANTIDAD_USUARIOS = 300
CANTIDAD_EVENTOS = 30
SESIONES_POR_EVENTO = 5
PORCENTAJE_ASISTENCIA = 0.7  # 70% de usuarios se inscriben a eventos


def conectar_db():
    """Establece conexión con la base de datos PostgreSQL."""
    try:
        conn = psycopg2.connect(**DB_CONFIG)
        print("✓ Conexión exitosa a la base de datos")
        return conn
    except Exception as e:
        print(f"✗ Error al conectar con la base de datos: {e}")
        exit(1)


def limpiar_tablas(conn):
    """Limpia todas las tablas en orden inverso a las dependencias."""
    cursor = conn.cursor()
    tablas = [
        'respuesta_encuesta',
        'asistente_evento',
        'sesion_evento',
        'pregunta',
        'evento',
        'usuario',
    ]
    
    print("\n--- Limpiando tablas ---")
    for tabla in tablas:
        try:
            cursor.execute(f"TRUNCATE TABLE {tabla} RESTART IDENTITY CASCADE;")
            print(f"✓ Tabla '{tabla}' limpiada")
        except Exception as e:
            print(f"✗ Error al limpiar tabla '{tabla}': {e}")
    
    conn.commit()
    cursor.close()


def generar_curp():
    """Genera un CURP válido de formato."""
    letras = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'
    numeros = '0123456789'
    curp = ''.join(random.choices(letras, k=4))
    curp += ''.join(random.choices(numeros, k=6))
    curp += ''.join(random.choices(letras + numeros, k=8))
    return curp


def poblar_usuarios(conn, cantidad):
    """Pobla la tabla usuario con datos de ejemplo."""
    cursor = conn.cursor()
    usuarios = []
    
    print(f"\n--- Generando {cantidad} usuarios ---")
    
    # Obtener los IDs de los roles antes de crear usuarios
    cursor.execute("SELECT id, name FROM roles WHERE name IN ('Asistente', 'Organizador') ORDER BY name")
    roles_disponibles = cursor.fetchall()
    
    if not roles_disponibles:
        print("⚠ Advertencia: No se encontraron roles. Ejecuta los seeders primero.")
        cursor.close()
        return []
    
    roles_dict = {nombre: id_rol for id_rol, nombre in roles_disponibles}
    
    # Hash de password común para todos (bcrypt de "password")
    password_hash = hashpw('password'.encode('utf-8'), gensalt()).decode('utf-8')
    
    # Sets para evitar duplicados
    emails_used = set()
    curps_used = set()
    numeros_cuenta_used = set()
    numeros_trabajador_used = set()
    
    usuarios_con_roles = []  # Para guardar (usuario_data, rol_nombre, rol_id)
    
    for i in range(cantidad):
        nombre = fake.first_name()
        primer_apellido = fake.last_name()
        segundo_apellido = fake.last_name() if random.random() > 0.3 else None
        activo = random.choice(['S', 'N']) if random.random() > 0.9 else 'S'
        
        # Generar email único
        email = f"{nombre.lower()}.{primer_apellido.lower()}{i}@unam.mx"
        
        # Generar CURP único
        curp = None
        if random.random() > 0.2:
            while True:
                curp = generar_curp()
                if curp not in curps_used:
                    curps_used.add(curp)
                    break
        
        # Generar número de cuenta único
        numero_cuenta = None
        if random.random() > 0.5:
            while True:
                numero_cuenta = str(random.randint(300000000, 399999999))
                if numero_cuenta not in numeros_cuenta_used:
                    numeros_cuenta_used.add(numero_cuenta)
                    break
        
        # Generar número de trabajador único
        numero_trabajador = None
        if random.random() > 0.7:
            while True:
                numero_trabajador = str(random.randint(100000, 999999))
                if numero_trabajador not in numeros_trabajador_used:
                    numeros_trabajador_used.add(numero_trabajador)
                    break
        
        telefono = f"55{random.randint(10000000, 99999999)}" if random.random() > 0.3 else None
        
        # Asignar rol (80% Asistente, 20% Organizador)
        rand = random.random()
        rol_nombre = 'Asistente' if rand < 0.80 else 'Organizador'
        id_rol = roles_dict.get(rol_nombre)
        
        usuario_data = (
            nombre,
            primer_apellido,
            segundo_apellido,
            activo,
            email,
            curp,
            numero_cuenta,
            numero_trabajador,
            telefono,
            id_rol,
            password_hash,
            datetime.now(),
            datetime.now()
        )
        
        usuarios_con_roles.append((usuario_data, rol_nombre, id_rol))
    
    query = """
        INSERT INTO usuario (
            nombre, primer_apellido, segundo_apellido, activo, email,
            curp, numero_cuenta, numero_trabajador, telefono, id_rol, password,
            created_at, updated_at
        ) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)
        RETURNING id_usuario;
    """
    
    ids_usuarios = []
    usuarios_roles_info = []  # Para asignar en model_has_roles después
    contador_roles = {'Asistente': 0, 'Organizador': 0}
    
    for usuario_data, rol_nombre, id_rol in usuarios_con_roles:
        cursor.execute(query, usuario_data)
        id_usuario = cursor.fetchone()[0]
        ids_usuarios.append(id_usuario)
        usuarios_roles_info.append((id_usuario, rol_nombre, id_rol))
        contador_roles[rol_nombre] += 1
    
    conn.commit()
    print(f"✓ {len(ids_usuarios)} usuarios insertados con roles asignados")
    
    # Asignar también en model_has_roles (para compatibilidad con Spatie)
    asignar_roles_spatie(conn, usuarios_roles_info)
    
    print(f"✓ Distribución de roles:")
    print(f"  - Asistente: {contador_roles['Asistente']} usuarios (pueden inscribirse a eventos)")
    print(f"  - Organizador: {contador_roles['Organizador']} usuarios (pueden gestionar eventos)")
    
    cursor.close()
    return ids_usuarios


def asignar_roles_spatie(conn, usuarios_roles_info):
    """Asigna roles en la tabla model_has_roles de Spatie para compatibilidad."""
    cursor = conn.cursor()
    
    asignaciones = []
    for id_usuario, rol_nombre, id_rol in usuarios_roles_info:
        if id_rol:
            asignaciones.append((
                id_rol,                   # role_id
                'App\\Models\\Usuario',   # model_type
                id_usuario                # model_id
            ))
    
    query = """
        INSERT INTO model_has_roles (role_id, model_type, model_id)
        VALUES (%s, %s, %s)
        ON CONFLICT DO NOTHING;
    """
    
    execute_batch(cursor, query, asignaciones)
    conn.commit()
    cursor.close()
    print(f"✓ Roles también asignados en Spatie (model_has_roles) para compatibilidad")


def poblar_eventos(conn, cantidad):
    """Pobla la tabla evento con datos de ejemplo."""
    cursor = conn.cursor()
    eventos = []
    
    print(f"\n--- Generando {cantidad} eventos ---")
    
    nombres_eventos = [
        "Conferencia de Tecnología",
        "Taller de Inteligencia Artificial",
        "Seminario de Desarrollo Web",
        "Congreso de Robótica",
        "Curso de Python Avanzado",
        "Workshop de Machine Learning",
        "Hackathon de Innovación",
        "Simposio de Ciencia de Datos",
        "Jornada de Ciberseguridad",
        "Encuentro de Emprendedores Tech",
        "Summit de Cloud Computing",
        "Festival de Tecnología Educativa"
    ]
    
    lugares = [
        "Auditorio Principal",
        "Sala de Conferencias A",
        "Sala de Conferencias B",
        "Sala de Conferencias C",
        "Centro de Convenciones",
        "Teatro Universitario",
        "Sala Magna",
        "Auditorio de Ingeniería",
        "Auditorio Alfonso Caso",
        "Auditorio Justo Sierra",
        "Centro Cultural",
        "Sala de Usos Múltiples",
        "Sala Nezahualcóyotl",
        "Auditorio Paris Pishmish",
        "Sala Miguel Covarrubias",
        "Auditorio Raoul Fournier",
        "Centro de Exposiciones",
        "Sala de Seminarios",
        "Auditorio José Vasconcelos",
        "Teatro Juan Ruiz de Alarcón",
        "Sala Carlos Chávez",
        "Auditorio Simón Bolívar",
        "Centro de Innovación",
        "Sala Octavio Paz",
        "Auditorio Alberto Barajas"
    ]
    
    for i in range(cantidad):
        nombre = random.choice(nombres_eventos) + f" {2026 + (i // 4)}"
        
        # Generar fecha de inicio del evento
        fecha_inicio = fake.date_between(start_date='today', end_date='+1y')
        
        # Generar fecha de fin (el evento puede durar de 1 a 5 días)
        duracion_dias = random.randint(1, 5)
        fecha_fin = fecha_inicio + timedelta(days=duracion_dias - 1)
        
        lugar = random.choice(lugares)
        capacidad = random.choice([50, 100, 150, 200, 300, 500])
        
        eventos.append((
            nombre,
            fecha_inicio,
            fecha_fin,
            lugar,
            capacidad,
            datetime.now(),
            datetime.now()
        ))
    
    query = """
        INSERT INTO evento (
            nombre, fecha_inicio, fecha_fin, lugar, capacidad, created_at, updated_at
        ) VALUES (%s, %s, %s, %s, %s, %s, %s)
        RETURNING id_evento;
    """
    
    ids_eventos = []
    for evento in eventos:
        cursor.execute(query, evento)
        ids_eventos.append(cursor.fetchone()[0])
    
    conn.commit()
    cursor.close()
    print(f"✓ {len(ids_eventos)} eventos insertados")
    return ids_eventos


def poblar_sesiones(conn, ids_eventos, sesiones_por_evento):
    """Pobla la tabla sesion_evento con datos de ejemplo."""
    cursor = conn.cursor()
    sesiones = []
    
    print(f"\n--- Generando sesiones para {len(ids_eventos)} eventos ---")
    
    ponentes = [
        "Dr. Juan Pérez García",
        "Dra. María González López",
        "Ing. Carlos Rodríguez Martínez",
        "Lic. Ana Hernández Sánchez",
        "Dr. Luis Ramírez Torres",
        "Mtra. Patricia Flores Morales",
        "Mtro. Roberto Díaz Cruz",
        "Dra. Laura Jiménez Ruiz",
        "Dr. Fernando Martínez Silva",
        "Dra. Carmen Vargas Gutiérrez",
        "Ing. Miguel Ángel López Rojas",
        "Mtra. Diana Morales Vega",
        "Dr. Alejandro Sánchez Medina",
        "Dra. Gabriela Reyes Campos",
        "Mtro. Ricardo Torres Álvarez",
        "Lic. Mónica Castillo Núñez",
        "Dr. Eduardo Ramos Pérez",
        "Dra. Verónica Ortiz Mendoza",
        "Ing. Javier Moreno Castro",
        "Mtra. Sandra Herrera Delgado",
        "Dr. Arturo Guzmán Rivera",
        "Dra. Beatriz Silva Torres",
        "Mtro. Oscar Domínguez Santos",
        "Lic. Claudia Méndez Fuentes",
        "Dr. Rafael Cortés Aguilar",
        "Dra. Silvia Navarro Ríos",
        "Ing. Héctor Vázquez Lara",
        "Mtra. Norma Rojas Paredes",
        "Dr. Alberto Cruz Ramírez",
        "Dra. Teresa Guerrero León",
        "Mtro. Sergio Mendoza Flores",
        "Lic. Isabel Salinas Moreno",
        "Dr. Francisco Delgado Ortega",
        "Dra. Adriana Cervantes Luna",
        "Ing. Gerardo Peña Maldonado",
        "Mtra. Rosa Campos Cabrera",
        "Dr. Mario Escobar Muñoz",
        "Dra. Cristina Figueroa Rivas",
        "Mtro. Guillermo Solís Vargas",
        "Lic. Leticia Montoya Herrera"
    ]
    
    # Horarios posibles para las sesiones (inicio - fin)
    horarios_disponibles = [
        ("09:00", "11:00"),
        ("11:00", "13:00"),
        ("13:00", "15:00"),
        ("15:00", "17:00"),
        ("17:00", "19:00"),
        ("19:00", "21:00"),
        ("09:30", "11:30"),
        ("14:00", "16:00"),
        ("16:00", "18:00"),
        ("10:00", "12:00"),
    ]
    
    for id_evento in ids_eventos:
        # Obtener las fechas del evento
        cursor.execute("SELECT fecha_inicio, fecha_fin FROM evento WHERE id_evento = %s", (id_evento,))
        fecha_inicio, fecha_fin = cursor.fetchone()
        
        # Calcular los días del evento
        dias_evento = (fecha_fin - fecha_inicio).days + 1
        
        # Seleccionar horarios aleatorios para las sesiones
        horarios_evento = random.sample(horarios_disponibles, min(sesiones_por_evento, len(horarios_disponibles)))
        
        # Distribuir sesiones a lo largo de los días del evento
        for idx, (inicio_str, fin_str) in enumerate(horarios_evento):
            # Elegir un día dentro del rango del evento
            # Distribuir las sesiones proporcionalmente
            dia_offset = (idx * dias_evento) // sesiones_por_evento
            fecha_sesion = fecha_inicio + timedelta(days=min(dia_offset, dias_evento - 1))
            
            hora_inicio = datetime.strptime(inicio_str, "%H:%M").time()
            hora_fin = datetime.strptime(fin_str, "%H:%M").time()
            ponente = random.choice(ponentes)
            
            sesiones.append((
                id_evento,
                fecha_sesion,
                hora_inicio,
                hora_fin,
                ponente,
                datetime.now(),
                datetime.now()
            ))
    
    query = """
        INSERT INTO sesion_evento (
            id_evento, fecha, hora_inicio, hora_fin, ponente, created_at, updated_at
        ) VALUES (%s, %s, %s, %s, %s, %s, %s);
    """
    
    execute_batch(cursor, query, sesiones)
    conn.commit()
    cursor.close()
    print(f"✓ {len(sesiones)} sesiones insertadas")


def poblar_preguntas(conn):
    """Pobla la tabla pregunta con el catálogo estándar de satisfacción."""
    cursor = conn.cursor()
    
    # Catálogo estándar de preguntas de satisfacción para eventos
    preguntas_catalogo = [
        "¿Cómo calificarías el evento en general? (1-10)",
        "¿El contenido cumplió con tus expectativas?",
        "¿Recomendarías este evento a un colega?",
        "¿Cómo evalúas la calidad de los ponentes?",
        "¿La duración del evento fue adecuada?",
        "¿Las instalaciones fueron apropiadas?",
        "¿El material proporcionado fue útil?",
        "¿La organización del evento fue eficiente?",
        "¿La información recibida antes del evento fue clara?",
        "¿Qué tan útil fue el contenido para tu desarrollo profesional?",
        "¿Los horarios de las sesiones fueron convenientes?",
        "¿El sistema de registro fue sencillo?",
        "¿Consideras que el evento valió la pena?",
        "¿Participarías en futuros eventos similares?",
        "¿Cómo calificarías la atención del personal organizador?"
    ]
    
    print(f"\n--- Generando catálogo de {len(preguntas_catalogo)} preguntas de satisfacción ---")
    
    preguntas = []
    for pregunta_texto in preguntas_catalogo:
        preguntas.append((
            pregunta_texto,
            'S',  # Todas activas por defecto
            datetime.now(),
            datetime.now()
        ))
    
    query = """
        INSERT INTO pregunta (
            pregunta, activa, created_at, updated_at
        ) VALUES (%s, %s, %s, %s)
        RETURNING id_pregunta;
    """
    
    ids_preguntas = []
    for pregunta in preguntas:
        cursor.execute(query, pregunta)
        ids_preguntas.append(cursor.fetchone()[0])
    
    conn.commit()
    cursor.close()
    print(f"✓ {len(ids_preguntas)} preguntas de catálogo insertadas (aplicables a todos los eventos)")
    return ids_preguntas


def poblar_asistentes_y_respuestas(conn, ids_usuarios, ids_eventos, ids_preguntas, porcentaje):
    """Pobla las tablas asistente_evento y respuesta_encuesta."""
    cursor = conn.cursor()
    
    print(f"\n--- Generando inscripciones de asistentes ---")
    
    asistentes = []
    ids_asistentes = []
    
    for id_evento in ids_eventos:
        # Seleccionar un porcentaje aleatorio de usuarios para este evento
        num_asistentes = int(len(ids_usuarios) * porcentaje * random.uniform(0.5, 1.0))
        usuarios_evento = random.sample(ids_usuarios, num_asistentes)
        
        for id_usuario in usuarios_evento:
            fecha_registro = fake.date_between(start_date='-30d', end_date='today')
            asistencia = random.choice(['S', 'N'] if random.random() > 0.8 else ['S'])
            
            asistentes.append((
                id_usuario,
                id_evento,
                fecha_registro,
                asistencia,
                datetime.now(),
                datetime.now()
            ))
    
    query = """
        INSERT INTO asistente_evento (
            id_usuario, id_evento, fecha_registro, asistencia, created_at, updated_at
        ) VALUES (%s, %s, %s, %s, %s, %s)
        RETURNING id_asistente_evento;
    """
    
    for asistente in asistentes:
        try:
            cursor.execute(query, asistente)
            ids_asistentes.append(cursor.fetchone()[0])
        except Exception as e:
            print(f"  Advertencia: {e}")
    
    conn.commit()
    print(f"✓ {len(ids_asistentes)} inscripciones de asistentes insertadas")
    
    # Ahora poblar respuestas de encuesta
    print(f"\n--- Generando respuestas de encuestas ---")
    
    # Respuestas según el tipo de pregunta
    respuestas_escalas = ["10", "9", "8", "7", "6", "5", "4", "3", "2", "1"]
    respuestas_si_no = ["Sí", "No", "Tal vez"]
    respuestas_calidad = ["Excelente", "Muy bueno", "Bueno", "Regular", "Deficiente"]
    respuestas_opinion = ["Totalmente de acuerdo", "De acuerdo", "Neutral", "En desacuerdo", "Totalmente en desacuerdo"]
    
    respuestas = []
    for id_asistente in ids_asistentes:
        # Solo algunos asistentes contestan la encuesta (60%)
        if random.random() > 0.6:
            continue
            
        # Responder todas o casi todas las preguntas del catálogo
        num_respuestas = random.randint(len(ids_preguntas) - 3, len(ids_preguntas))
        preguntas_a_responder = random.sample(ids_preguntas, num_respuestas)
        
        for id_pregunta in preguntas_a_responder:
            # Obtener el texto de la pregunta para dar una respuesta apropiada
            cursor.execute("SELECT pregunta FROM pregunta WHERE id_pregunta = %s", (id_pregunta,))
            pregunta_texto = cursor.fetchone()[0].lower()
            
            # Seleccionar tipo de respuesta según la pregunta
            if "(1-10)" in pregunta_texto or "califica" in pregunta_texto:
                respuesta = random.choice(respuestas_escalas)
            elif "recomendarías" in pregunta_texto or "participarías" in pregunta_texto:
                respuesta = random.choice(respuestas_si_no)
            elif "calidad" in pregunta_texto or "evalúas" in pregunta_texto:
                respuesta = random.choice(respuestas_calidad)
            else:
                respuesta = random.choice(respuestas_opinion)
            
            respuestas.append((
                id_asistente,
                id_pregunta,
                respuesta,
                datetime.now(),
                datetime.now()
            ))
    
    query = """
        INSERT INTO respuesta_encuesta (
            id_asistente_evento, id_pregunta, respuesta, created_at, updated_at
        ) VALUES (%s, %s, %s, %s, %s);
    """
    
    execute_batch(cursor, query, respuestas)
    conn.commit()
    cursor.close()
    print(f"✓ {len(respuestas)} respuestas de encuesta insertadas")


def mostrar_resumen(conn):
    """Muestra un resumen de los datos insertados."""
    cursor = conn.cursor()
    
    print("\n" + "="*60)
    print("RESUMEN DE DATOS INSERTADOS")
    print("="*60)
    
    tablas = [
        ('usuario', 'id_usuario'),
        ('evento', 'id_evento'),
        ('sesion_evento', 'id_sesion'),
        ('pregunta', 'id_pregunta'),
        ('asistente_evento', 'id_asistente_evento'),
        ('respuesta_encuesta', 'id_respuesta_encuesta')
    ]
    
    for tabla, pk in tablas:
        cursor.execute(f"SELECT COUNT(*) FROM {tabla};")
        count = cursor.fetchone()[0]
        print(f"  {tabla:25} {count:5} registros")
    
    print("="*60)
    print("\n✓ Base de datos poblada exitosamente!")
    print("\nCredenciales de prueba:")
    print("  - Email: [cualquier usuario]@unam.mx")
    print("  - Password: password")
    print("\n")
    
    cursor.close()


def main():
    """Función principal."""
    print("="*60)
    print("SCRIPT DE POBLACIÓN DE BASE DE DATOS")
    print("Sistema de Gestión de Eventos")
    print("="*60)
    
    # Conectar a la base de datos
    conn = conectar_db()
    
    try:
        # Limpiar tablas existentes
        limpiar_tablas(conn)
        
        # Poblar tablas en orden de dependencias
        ids_usuarios = poblar_usuarios(conn, CANTIDAD_USUARIOS)
        ids_eventos = poblar_eventos(conn, CANTIDAD_EVENTOS)
        poblar_sesiones(conn, ids_eventos, SESIONES_POR_EVENTO)
        ids_preguntas = poblar_preguntas(conn)
        poblar_asistentes_y_respuestas(conn, ids_usuarios, ids_eventos, ids_preguntas, PORCENTAJE_ASISTENCIA)
        
        # Mostrar resumen
        mostrar_resumen(conn)
        
    except Exception as e:
        print(f"\n✗ ERROR durante la ejecución: {e}")
        print("✗ Realizando rollback de todas las operaciones...")
        conn.rollback()
        print("✗ Rollback completado. No se guardaron cambios en la base de datos.")
        raise
    finally:
        conn.close()
        print("Conexión cerrada.")


if __name__ == "__main__":
    main()
