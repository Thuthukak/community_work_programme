<?php

use App\Models\ProjectManagement\Projects\Issue;
use App\Models\ProjectManagement\Projects\Project;
use App\Models\Core\Auth\User;
use Faker\Generator as Faker;

$factory->define(Issue::class, function (Faker $faker) {
    return [
        'project_id'  => function () {
            return factory(Project::class)->create()->id;
        },
        'title'       => $faker->words(3, true),
        'body'        => $faker->sentences(3, true),
        'creator_id'  => function () {
            return factory(User::class)->create()->id;
        },
        'status_id'   => 0,
        'priority_id' => 1,
    ];
});
