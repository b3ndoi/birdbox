<?php

use Faker\Generator as Faker;
use App\Task;
$factory->define(Task::class, function (Faker $faker) {
    return [
        'body' => $faker->sentence,
        'project_id' => function(){
            return factory(App\Project::class)->create()->id;
        }
    ];
});
