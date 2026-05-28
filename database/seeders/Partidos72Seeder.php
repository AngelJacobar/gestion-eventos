<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Partidos72Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $equipos = [
            'América', 'Guadalajara', 'Cruz Azul', 'Pumas', 'Tigres', 'Monterrey',
            'Santos', 'León', 'Toluca', 'Pachuca', 'Atlas', 'Necaxa',
            'Querétaro', 'Puebla', 'Mazatlán', 'Tijuana', 'Juárez', 'San Luis',
            'Barcelona', 'Real Madrid', 'Manchester United', 'Liverpool', 'Bayern Munich', 'PSG',
            'Juventus', 'Inter Milan', 'AC Milan', 'Chelsea', 'Arsenal', 'Manchester City',
            'Borussia Dortmund', 'Atlético Madrid', 'Sevilla', 'Valencia', 'Napoli', 'Roma',
            'Lazio', 'Atalanta', 'Benfica', 'Porto', 'Sporting', 'Ajax',
            'PSV', 'Feyenoord', 'Celtic', 'Rangers', 'Galatasaray', 'Fenerbahce',
            'Boca Juniors', 'River Plate', 'Flamengo', 'Palmeiras', 'Corinthians', 'São Paulo',
            'Santos FC', 'Gremio', 'Internacional', 'Atlético Mineiro', 'Cruzeiro', 'Fluminense',
            'Vasco da Gama', 'Botafogo', 'Colo-Colo', 'Universidad de Chile', 'Peñarol', 'Nacional',
            'Olimpia', 'Cerro Porteño', 'Millonarios', 'Independiente Santa Fe', 'Emelec', 'Barcelona SC'
        ];

        $partidos = [];
        
        // Generar 72 partidos únicos
        for ($i = 1; $i <= 72; $i++) {
            // Seleccionar dos equipos diferentes
            $indiceLocal = ($i * 2 - 2) % count($equipos);
            $indiceVisitante = ($i * 2 - 1) % count($equipos);
            
            // Asegurar que no sean el mismo equipo
            if ($indiceLocal === $indiceVisitante) {
                $indiceVisitante = ($indiceVisitante + 1) % count($equipos);
            }
            
            $partidos[] = [
                'numero_partido' => $i,
                'equipo_local' => $equipos[$indiceLocal],
                'equipo_visitante' => $equipos[$indiceVisitante],
                'resultado' => null, // Sin resultado inicialmente
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('partidos_72')->insert($partidos);
    }
}
