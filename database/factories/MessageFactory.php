<?php

namespace Database\Factories;

use App\Models\Board;
use App\Models\Message;
use App\Models\Topic;
use Illuminate\Database\Eloquent\Factories\Factory;

class MessageFactory extends Factory
{
    use RandomImageTrait;

    protected $model = Message::class;

    public function definition(): array
    {
        return [
            'id_topic' => Topic::factory(),
            'id_board' => Board::factory(),
            'poster_time' => fake()->dateTimeBetween('-4 years')->getTimestamp(),
            'subject' => rtrim(fake()->sentence(rand(2, 6)), '.'),
            'body' => fake()->paragraphs(rand(1, 6), true),
        ];
    }

    public function unapproved(): self
    {
        return $this->state(fn() => [
            'approved' => 0,
        ]);
    }

    public function withSequentialDate(int &$timestamp): self
    {
        return $this->state(function () use (&$timestamp) {
            $timestamp += mt_rand(600, 86400);

            return [
                'poster_time' => $timestamp,
            ];
        });
    }

    public function withRandomImage(): self
    {
        return $this->state(function () {
            $imageContent = $this->generateImageContent('bbc');

            return [
                'body' => $imageContent . fake()->paragraphs(rand(1, 6), true),
            ];
        });
    }
}
