<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $permisos = [
            'create-compra',
            'read-compra',
            'update-compra',
            'delete-compra',
            'create-venta',
            'read-venta',
            'update-venta',
            'delete-venta',
            'read-camara',
            'create-caja',
            'read-caja',
            'update-caja',
            'delete-caja',
            'read-dashboard',
            'create-ajustes',
            'read-ajustes',
            'update-ajustes',
            'delete-ajustes'
        ];

        foreach ($permisos as $permiso) {
            Permission::firstOrCreate(['name' => $permiso]);
        }

        Role::create(['name' => 'admin'])->givePermissionTo(Permission::all());

        $roleViewer = Role::firstOrCreate(['name' => 'viewer']);

        $roleViewer->syncPermissions([
            'read-compra',
            'read-venta',
            'read-camara',
            'read-caja',
        ]);

        $rolecol = Role::firstOrCreate(['name' => 'colaborador-1']);

        $rolecol->syncPermissions([
            'create-compra',
            'read-compra',
            'update-compra',
            'delete-compra',

            'create-venta',
            'read-venta',
            'update-venta',
            'delete-venta',

            'read-camara',

            'create-caja',
            'read-caja',
            'update-caja',
            'delete-caja',
        ]);

    }
}
