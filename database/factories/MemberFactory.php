<?php

namespace Database\Factories;

use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class MemberFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Member::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'member_name' => Str::slug($name = $this->faker->unique()->name(), '_'),
            'date_registered' => $this->faker->dateTimeBetween('-5 years')->getTimestamp(),
            'real_name' => $name,
            'passwd' => bcrypt('password' . $name),
            'email_address' => $this->faker->unique()->safeEmail(),
            'birthdate' => $this->faker->dateTimeBetween('-50 years', '-20 years'),
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unactivated()
    {
        return $this->state(function (array $attributes) {
            return [
                'is_activated' => 0,
            ];
        });
    }
}
