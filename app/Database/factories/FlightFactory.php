<?php

use Faker\Generator as Faker;

# Match the list available in tests/data/*.yml

$airlinesAvailable = [1];

$factory->define(App\Models\Flight::class, function (Faker $faker) use ($airlinesAvailable) {
    return [
        'id' => null,
        'airline_id' => function () {
            return factory(App\Models\Airline::class)->create()->id;
        },
        'flight_number' => $faker->unique()->numberBetween(10, 1000000),
        'route_code' => $faker->randomElement(['', $faker->text(5)]),
        'route_leg' => $faker->randomElement(['', $faker->text(5)]),
        'dpt_airport_id' => function() {
            return factory(App\Models\Airport::class)->create()->id;
        },
        'arr_airport_id' => function () {
            return factory(App\Models\Airport::class)->create()->id;
        },
        'alt_airport_id' => function () {
            return factory(App\Models\Airport::class)->create()->id;
        },
        'distance' => $faker->numberBetween(0, 3000),
        'route' => null,
        'dpt_time' => $faker->time(),
        'arr_time' => $faker->time(),
        'flight_time' => $faker->numberBetween(60, 360),
        'has_bid' => false,
        'active' => true,
        'created_at' => $faker->dateTimeBetween('-1 week', 'now'),
        'updated_at' => function (array $flight) {
            return $flight['created_at'];
        },
    ];
});
