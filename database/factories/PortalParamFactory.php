<?php

namespace Database\Factories;

use App\Models\PortalParam;
use Illuminate\Database\Eloquent\Factories\Factory;

class PortalParamFactory extends Factory
{
    protected $model = PortalParam::class;

    public function definition(): array
    {
        return [
            'name' => '',
            'value' => '',
        ];
    }
}
