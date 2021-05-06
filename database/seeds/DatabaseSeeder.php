<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        \Illuminate\Support\Facades\DB::table('users')->insert([
            'name' => 'Admin',
            'surname' => 'Admin',
            'username' => 'admin',
            'email' => 'admin'.'@admin.com',
            'password' => Hash::make('admin'),
        ]);

        $roles = [[
            'name' => 'Worker',
        ],[
            'name' => 'Manager',
        ],[
            'name' => 'Administrator',
        ]];

        foreach ($roles as $role) {
            \Illuminate\Support\Facades\DB::table('roles')->insert($role);
        }

        $types = [[
            'name' => 'Hardware',
        ],[
            'name' => 'Software',
        ],[
            'name' => 'Procedures',
        ],[
            'name' => 'Connections',
        ]];

        foreach ($types as $type) {
            \Illuminate\Support\Facades\DB::table('types')->insert($type);
        }

        $subtypes = [[
            'name' => 'Workplaces',
        ],[
            'name' => 'Servers',
        ],[
            'name' => 'Other',
        ]];

        foreach ($subtypes as $subtype) {
            \Illuminate\Support\Facades\DB::table('subtypes')->insert($subtype);
        }


    }
}
