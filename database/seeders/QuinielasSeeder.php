<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuinielasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $nombres = [
            'Juan', 'María', 'Carlos', 'Ana', 'Luis', 'Carmen', 'José', 'Laura', 'Miguel', 'Sofía',
            'Pedro', 'Isabel', 'Antonio', 'Lucía', 'Javier', 'Elena', 'Francisco', 'Patricia', 'Manuel', 'Rosa',
            'David', 'Teresa', 'Daniel', 'Beatriz', 'Rafael', 'Marta', 'Alejandro', 'Cristina', 'Fernando', 'Sara',
            'Jorge', 'Pilar', 'Roberto', 'Rocío', 'Sergio', 'Silvia', 'Alberto', 'Raquel', 'Raúl', 'Nuria',
            'Óscar', 'Mónica', 'Pablo', 'Alicia', 'Enrique', 'Verónica', 'Ricardo', 'Natalia', 'Víctor', 'Diana'
        ];

        $apellidos = [
            'García', 'Rodríguez', 'Martínez', 'López', 'González', 'Hernández', 'Pérez', 'Sánchez', 'Ramírez', 'Torres',
            'Flores', 'Rivera', 'Gómez', 'Díaz', 'Cruz', 'Morales', 'Reyes', 'Gutiérrez', 'Ortiz', 'Jiménez',
            'Ruiz', 'Mendoza', 'Álvarez', 'Castillo', 'Romero', 'Herrera', 'Medina', 'Aguilar', 'Vargas', 'Castro'
        ];

        $pronosticosPosibles = ['L', 'V', 'E'];
        $quinielas = [];

        // Generar 100 quinielas con datos aleatorios
        for ($i = 1; $i <= 100; $i++) {
            $nombre = $nombres[array_rand($nombres)];
            $apellido1 = $apellidos[array_rand($apellidos)];
            $apellido2 = $apellidos[array_rand($apellidos)];
            $nombreCompleto = "{$nombre} {$apellido1} {$apellido2}";
            
            // Si hay más de una quiniela con el mismo nombre, agregar sufijo
            if ($i % 10 == 0) {
                $nombreCompleto .= ' - Q' . ($i % 5 + 1);
            }
            
            // Generar teléfono aleatorio (555 + 7 dígitos)
            $telefono = '555' . str_pad(rand(1000000, 9999999), 7, '0', STR_PAD_LEFT);
            
            // Generar puntaje aleatorio (0-9 puntos, con distribución realista)
            // La mayoría tendrá entre 2-6 puntos, algunos tendrán más
            $random = rand(1, 100);
            if ($random <= 5) {
                $puntaje = 9; // 5% con puntaje perfecto
            } elseif ($random <= 15) {
                $puntaje = 8; // 10% con 8 puntos
            } elseif ($random <= 30) {
                $puntaje = 7; // 15% con 7 puntos
            } elseif ($random <= 50) {
                $puntaje = 6; // 20% con 6 puntos
            } elseif ($random <= 70) {
                $puntaje = 5; // 20% con 5 puntos
            } elseif ($random <= 85) {
                $puntaje = 4; // 15% con 4 puntos
            } elseif ($random <= 95) {
                $puntaje = 3; // 10% con 3 puntos
            } else {
                $puntaje = rand(0, 2); // 5% con 0-2 puntos
            }
            
            $quiniela = [
                'jornada' => 'Jornada 1',
                'nombre' => $nombreCompleto,
                'telefono' => $telefono,
                'puntaje_total' => $puntaje,
                'estatus' => 'S',
                'fecha_registro' => now()->subMinutes(rand(0, 1440)), // Fechas variadas en las últimas 24 horas
                'created_at' => now(),
                'updated_at' => now(),
            ];
            
            // Generar 9 pronósticos aleatorios
            for ($j = 1; $j <= 9; $j++) {
                $quiniela["pronostico_{$j}"] = $pronosticosPosibles[array_rand($pronosticosPosibles)];
            }
            
            $quinielas[] = $quiniela;
        }

        // Insertar todas las quinielas
        foreach ($quinielas as $quiniela) {
            DB::table('quinielas')->insert($quiniela);
        }
    }
}
