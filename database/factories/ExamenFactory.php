<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Examen::class, function (Faker $faker) {
    return [
        'nombreExamen'=>'Ultrasonido'
    ];
});
