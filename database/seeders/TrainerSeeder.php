<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TrainerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('trainers')->insert([
            [
                'name' => 'Tehami',
                'email' => 'tehami@aptechgdn.net',
                'phone' => '03330247545',
                'salary' => '20000',
                'specialization_id' => 1,
            ],
            [
                'name' => 'Ahsan',
                'email' => 'ahsan@aptechgdn.net',
                'phone' => '03330247546',
                'salary' => '22000',
                'specialization_id' => 2,
            ],
            [
                'name' => 'Nadeem',
                'email' => 'nadeem@aptechgdn.net',
                'phone' => '03330247547',
                'salary' => '18000',
                'specialization_id' => 3,
            ],
            [
                'name' => 'Qasim',
                'email' => 'qasim@aptechgdn.net',
                'phone' => '03330247548',
                'salary' => '20000',
                'specialization_id' => 3,
            ],
            [
                'name' => 'Subhan',
                'email' => 'subhan@aptechgdn.net',
                'phone' => '03330247549',
                'salary' => '20000',
                'specialization_id' => 1,
            ],
        ]);
    }
}
