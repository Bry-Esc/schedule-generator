<?php

use Illuminate\Database\Seeder;

class RoomsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rooms')->insert([
            [
                'name' => 'CL 5',
                'capacity' => 20
            ],
            [
                'name' => 'CL 6',
                'capacity' => 20
            ],
            [
                'name' => 'CL 7',
                'capacity' => 20
            ],
            [
                'name' => 'CL 8',
                'capacity' => 20
            ],
            [
                'name' => 'CL 9',
                'capacity' => 20
            ],
            [
                'name' => 'CL 10',
                'capacity' => 20
            ],
            [
                'name' => 'CL 11',
                'capacity' => 20
            ]
        ]);
    }
}
