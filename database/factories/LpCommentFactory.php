<?php

namespace Database\Factories;

use App\Models\LpComment;
use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Date;

class LpCommentFactory extends Factory
{
    protected $model = LpComment::class;

    public function definition(): array
    {
        return [
            'author_id' => fn() => Member::all()->random(),
            'message' => $this->faker->paragraph,
            'created_at' => $this->faker->dateTimeBetween('-3 years', '-1 week')->getTimestamp(),
        ];
    }

    public function createdFrom($date): Factory
    {
        return $this->state(fn(array $attributes) => [
            'created_at' => $this->faker->dateTimeBetween(Date::createFromTimestamp($date))->getTimestamp(),
        ]);
    }
}
