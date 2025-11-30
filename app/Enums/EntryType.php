<?php

namespace App\Enums;

enum EntryType: string
{
    case DEFAULT = 'default';
    case INTERNAL = 'internal';
    case DRAFT = 'draft';

    public static function values(): array
    {
        $values = array_map(fn($class) => $class->value, self::cases());

        return array_combine($values, [
            __('base.page_type_default'),
            __('base.page_type_internal'),
            __('base.page_type_draft'),
        ]);
    }
}
