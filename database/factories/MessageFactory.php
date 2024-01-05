<?php

namespace Database\Factories;

use App\Models\Board;
use App\Models\Message;
use App\Models\Topic;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\ArrayShape;

class MessageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Message::class;

    public function definition(): array
    {
        return [
            'id_topic' => Topic::factory(),
            'id_board' => Board::factory(),
            'poster_time' => $this->faker->dateTimeBetween('-4 years')->getTimestamp(),
            'subject' => rtrim($this->faker->sentence(rand(2, 6)), '.'),
            'body' => $this->faker->paragraphs(rand(1, 6), true),
        ];
    }

    public function unapproved(): Factory
    {
        return $this->state(fn() => [
            'approved' => 0,
        ]);
    }

    public function withRandomImage(): Factory
    {
        $random_image_url = 'https://loremflickr.com/600/300/nature?random=' . Str::random();
        $image = '[img alt="random image"]' . $random_image_url . '[/img][br]';

        return $this->state(fn() => [
            'body' => $image . $this->faker->paragraphs(rand(1, 6),true),
        ]);
    }

    public function withRandomDate(): Factory
    {
        $lastPostDate = Message::max('poster_time') ?? $this->faker->dateTimeBetween('-14 years')->getTimestamp();
        $last = CarbonImmutable::parse($lastPostDate);

        return $this->state(fn() => [
            'poster_time' => $this->faker->dateTimeBetween($last)->getTimestamp(),
        ]);
    }
}
