<?php

namespace App\Enums;

enum ContentClass: string
{
    case ROUNDFRAME = 'roundframe';
    case ROUNDFRAME2 = 'roundframe2';
    case WINDOWBG = 'windowbg';
    case WINDOWBG2 = 'windowbg2';
    case INFORMATION = 'information';
    case ERRORBOX = 'errorbox';
    case NOTICEBOX = 'noticebox';
    case INFOBOX = 'infobox';
    case DESCBOX = 'descbox';
    case BBC_CODE = 'bbc_code';
    case GENERIC_LIST_WRAPPER = 'generic_list_wrapper';
    case EMPTY = '';

    public static function values(): array
    {
        $values = array_map(fn($class) => $class->value, self::cases());

        return array_combine($values, $values);
    }

    public static function first(): string
    {
        return array_key_first(self::values());
    }
}
