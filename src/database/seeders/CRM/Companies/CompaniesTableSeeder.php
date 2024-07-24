<?php
namespace Database\Seeders\CRM\Companies;


use Illuminate\Database\Seeder;
use App\Models\CRM\Company\Company;

class CompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    

        // Insert the data
        Company::create([
            'name' => 'CWP',
            'description' => 'Cwp Programme',
            'user_id' => 1,
            'created_at' => '2024-07-10 22:01:47',
            'updated_at' => '2024-07-10 22:01:47',
        ]);
    }
}
