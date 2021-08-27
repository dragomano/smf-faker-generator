<?php

namespace Database\Factories;

use App\Models\LpComment;
use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;

class LpCommentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = LpComment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'author_id' => function () {
                return Member::all()->random();
            },
            'message' => $this->faker->paragraph,
            'created_at' => $this->faker->dateTimeBetween('-4 years')->getTimestamp(),
        ];
    }
}
