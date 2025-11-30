<?php

namespace App\Enums;

enum TitleClass: string
{
    case CAT_BAR = 'cat_bar';
    case TITLE_BAR = 'title_bar';
    case SUB_BAR = 'sub_bar';
    case NOTICEBOX = 'noticebox';
    case INFOBOX = 'infobox';
    case DESCBOX = 'descbox';
    case GENERIC_LIST_WRAPPER = 'generic_list_wrapper';
    case PROGRESS_BAR = 'progress_bar';
    case POPUP_CONTENT = 'popup_content';
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
