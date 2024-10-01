<?php

namespace Database\Seeders\CRM\OpportunityCategory;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\CRM\JobCategory\JobCategory;
use Illuminate\Support\Str;


class OpportunityCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
                    'Healthcare',
                    'Medical Services',
                    'Technology',
                    'Software Development',
                    'Education',
                    'Engineering',
                    'Creative and Design',
                    'Research and Development',
                    'Hospitality and Tourism',
                    'Business and Management',
                    'Finance and Accounting',
                    'Sales and Marketing',
                    'Legal Services',
                    'Media and Communication',
                    'Manufacturing and Production',
                    'Transportation and Logistics',
                    'Environmental Services',
                    'Social Services',
                    'Agriculture and Farming',
                    'Construction and Skilled Trades'
                ];

                foreach($categories as $category){
                    JobCategory::create(
                        [
                        'name'=> $category, 
                        'slug'=> Str::slug($category),
                        'status'=> '1'
                        ]
                    );
                }
                
            }
}
