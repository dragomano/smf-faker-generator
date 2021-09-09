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

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'alias' => Str::slug($this->faker->unique()->city, '_'),
            'content' => $this->faker->paragraphs(rand(1, 6), true),
            'type' => 'bbc',
            'permissions' => 3,
            'num_views' => mt_rand(0, 9999),
            'created_at' => $this->faker->dateTimeBetween('-4 years')->getTimestamp(),
        ];
    }

    /**
     * @return Factory
     */
    public function withRandomImage()
    {
        return $this->state(function (array $attributes) {
            $image = 'https://picsum.photos/seed/' . Str::random() . '/400/200';
            if ($attributes['type'] === 'bbc') {
                $image = '[img]' .  $image . '[/img][br]';
            } elseif ($attributes['type'] === 'html') {
                $image = '<img src="' .  $image . '" alt=""><br>';
            }

            return [
                'content' => $image . $this->faker->paragraphs(rand(1, 6),true),
            ];
        });
    }
}
