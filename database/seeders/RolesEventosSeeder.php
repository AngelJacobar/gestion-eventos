<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesEventosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear roles para el sistema de gestión de eventos
        $roles = [
            [
                'name' => 'Invitado',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Asistente',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Organizador',
                'guard_name' => 'web',
            ],
        ];

        foreach ($roles as $roleData) {
            Role::firstOrCreate(
                ['name' => $roleData['name'], 'guard_name' => $roleData['guard_name']],
                $roleData
            );
        }

        $this->command->info('Roles de eventos creados: Invitado, Asistente, Organizador');
    }
}
