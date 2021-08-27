<?php

namespace Database\Factories;

use App\Models\Board;
use App\Models\Member;
use App\Models\Message;
use App\Models\Topic;
use Illuminate\Database\Eloquent\Factories\Factory;

class TopicFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Topic::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id_board' => function () {
                return Board::factory()->create()->id;
            },
            'id_member_started' => function () {
                return Member::factory()->create()->id;
            },
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function stickied()
    {
        return $this->state(function (array $attributes) {
            return [
                'is_sticky' => 1,
            ];
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function locked()
    {
        return $this->state(function (array $attributes) {
            return [
                'locked' => 1,
            ];
        });
    }
}
