<?php

namespace App\Enums;

enum ContentType: string
{
    case BBC = 'bbc';
    case HTML = 'html';
    case MARKDOWN = 'markdown';
    case PHP = 'php';

    public static function values(): array
    {
        $values = array_map(fn($class) => $class->value, self::cases());

        return array_combine($values, [
            __('base.content_type_bbc'),
            __('base.content_type_html'),
            __('base.content_type_md'),
            __('base.content_type_php'),
        ]);
    }

    public static function first(): string
    {
        return array_key_first(self::values());
    }
}
