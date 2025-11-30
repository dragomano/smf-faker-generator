<?php

namespace Database\Factories;

use App\Models\PortalComment;
use App\Models\Member;
use App\Models\PortalPage;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Date;

class PortalCommentFactory extends Factory
{
    protected $model = PortalComment::class;

    public function definition(): array
    {
        return [
            'page_id' => fn() => PortalPage::inRandomOrder()->value('page_id'),
            'author_id' => fn() => Member::inRandomOrder()->value('id_member'),
            'created_at' => fake()->dateTimeBetween('-3 years', '-1 week')->getTimestamp(),
        ];
    }

    public function createdFrom($date): self
    {
        return $this->state(fn(array $attributes) => [
            'created_at' => fake()->dateTimeBetween(Date::createFromTimestamp($date))->getTimestamp(),
        ]);
    }
}
