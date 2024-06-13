<?php

use App\Models\ProjectManagement\Projects\Comment;
use App\Models\ProjectManagement\Projects\Project;
use App\Entities\Users\User;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'commentable_type' => 'projects',
        'commentable_id'   => function () {
            return factory(Project::class)->create()->id;
        },
        'body'             => $faker->sentence,
        'creator_id'       => function () {
            return factory(User::class)->create()->id;
        },
    ];
});
