<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use function Nette\Utils\save;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRole=Role::create(["name"=>"admin"]);
        $admin=User::factory()->create(["email"=>"admin@gmail.com"]);
        $admin->assignRole($adminRole);
        $subAdminRole=Role::create(["name"=>"sub-admin"]);
        $subAdmin=User::factory()->create();
        $subAdmin->assignRole($subAdminRole);
        $employee=Role::create(["name"=>"employee"]);
        $marketing= Department::create(["name"=>"Marketing"]);
        $hr=Department::create(["name"=>"HR"]);
        $engineering=Department::create(["name"=>"Engineering"]);




    }
}
