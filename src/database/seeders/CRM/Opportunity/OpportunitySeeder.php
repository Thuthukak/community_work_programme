<?php

namespace Database\Seeders\CRMOpportunity;

use Illuminate\Database\Seeder;

class OpportunitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jobs = [
            [
                "user_id" => 16,
                "organization_id" => 15,
                "title" => "Ea molestias non harum ab quo.",
                "slug" => "ea-molestias-non-harum-ab-quo",
                "description" => "Deleniti non consectetur est in. Omnis quo est facilis libero...",
                "roles" => "Amet et repellendus dolorem quas dignissimos...",
                "category_id" => 19,
                "position" => "Director Of Talent Acquisition",
                "address" => "845 Keshaun Bypass Apt. 449 Robelland, MD 16967-3720",
                "featured" => 1,
                "type" => "fulltime",
                "status" => 1,
                "last_date" => "1989-07-22",
                "created_at" => now(),
                "updated_at" => now(),
                "number_of_vacancy" => 10,
                "experience" => 3,
                "gender" => "male",
                "salary" => "19688",
            ],
        ];


    }
}
