<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'email' => 'admin@pcu.edu.ph',
            'name' => 'Administrator',
            'password' => bcrypt('1234'),
            'accesslevel' => 100,
            'security_question_id' => 1,
            'security_question_answer' => 'Cav',
            'activated' => true,
            'path_to_avatar' => 'default.jpg'
        ]);
    }
}
