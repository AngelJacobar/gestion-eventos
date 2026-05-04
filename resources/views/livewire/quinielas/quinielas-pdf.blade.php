<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quinielas Registradas</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            font-size: 9px;
            padding: 10px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 15px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        
        .header-content {
            display: table;
            margin: 0 auto;
        }
        
        .logo {
            height: 50px;
            vertical-align: middle;
            margin-right: 15px;
        }
        
        .header-text {
            display: inline-block;
            vertical-align: middle;
        }
        
        .header h1 {
            font-size: 18px;
            color: #2c3e50;
            margin-bottom: 5px;
        }
        
        .header p {
            font-size: 10px;
            color: #7f8c8d;
        }
        
        .info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 9px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        
        th, td {
            border: 1px solid #bdc3c7;
            padding: 4px 3px;
            text-align: center;
            font-size: 8px;
        }
        
        thead th {
            background-color: #34495e;
            color: white;
            font-weight: bold;
            font-size: 8px;
            padding: 5px 3px;
        }
        
        tbody tr:nth-child(even) {
            background-color: #ecf0f1;
        }
        
        tbody tr:hover {
            background-color: #d5dbdb;
        }
        
        .nombre-col {
            text-align: left;
            width: 15%;
        }
        
        .telefono-col {
            width: 10%;
        }
        
        .pronostico-col {
            width: 5%;
            font-weight: bold;
        }
        
        .puntaje-col {
            width: 6%;
            font-weight: bold;
            background-color: #f39c12;
            color: white;
        }
        
        .footer {
            margin-top: 15px;
            padding-top: 10px;
            border-top: 1px solid #bdc3c7;
            text-align: center;
            font-size: 8px;
            color: #7f8c8d;
        }
        
        .total-quinielas {
            background-color: #27ae60;
            color: white;
            padding: 5px;
            margin-bottom: 10px;
            text-align: center;
            font-weight: bold;
            border-radius: 3px;
        }
        
        .partido-header {
            font-size: 7px;
            line-height: 1.1;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        /* Estilos para pronósticos */
        .pronostico-L { color: #000; font-weight: bold; }
        .pronostico-V { color: #000; font-weight: bold; }
        .pronostico-E { color: #000; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-content">
            <img src="{{ public_path('img/logo.png') }}" alt="Logo" class="logo">
        </div>
    </div>
    
    <div class="info">
        <div>
            <strong>Total de Quinielas:</strong> {{ $quinielas->count() }}
        </div>
        <div>
            <strong>Fecha de Exportación:</strong> {{ $fechaExportacion }}
        </div>
    </div>
    
    @if($quinielas->count() > 0)
        <table>
            <thead>
                <tr>
                    <th class="nombre-col">Nombre</th>
                    
                    @foreach($partidos as $partido)
                        <th class="pronostico-col partido-header" title="{{ $partido->equipo_local }} vs {{ $partido->equipo_visitante }}">
                            <div style="writing-mode: vertical-rl; text-orientation: mixed; white-space: nowrap;">
                                {{ $partido->equipo_local }} vs {{ $partido->equipo_visitante }}
                            </div>
                        </th>
                    @endforeach
                    
                    <th class="puntaje-col">Puntos</th>
                </tr>
            </thead>
            <tbody>
                @foreach($quinielas as $quiniela)
                    <tr>
                        <td class="nombre-col">{{ $quiniela->nombre }}</td>
                        
                        @for($i = 1; $i <= 9; $i++)
                            @php
                                $pronostico = $quiniela->{"pronostico_{$i}"};
                            @endphp
                            <td class="pronostico-col pronostico-{{ $pronostico }}">
                                {{ $pronostico ?? '-' }}
                            </td>
                        @endfor
                        
                        <td class="puntaje-col">{{ $quiniela->puntaje_total }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
        <div class="footer">
            <p><strong>Leyenda:</strong> L = Gana Local | V = Gana Visitante | E = Empate</p>
            <p>Documento generado automáticamente por el Sistema de Gestión de Eventos</p>
            <p>© {{ date('Y') }} - Todos los derechos reservados</p>
        </div>
    @else
        <div style="text-align: center; padding: 20px; background-color: #f1c40f; color: #333;">
            <strong>⚠️ No hay quinielas registradas para exportar</strong>
        </div>
    @endif
</body>
</html>
