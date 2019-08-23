<?php

namespace Ipsum\Admin\database\seeds;

use Illuminate\Database\Seeder;
use Ipsum\Admin\app\Models\Admin;

class AdminsTableSeeder extends Seeder
{
    public function run()
    {
        Admin::create(
            array(
                'id' => 1,
                'name' => 'Admin',
                'firstname' => 'admin',
                'email' => 'admin@example.com',
                'password' => bcrypt('admin'),
                'role' => '1',
                'acces' => '',
                'remember_token' => '',
            )
        );

        Admin::create(
            array(
                'id' => 2,
                'name' => 'User',
                'firstname' => 'User',
                'email' => 'user@example.com',
                'password' => bcrypt('demo'),
                'role' => '2',
                'acces' => '',
                'remember_token' => '',
            )
        );

    }
}
