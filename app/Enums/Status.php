<?php

namespace App\Enums;

enum Status: int
{
    case INACTIVE = 0;
    case ACTIVE = 1;

    public static function values(): array
    {
        $values = array_map(fn($class) => $class->value, self::cases());

        return array_combine($values, [
            __('base.only_inactive'),
            __('base.only_active'),
        ]);
    }
}
