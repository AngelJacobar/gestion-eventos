<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quinielas con Resultados</title>
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
            background-color: #f8f9fa;
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
            color: #000;
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
        
        .partido-header {
            font-size: 7px;
            line-height: 1.1;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            color: white;
        }
        
        /* Recuadro de resultado en encabezado */
        .resultado-recuadro {
            width: 12px;
            height: 12px;
            border: 1px solid #333;
            margin: 2px auto;
            display: block;
        }
        
        /* Colores según el resultado */
        .correcto {
            background-color: #28a745 !important;
            color: white !important;
        }
        
        .incorrecto {
            background-color: #dc3545 !important;
            color: white !important;
        }
        
        .pendiente {
            background-color: #fff3cd !important;
            color: #000 !important;
        }
        
        .leyenda {
            text-align: center;
            margin-bottom: 10px;
            font-size: 9px;
        }
        
        .leyenda-item {
            display: inline-block;
            margin: 0 10px;
            vertical-align: middle;
        }
        
        .leyenda-color {
            width: 15px;
            height: 15px;
            border: 1px solid #333;
            display: inline-block;
            vertical-align: middle;
            margin-left: 5px;
        }
        
        .color-verde {
            background-color: #28a745;
        }
        
        .color-rojo {
            background-color: #dc3545;
        }
        
        .color-amarillo {
            background-color: #fff3cd;
        }
        
        .puntaje-ganadora {
            background-color: #2563eb !important;
            color: white !important;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-content">
            <img src="{{ public_path('img/logo.png') }}" alt="Logo" class="logo">
            <div class="header-text">
                <h1>Quinielas con Resultados</h1>
            </div>
        </div>
    </div>
    
    <div style="margin-bottom: 10px; overflow: hidden;">
        <!-- Columna izquierda: Información -->
        <div style="float: left; width: 28%; margin-right: 2%; font-size: 8px;">
            <div style="margin-bottom: 6px;">
                <strong>Total de Quinielas:</strong> {{ $quinielas->count() }}
            </div>
            <div style="margin-bottom: 6px;">
                <strong>Fecha de Exportación:</strong> {{ $fechaExportacion }}
            </div>
            <div style="margin-bottom: 6px;">
                <strong>Monto del Premio:</strong> ${{ number_format($quinielas->count() * 20 - $quinielas->count() * 20 * 0.20, 2) }}
            </div>
            <div style="margin-bottom: 6px;">
                <strong>Monto del Premio de Quiniela Perfecta:</strong> ${{ number_format($quinielas->count() * 20 * 0.05, 2)+54 }}
            </div>
        </div>
        
        <div style="float: right; width: 30%;">
            <h3 style="font-size: 10px; margin-bottom: 5px; text-align: center; color: #2c3e50;">Calendario de Partidos</h3>
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th style="background-color: #34495e; color: white; padding: 2px 3px; text-align: left; font-size: 8px; width: 50%;">Partido</th>
                        <th style="background-color: #34495e; color: white; padding: 2px 3px; text-align: center; font-size: 8px; width: 50%;">Fecha y Hora</th>
                    </tr>
                </thead>
                <tbody>
                    <tr style="background-color: #f8f9fa;">
                        <td style="padding: 2px 3px; border: 1px solid #bdc3c7; font-size: 8px;">Barcelona F vs Lyonnes F</td>
                        <td style="padding: 2px 3px; border: 1px solid #bdc3c7; text-align: center; font-size: 8px;">Sáb 23/05 10:00am</td>
                    </tr>
                    <tr>
                        <td style="padding: 2px 3px; border: 1px solid #bdc3c7; font-size: 8px;">B. Munich vs Stuttgart</td>
                        <td style="padding: 2px 3px; border: 1px solid #bdc3c7; text-align: center; font-size: 8px;">Sáb 23/05 12:00pm</td>
                    </tr>
                    <tr style="background-color: #f8f9fa;">
                        <td style="padding: 2px 3px; border: 1px solid #bdc3c7; font-size: 8px;">Girona vs Elche</td>
                        <td style="padding: 2px 3px; border: 1px solid #bdc3c7; text-align: center; font-size: 8px;">Sáb 23/05 1:00pm</td>
                    </tr>   
                    <tr>
                        <td style="padding: 2px 3px; border: 1px solid #bdc3c7; font-size: 8px;">Vitória BA vs Inter P.A.</td>
                        <td style="padding: 2px 3px; border: 1px solid #bdc3c7; text-align: center; font-size: 8px;">Sáb 23/05 2:00pm</td>
                    </tr>
                    <tr style="background-color: #f8f9fa;">
                        <td style="padding: 2px 3px; border: 1px solid #bdc3c7; font-size: 8px;">Minnesota vs Salt Lake</td>
                        <td style="padding: 2px 3px; border: 1px solid #bdc3c7; text-align: center; font-size: 8px;">Sáb 23/05 2:30pm</td>
                    </tr>
                    <tr>
                        <td style="padding: 2px 3px; border: 1px solid #bdc3c7; font-size: 8px;">Charlotte vs New England</td>
                        <td style="padding: 2px 3px; border: 1px solid #bdc3c7; text-align: center; font-size: 8px;">Sáb 23/05 5:30pm</td>
                    </tr>
                    <tr style="background-color: #f8f9fa;">
                        <td style="padding: 2px 3px; border: 1px solid #bdc3c7; font-size: 8px;">Shimizu vs Gamba Osaka</td>
                        <td style="padding: 2px 3px; border: 1px solid #bdc3c7; text-align: center; font-size: 8px;">Dom 24/05 8:00am</td>
                    </tr>
                    <tr>
                        <td style="padding: 2px 3px; border: 1px solid #bdc3c7; font-size: 8px;">Spartak vs Krasnodar</td>
                        <td style="padding: 2px 3px; border: 1px solid #bdc3c7; text-align: center; font-size: 8px;">Dom 24/05 10:00am</td>
                    </tr>
                    <tr style="background-color: #f8f9fa;">
                        <td style="padding: 2px 3px; border: 1px solid #bdc3c7; font-size: 8px;">Pumas vs Cruz Azul</td>
                        <td style="padding: 2px 3px; border: 1px solid #bdc3c7; text-align: center; font-size: 8px;">Dom 24/05 7:00pm</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div style="clear: both;"></div>
    </div>
    
    @if($quinielas->count() > 0)
        <table>
            <thead>
                <tr>
                    <th class="nombre-col">Nombre</th>
                    
                    @foreach($partidos as $partido)
                        @php
                            // Determinar el color del recuadro según si tiene resultado
                            $claseRecuadro = 'pendiente';
                            if ($partido->resultado !== null && $partido->resultado !== '') {
                                $claseRecuadro = 'correcto'; // Verde si tiene resultado
                            }
                        @endphp
                        <th class="pronostico-col partido-header" title="{{ $partido->equipo_local }} vs {{ $partido->equipo_visitante }}">
                            <div style="writing-mode: vertical-rl; text-orientation: mixed; white-space: nowrap;">
                                {{ $partido->equipo_local }} vs {{ $partido->equipo_visitante }}
                            </div>
                            <div class="resultado-recuadro {{ $claseRecuadro }}"></div>
                        </th>
                    @endforeach
                    
                    <th class="puntaje-col">Puntos</th>
                </tr>
            </thead>
            <tbody>
                @foreach($quinielas as $quiniela)
                    <tr>
                        <td class="nombre-col">{{ $quiniela->nombre }}</td>
                        
                        @foreach($partidos as $index => $partido)
                            @php
                                $numeroPronostico = $index + 1;
                                $pronostico = $quiniela->{"pronostico_{$numeroPronostico}"};
                                $resultado = $partido->resultado;
                                
                                // Determinar la clase CSS según el resultado
                                $claseResultado = 'pendiente'; // Por defecto pendiente
                                
                                if ($resultado !== null && $resultado !== '') {
                                    // Si hay resultado, comparar con el pronóstico
                                    if ($pronostico === $resultado) {
                                        $claseResultado = 'correcto';
                                    } else {
                                        $claseResultado = 'incorrecto';
                                    }
                                }
                            @endphp
                            <td class="pronostico-col {{ $claseResultado }}">
                                {{ $pronostico ?? '-' }}
                            </td>
                        @endforeach
                        
                        <td class="puntaje-col {{ $quiniela->puntaje_total == $puntajeMaximo && $puntajeMaximo > 0 ? 'puntaje-ganadora' : '' }}">
                            {{ $quiniela->puntaje_total }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
        <div class="footer">
            <div class="leyenda">
                <span class="leyenda-item">
                    Correcto <span class="leyenda-color color-verde"></span>
                </span>
                <span class="leyenda-item">
                    Incorrecto <span class="leyenda-color color-rojo"></span>
                </span>
                <span class="leyenda-item">
                    Pendiente <span class="leyenda-color color-amarillo"></span>
                </span>
            </div>
            <p style="margin-top: 10px;"><strong>Pronósticos:</strong> L = Gana Local | V = Gana Visitante | E = Empate</p>
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
