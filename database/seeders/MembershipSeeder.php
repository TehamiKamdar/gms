<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MembershipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('memberships')->insert([
            [
                'type' => 'Monthly',
                'price' => 1500,
                'duration' => 30
            ],
            [
                'type' => 'Quarterly',
                'price' => 4000,
                'duration' => 90
            ],
            [
                'type' => 'Yearly',
                'price' => 16000,
                'duration' => 360
            ],
        ]);
    }
}
