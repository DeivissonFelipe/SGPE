<?php

use Illuminate\Database\Seeder;
use App\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $role_admin = new Role();
        $role_admin->name = 'Admin';
        $role_admin->description = 'Um Admin';
        $role_admin->save();

        $role_professor = new Role();
        $role_professor->name = 'Professor';
        $role_professor->description = 'Professor do campus ICEA';
        $role_professor->save();

    }
}
