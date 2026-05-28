<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quinielas 72 Partidos</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            font-size: 7px;
            padding: 8px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 10px;
            border-bottom: 2px solid #333;
            padding-bottom: 8px;
        }
        
        .header h1 {
            font-size: 16px;
            color: #2c3e50;
            margin-bottom: 3px;
        }
        
        .header p {
            font-size: 9px;
            color: #7f8c8d;
        }
        
        .info {
            margin-bottom: 8px;
            font-size: 8px;
            display: flex;
            justify-content: space-between;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
        }
        
        th, td {
            border: 1px solid #bdc3c7;
            padding: 2px 1px;
            text-align: center;
            font-size: 6px;
        }
        
        thead th {
            background-color: #34495e;
            color: white;
            font-weight: bold;
            font-size: 6px;
            padding: 3px 1px;
            writing-mode: vertical-rl;
            text-orientation: mixed;
            white-space: nowrap;
            height: 80px;
        }
        
        thead th.nombre-col {
            writing-mode: horizontal-tb;
            height: auto;
            width: 80px;
        }
        
        thead th.puntaje-col {
            writing-mode: horizontal-tb;
            height: auto;
            width: 30px;
        }
        
        tbody tr:nth-child(even) {
            background-color: #ecf0f1;
        }
        
        .nombre-col {
            text-align: left;
            font-size: 7px;
            padding: 2px 3px;
        }
        
        .pronostico-col {
            font-weight: bold;
            font-size: 6px;
        }
        
        .puntaje-col {
            font-weight: bold;
            background-color: #f39c12;
            color: white;
            font-size: 7px;
        }
        
        .puntaje-ganadora {
            background-color: #2563eb !important;
        }
        
        .footer {
            margin-top: 10px;
            padding-top: 8px;
            border-top: 1px solid #bdc3c7;
            text-align: center;
            font-size: 7px;
            color: #7f8c8d;
        }
        
        .pronostico-L { color: #000; }
        .pronostico-V { color: #000; }
        .pronostico-E { color: #000; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Registro de Quinielas - 72 Partidos</h1>
        <p>Fecha de Exportación: {{ $fechaExportacion }}</p>
    </div>
    
    <div class="info">
        <div><strong>Total de Quinielas:</strong> {{ $quinielas->count() }}</div>
        <div><strong>Puntaje Máximo:</strong> {{ $puntajeMaximo }} / 72</div>
        <div><strong>Ganadores:</strong> {{ $quinielas->where('puntaje_total', $puntajeMaximo)->count() }}</div>
    </div>
    
    @if($quinielas->count() > 0)
        <table>
            <thead>
                <tr>
                    <th class="nombre-col">Nombre</th>
                    
                    @foreach($partidos as $partido)
                        <th class="pronostico-col" title="{{ $partido->equipo_local }} vs {{ $partido->equipo_visitante }}">
                            P{{ $partido->numero_partido }}
                        </th>
                    @endforeach
                    
                    <th class="puntaje-col">Pts</th>
                </tr>
            </thead>
            <tbody>
                @foreach($quinielas as $quiniela)
                    <tr>
                        <td class="nombre-col">{{ $quiniela->nombre }}</td>
                        
                        @foreach($partidos as $partido)
                            @php
                                $detalle = $quiniela->detalles->where('id_partido_72', $partido->id_partido_72)->first();
                                $pronostico = $detalle ? $detalle->pronostico : '-';
                            @endphp
                            <td class="pronostico-col pronostico-{{ $pronostico }}">
                                {{ $pronostico }}
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
            <p><strong>Leyenda:</strong> L = Gana Local | V = Gana Visitante | E = Empate | Puntaje máximo: 72 puntos</p>
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
