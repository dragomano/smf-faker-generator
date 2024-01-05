<?php

namespace Database\Factories;

use App\Models\LpPage;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class LpPageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = LpPage::class;

    public function definition(): array
    {
        return [
            'alias' => Str::slug($this->faker->unique()->city, '_'),
            'description' => Str::words($this->faker->sentence(10)),
            'content' => $this->faker->paragraphs(rand(1, 6), true),
            'type' => $this->faker->randomElement(['bbc', 'html']),
            'permissions' => 3,
            'num_views' => mt_rand(0, 9999),
            'created_at' => $this->faker->dateTimeBetween('-4 years')->getTimestamp(),
        ];
    }

    public function withRandomImage(): Factory
    {
        return $this->state(function (array $attributes) {
            $random_image_url = 'https://loremflickr.com/600/300/nature?random=' . Str::random();

            $image = '<img src="' .  $random_image_url . '" alt="random image"><br>';
            if ($attributes['type'] === 'bbc') {
                $image = '[img alt="random image"]' .  $random_image_url . '[/img][br]';
            }

            return [
                'content' => $image . $this->faker->paragraphs(rand(1, 6),true),
            ];
        });
    }
}
