<?php

namespace Database\Seeders;

use App\Models\Privilege;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PrivilegeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Privilege::factory()
        ->count(1)
        ->create();
    }
}
