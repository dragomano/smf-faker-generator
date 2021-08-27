<?php

namespace Database\Factories;

use App\Models\Board;
use App\Models\Member;
use App\Models\Message;
use App\Models\Topic;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class MessageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Message::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id_topic' => function () {
                return Topic::factory()->create()->id;
            },
            'id_board' => function () {
                return Board::factory()->create()->id;
            },
            'poster_time' => $this->faker->dateTimeBetween('-4 years')->getTimestamp(),
            'subject' => rtrim($this->faker->sentence(rand(2, 6)), '.'),
            'poster_ip' => $this->faker->ipv4,
            'body' => $this->faker->paragraphs(rand(1, 6), true),
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unapproved()
    {
        return $this->state(function (array $attributes) {
            return [
                'approved' => 0
            ];
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function withRandomImage()
    {
        return $this->state(function (array $attributes) {
            $image = '[img]https://picsum.photos/seed/' . Str::random() . '/400/200[/img][br]';

            return [
                'body' => $image . $this->faker->paragraphs(rand(1, 6),true),
            ];
        });
    }
}
