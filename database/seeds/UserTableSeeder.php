<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;
use Faker\Factory as Faker;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_admin = Role::where('name', 'Admin')->first();
        $role_professor = Role::where('name', 'Professor')->first();
        // $faker = Faker::create('App\User');
        // for($i =0; $i < 30; $i++){
        //     DB::table('users')->insert([
        //         'name' => $faker->name,
        //         'email' => $faker->unique()->freeEmail, 
        //         'matricula' => $faker->randomNumber(6),
        //         'password' => bcrypt(str_random(10)),
        //     ]);
        // }
        //<------------------ADMIN---------------------------->        
        $admin = new User();
        $admin->name = 'Administrador1';
        $admin->email = 'admin1@gmail.com';
        $admin->matricula = '0000001';
        $admin->password = bcrypt('1234');
        $admin->save();
        $admin->roles()->attach($role_admin);
        $admin->roles()->attach($role_professor);
        
        $admin2 = new User();
        $admin2->name = 'Administrador2';
        $admin2->email = 'admin2@gmail.com';
        $admin2->matricula = '0000002';
        $admin2->password = bcrypt('1234');
        $admin2->save();
        $admin2->roles()->attach($role_admin);
        $admin2->roles()->attach($role_professor);

        $admin3 = new User();
        $admin3->name = 'Administrador3';
        $admin3->email = 'admin3@gmail.com';
        $admin3->matricula = '0000003';
        $admin3->password = bcrypt('1234');
        $admin3->save();
        $admin3->roles()->attach($role_admin);
        $admin3->roles()->attach($role_professor);

        $admin4 = new User();
        $admin4->name = 'Administrador4';
        $admin4->email = 'admin4@gmail.com';
        $admin4->matricula = '0000004';
        $admin4->password = bcrypt('1234');
        $admin4->save();
        $admin4->roles()->attach($role_admin);
        $admin4->roles()->attach($role_professor);

        $admin5 = new User();
        $admin5->name = 'Administrador5';
        $admin5->email = 'admin5@gmail.com';
        $admin5->matricula = '0000005';
        $admin5->password = bcrypt('1234');
        $admin5->save();
        $admin5->roles()->attach($role_admin);
        $admin5->roles()->attach($role_professor);
        
        //<------------------PROFESSOR---------------------------->        

        $professor = new User();
        $professor->name = 'Professor1';
        $professor->email = 'professor1@gmail.com';
        $professor->matricula = '0000006';
        $professor->password = bcrypt('1234');
        $professor->save();
        $professor->roles()->attach($role_professor);

        $professor2 = new User();
        $professor2->name = 'Professor2';
        $professor2->email = 'professor2@gmail.com';
        $professor2->matricula = '0000007';
        $professor2->password = bcrypt('1234');
        $professor2->save();
        $professor2->roles()->attach($role_professor);

        $professor3 = new User();
        $professor3->name = 'Professor3';
        $professor3->email = 'professor3@gmail.com';
        $professor3->matricula = '0000008';
        $professor3->password = bcrypt('1234');
        $professor3->save();
        $professor3->roles()->attach($role_professor);

        $professor4 = new User();
        $professor4->name = 'Professor4';
        $professor4->email = 'professor4@gmail.com';
        $professor4->matricula = '0000009';
        $professor4->password = bcrypt('1234');
        $professor4->save();
        $professor4->roles()->attach($role_professor);

        $professor5 = new User();
        $professor5->name = 'Professor5';
        $professor5->email = 'professor5@gmail.com';
        $professor5->matricula = '0000010';
        $professor5->password = bcrypt('1234');
        $professor5->save();
        $professor5->roles()->attach($role_professor);

        $professor6 = new User();
        $professor6->name = 'Professor6';
        $professor6->email = 'professor6@gmail.com';
        $professor6->matricula = '0000011';
        $professor6->password = bcrypt('1234');
        $professor6->save();
        $professor6->roles()->attach($role_professor);

        $professor7 = new User();
        $professor7->name = 'Professor7';
        $professor7->email = 'professor7@gmail.com';
        $professor7->matricula = '0000012';
        $professor7->password = bcrypt('1234');
        $professor7->save();
        $professor7->roles()->attach($role_professor);

        $professor8 = new User();
        $professor8->name = 'Professor8';
        $professor8->email = 'professor8@gmail.com';
        $professor8->matricula = '0000013';
        $professor8->password = bcrypt('1234');
        $professor8->save();
        $professor8->roles()->attach($role_professor);

        $professor9 = new User();
        $professor9->name = 'Professor9';
        $professor9->email = 'professor9@gmail.com';
        $professor9->matricula = '0000014';
        $professor9->password = bcrypt('1234');
        $professor9->save();
        $professor9->roles()->attach($role_professor);

        $professor10 = new User();
        $professor10->name = 'Professor10';
        $professor10->email = 'professor10@gmail.com';
        $professor10->matricula = '0000015';
        $professor10->password = bcrypt('1234');
        $professor10->save();
        $professor10->roles()->attach($role_professor);
        
        $professor11 = new User();
        $professor11->name = 'Professor11';
        $professor11->email = 'professor11@gmail.com';
        $professor11->matricula = '0000016';
        $professor11->password = bcrypt('1234');
        $professor11->save();
        $professor11->roles()->attach($role_professor);

        $professor12 = new User();
        $professor12->name = 'Professor12';
        $professor12->email = 'professor12@gmail.com';
        $professor12->matricula = '0000017';
        $professor12->password = bcrypt('1234');
        $professor12->save();
        $professor12->roles()->attach($role_professor);

        $professor13 = new User();
        $professor13->name = 'Professor13';
        $professor13->email = 'professor13@gmail.com';
        $professor13->matricula = '0000018';
        $professor13->password = bcrypt('1234');
        $professor13->save();
        $professor13->roles()->attach($role_professor);

        $professor14 = new User();
        $professor14->name = 'Professor14';
        $professor14->email = 'professor14@gmail.com';
        $professor14->matricula = '0000019';
        $professor14->password = bcrypt('1234');
        $professor14->save();
        $professor14->roles()->attach($role_professor);

        $professor15 = new User();
        $professor15->name = 'Professor15';
        $professor15->email = 'professor15@gmail.com';
        $professor15->matricula = '0000020';
        $professor15->password = bcrypt('1234');
        $professor15->save();
        $professor15->roles()->attach($role_professor);

        $professor16 = new User();
        $professor16->name = 'Professor16';
        $professor16->email = 'professor16@gmail.com';
        $professor16->matricula = '0000021';
        $professor16->password = bcrypt('1234');
        $professor16->save();
        $professor16->roles()->attach($role_professor);

        $professor17 = new User();
        $professor17->name = 'Professor17';
        $professor17->email = 'professor17@gmail.com';
        $professor17->matricula = '0000022';
        $professor17->password = bcrypt('1234');
        $professor17->save();
        $professor17->roles()->attach($role_professor);

        $professor18 = new User();
        $professor18->name = 'Professor18';
        $professor18->email = 'professor18@gmail.com';
        $professor18->matricula = '0000023';
        $professor18->password = bcrypt('1234');
        $professor18->save();
        $professor18->roles()->attach($role_professor);

        $professor19 = new User();
        $professor19->name = 'Professor19';
        $professor19->email = 'professor19@gmail.com';
        $professor19->matricula = '0000024';
        $professor19->password = bcrypt('1234');
        $professor19->save();
        $professor19->roles()->attach($role_professor);

        $professor20 = new User();
        $professor20->name = 'Professor20';
        $professor20->email = 'professor20@gmail.com';
        $professor20->matricula = '0000025';
        $professor20->password = bcrypt('1234');
        $professor20->save();
        $professor20->roles()->attach($role_professor);

    }
}
