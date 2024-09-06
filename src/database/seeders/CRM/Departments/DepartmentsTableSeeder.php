<?php

namespace Database\Seeders\CRM\Departments;

use Illuminate\Database\Seeder;
use App\Models\CRM\Departments\Department;

class DepartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        Department::insert([
            'title' => 'IT',
            'description' => 'Information Technology',
        ]);
        Department::insert([
            'title' => 'Sports and Agriculture',
            'description' => 'Department of Agricaulture',
        ]);

        Department::insert([
            'title' => 'Hospitality',
            'description' => 'Department of Skills Development in Hospitality',
        ]);
        Department::insert([
            'title' => 'Transport and Road Traffic',
            'description' => 'Department of Road Traffic and Security',
        ]);

        Department::insert([
            'title' => 'Tourisim',
            'description' => 'Department of Tourism',
        ]);

    }
}
