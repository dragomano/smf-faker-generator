<?php

namespace Database\Factories;

use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class MemberFactory extends Factory
{
    protected $model = Member::class;

    public function definition(): array
    {
        return [
            'member_name' => $memberName = Str::slug($name = fake()->unique()->name(), '_'),
            'date_registered' => fake()->dateTimeBetween('-5 years')->getTimestamp(),
            'real_name' => $name,
            'passwd' => Member::getHashedPassword($memberName, 'Sbs)2id(Pep5I!2A' . $memberName),
            'email_address' => fake()->unique()->safeEmail(),
            'birthdate' => fake()->dateTimeBetween('-50 years', '-20 years'),
        ];
    }

    public function unactivated(): self
    {
        return $this->state(fn(array $attributes) => [
            'is_activated' => 0,
        ]);
    }
}
