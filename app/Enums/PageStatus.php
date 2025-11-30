<?php

namespace App\Enums;

enum PageStatus: int
{
    case INACTIVE = 0;
    case ACTIVE = 1;
    case UNAPPROVED = 2;
    case INTERNAL = 3;

    public static function values(): array
    {
        $values = array_map(fn($class) => $class->value, self::cases());

        return array_combine($values, [
            __('base.page_status_inactive'),
            __('base.page_status_active'),
            __('base.page_status_unapproved'),
            __('base.page_status_internal'),
        ]);
    }
}
