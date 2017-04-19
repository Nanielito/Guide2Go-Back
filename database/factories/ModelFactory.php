<?php

use ElevenLab\PHPOGC\DataTypes\Polygon as Polygon;

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
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Zona::class, function (Faker\Generator $faker) {

	$points = [];
	$maxPoints = rand() % 33 + 3;

	for ($i=0; $i < $maxPoints; $i++) {
		
		$lat = $faker->latitude($min = -90, $max = 90);
		$lng = $faker->longitude($min = -180, $max = 180);
		
		array_push($points, [$lat, $lng]);
	}

	/* Trampa de rosendo */
	array_push($points, $points[0]);

	$polygon = Polygon::fromArray([$points]);

	return [
		'name' => $faker->city,
		'poligono' => $polygon
	];
});

$factory->define(App\Guia::class, function () {

	/* :( */
	$zone = App\Zona::inRandomOrder()->first()->id;
	$lang = App\Idioma::inRandomOrder()->first()->id;

	return [
		'costo' => rand() % 1000,
		'zonas_id' => $zone,
		'idiomas_id' => $lang
	];

});

$factory->define(App\User::class, function(Faker\Generator $faker) {

	/* Un poco feo esto */
	$type = App\User_type::inRandomOrder()->first()->id;
	$page = App\Page::inRandomOrder()->first()->id;

	return [
		'name' => $faker->name,
		'email' => $faker->email,
		'password' => $faker->password,
		'user_types_id' => $type,
		'pages_id' => $page,
		'monedas' => rand() % 1000
	];
});
