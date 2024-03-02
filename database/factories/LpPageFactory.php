<?php

namespace Database\Factories;

use App\Models\LpCategory;
use App\Models\LpPage;
use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class LpPageFactory extends Factory
{
    protected $model = LpPage::class;

    public function definition(): array
    {
        return [
            'category_id' => fn() => LpCategory::all()->random(),
            'author_id' => fn() => Member::all()->random(),
            'alias' => Str::slug($this->faker->unique()->city, '_'),
            'description' => Str::words($this->faker->sentence(10)),
            'content' => $this->faker->paragraphs(rand(1, 6), true),
            'type' => $this->faker->randomElement(['bbc', 'html', 'markdown']),
            'permissions' => 3,
            'num_views' => mt_rand(0, 9999),
            'created_at' => $this->faker->dateTimeBetween('-4 years')->getTimestamp(),
        ];
    }

    public function withRandomImage(): Factory
    {
        return $this->state(function (array $attributes) {
            $randomImage = 'https://loremflickr.com/600/300/nature?random=' . Str::random();

            $image = '<img src="' .  $randomImage . '" alt="random image"><br>';
            if ($attributes['type'] === 'bbc') {
                $image = '[img alt=random image]' .  $randomImage . '[/img][br]';
            } elseif ($attributes['type'] === 'markdown') {
                $image = '![random image](' .  $randomImage . ')';
            }

            return [
                'content' => $image . $this->faker->paragraphs(rand(1, 6),true),
            ];
        });
    }
}
