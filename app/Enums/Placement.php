<?php

namespace App\Enums;

enum Placement: string
{
    case HEADER = 'header';
    case TOP = 'top';
    case LEFT = 'left';
    case RIGHT = 'right';
    case BOTTOM = 'bottom';
    case FOOTER = 'footer';

    public static function values(): array
    {
        $values = array_map(fn($class) => $class->value, self::cases());

        return array_combine($values, [
            __('base.placement_header'),
            __('base.placement_top'),
            __('base.placement_left'),
            __('base.placement_right'),
            __('base.placement_bottom'),
            __('base.placement_footer'),
        ]);
    }

    public static function first(): string
    {
        return array_key_first(self::values());
    }
}
