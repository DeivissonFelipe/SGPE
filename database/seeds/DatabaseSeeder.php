<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(CursoTableSeeder::class);
        $this->call(DepartamentoTableSeeder::class);
        $this->call(DisciplinaTableSeeder::class);
        $this->call(SemestreSeeder::class);
        // $this->call(PlanoSeeder::class);
    }
}
