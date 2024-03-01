<?php

namespace Database\Factories;

use App\Models\Board;
use App\Models\Member;
use App\Models\Topic;
use Illuminate\Database\Eloquent\Factories\Factory;

class TopicFactory extends Factory
{
    protected $model = Topic::class;

    public function definition(): array
    {
        return [
            'id_board' => Board::factory(),
            'id_member_started' => Member::factory(),
            'num_views' => mt_rand(0, 9999),
            'locked' => mt_rand(1, 100) === 1 ? 1 : 0,
        ];
    }

    public function stickied(): Factory
    {
        return $this->state(fn(array $attributes) => [
            'is_sticky' => 1,
        ]);
    }

    public function locked(): Factory
    {
        return $this->state(fn(array $attributes) => [
            'locked' => 1,
        ]);
    }
}
