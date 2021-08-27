<?php

namespace Database\Factories;

use App\Models\LpTitle;
use Illuminate\Database\Eloquent\Factories\Factory;

class LpTitleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = LpTitle::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'lang' => 'english',
            'title' => '',
        ];
    }
}
