<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Book;
use Faker\Generator as Faker;

$factory->define(Book::class, function (Faker $faker) {
    DB::table('books')->delete();
    $genre = ['本', 'コミック', '雑誌', '洋書']; //変数に入れないとエラー
    return [
        'name' => $faker->unique()->bothify('BOOK###'),
        'price' => $faker->regexify('[4-9]{2}[0]'),
        'issue_date' => $faker->date($format = 'Y-m-d', $max = ('now')),
        'ranking' => $faker->unique()->numberBetween(1, 100),
        'genre' => $faker-> randomElement($genre),
    ];
});
