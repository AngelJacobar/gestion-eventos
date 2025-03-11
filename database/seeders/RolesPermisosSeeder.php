<?php

namespace Database\Seeders;

use App\Models\Usuario;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesPermisosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'administrador']);

        Permission::create(['name' => 'registrar-usuario']);
        Permission::create(['name' => 'consultar-listado-usuarios']);
        Permission::create(['name' => 'cambiar-estatus-usuario']);

        Permission::create(['name' => 'registrar-rol']);
        Permission::create(['name' => 'consultar-listado-roles']);

        $role = Role::findByName('administrador');

        $role->givePermissionTo('registrar-usuario');
        $role->givePermissionTo('consultar-listado-usuarios');
        $role->givePermissionTo('cambiar-estatus-usuario');

        $role->givePermissionTo('registrar-rol');
        $role->givePermissionTo('consultar-listado-roles');

        $adminUser = Usuario::create([
            'nombre' => 'Admin',
            'primer_apellido' => 'Admin',
            'segundo_apellido' => 'Admin',
            'email' => 'admin@mail.com',
            'curp' => 'AAAA000000AAAAAA00',
            'password' => bcrypt('password'),
        ]);

        $adminUser->assignRole('administrador');
    }
}
