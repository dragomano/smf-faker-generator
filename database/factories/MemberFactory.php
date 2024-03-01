<?php

namespace Database\Factories;

use App\Models\Member;
use App\Models\Membergroup;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class MemberFactory extends Factory
{
    protected $model = Member::class;

    public function definition(): array
    {
        return [
            'member_name' => $memberName = Str::slug($name = $this->faker->unique()->name(), '_'),
            'date_registered' => $this->faker->dateTimeBetween('-5 years')->getTimestamp(),
            'real_name' => $name,
            'passwd' => Member::getHashedPassword($memberName, 'password'),
            'email_address' => $this->faker->unique()->safeEmail(),
            'birthdate' => $this->faker->dateTimeBetween('-50 years', '-20 years'),
        ];
    }

    public function unactivated(): Factory
    {
        return $this->state(fn(array $attributes) => [
            'is_activated' => 0,
        ]);
    }
}
