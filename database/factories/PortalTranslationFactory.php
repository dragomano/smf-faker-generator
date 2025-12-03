<?php

namespace Database\Factories;

use App\Models\PortalTranslation;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PortalTranslationFactory extends Factory
{
    use RandomImageTrait;

    protected $model = PortalTranslation::class;

    public function definition(): array
    {
        return [
            'lang' => 'english',
            'title' => rtrim(fake()->sentence, '.'),
            'content' => fake()->paragraphs(rand(1, 6), true),
            'description' => Str::limit(fake()->sentence(10), 500),
        ];
    }
}
