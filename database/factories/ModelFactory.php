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

$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});
$factory->define(App\Team::class, function (Faker\Generator $faker) {
    $number = 0;
    do {
        $number = random_int(0, 10000);
    } while (\App\Team::whereTeamNumber($number)->first() != null);
    return [
        'team_number' => $number,
        'name' => $faker->name,
        'owner_id' => -1
    ];
});
$factory->define(App\UserData::class, function (Faker\Generator $faker) {
    return [
        'bio' => 'No bio',
        'photo_location' => $faker->email
    ];
});
$factory->define(App\Survey::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->sentence,
        'template' => false,
        'archived' => 0,
        'creator_id' => -1,
        'team_id' => -1
    ];
});
$factory->define(App\Question::class, function (Faker\Generator $faker) {
    $question_types = ['short_text', 'long_text', 'number', 'checkbox', 'radio'];
    $data_array = [];
    for ($i = 0; $i < random_int(1, 5); $i++) {
        $data_array[] = ['checked' => 'false', 'name' => $faker->word];
    }
    return [
        'order' => 1,
        'question_name' => $faker->sentence,
        'question_type' => $question_types[random_int(0, sizeof($question_types) - 1)],
        'extra_data' => json_encode(['options' => $data_array])
    ];
});