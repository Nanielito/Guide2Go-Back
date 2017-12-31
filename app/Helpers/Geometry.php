<?php

namespace App\Helpers;

use ElevenLab\PHPOGC\DataTypes\LineString;
use ElevenLab\PHPOGC\DataTypes\Point as Point;
use ElevenLab\PHPOGC\DataTypes\Polygon as Polygon;

class Geometry {

	/**
	 * Uses faker factory 
	 * @return [lat, lng]
	 */
	private static function randPointArray() {
		$faker = \Faker\Factory::create();
		$lat = $faker->latitude($min = -90, $max = 90);
		$lng = $faker->longitude($min = -180, $max = 180);
		return [$lat, $lng];
	}

	public static function randomPoint() {
		$point = self::randPointArray();
		return Point::fromArray($point);
	}

	public static function randomPolygon($max = 1, $min = 1) {
		$points = [];
		$maxPoints = rand() % ($max - $min + 1) + $min;

		for ($i=0; $i < $maxPoints; $i++) {
			array_push($points, self::randPointArray());
		}

		/* Trampa de rosendo */
		array_push($points, $points[0]);

		return Polygon::fromArray([$points]);
	}

	public static function createPoint($latitude, $longitude) {
		return Point::fromArray([$latitude, $longitude]);
	}

	public static function isInside(Point $location, Point $currentLocation, $radius) {
        $x = $location->long;
        $y = $location->lat;
        $circleX = $currentLocation->long;
        $circleY = $currentLocation->lat;

		return (($x - $circleX) * ($x - $circleX) + ($y - $circleY) * ($y - $circleY) <= $radius * $radius) ? true : false;
	}

	public static function isLocationNear(Polygon $region, Point $location, $radius) {
		$isNear = false;
        $points = $region->linestrings[0]->points;

		foreach ($points as $point) {
			if (self::isInside($point, $location, $radius)) {
				$isNear = true;
				break;
			}
		}

		return $isNear;
	}
}
