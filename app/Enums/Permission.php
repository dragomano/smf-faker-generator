<?php

namespace App\Enums;

enum Permission: int
{
    case ADMIN = 0;
    case GUEST = 1;
    case USER = 2;
    case ALL = 3;

    public static function values(): array
    {
        $values = array_map(fn($class) => $class->value, self::cases());

        return array_combine($values, [
            __('base.permissions_admins'),
            __('base.permissions_guests'),
            __('base.permissions_users'),
            __('base.permissions_all'),
        ]);
    }
}
