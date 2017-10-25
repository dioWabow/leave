<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Timesheet::class, function (Faker\Generator $faker) {
    $project_id = [1,2];
    $user_id = [1,2,3,5,6,10];
    return [
        'project_id' => array_random($project_id),
        'tag' => $faker->word,
        'user_id' => array_random($user_id),
        'items' => $faker->text(10),
        'description' => $faker->paragraph(),
        'hour' => $faker->randomFloat(null, 0.1, 1),
        'working_day' => $faker->dateTimeThisYear(),
        'url' => 'http://leave.ptt.wabow.com',
        'remark' => $faker->text(10),
    ];
});
