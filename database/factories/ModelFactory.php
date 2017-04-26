<?php

use App\Helpers\Geometry;
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

$factory->define(App\Zona::class, function (Faker\Generator $faker) {
	$polygon = Geometry::randomPolygon(33, 3);

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
	static $password;

	/* Un poco feo esto */
	$type = App\User_type::inRandomOrder()->first()->id;
	$page = App\Page::inRandomOrder()->first()->id;

	return [
		'name' => $faker->name,
		'email' => $faker->unique()->safeEmail,
		'password' => $password ?: $password = bcrypt('secret'),
		'user_types_id' => $type,
		'pages_id' => $page,
		'dolares' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = NULL),
		'remember_token' => str_random(10),
	];
});

$factory->define(App\Sub_zona::class, function (Faker\Generator $faker) {
	
	$polygon = Geometry::randomPolygon(6, 3);

	return [
		'nombre' => $faker->streetName,
		'poligono' => $polygon
	];

});

$factory->define(App\Parada::class, function (Faker\Generator $faker) {

	$category = App\Categoria::inRandomOrder()->first()->id;
	$point = Geometry::randomPoint();

	return [
		'categoria_id' => $category,
		'nombre' => $faker->streetName,
		'descripcion' => $faker->text,
		'punto' => $point
	];

});
