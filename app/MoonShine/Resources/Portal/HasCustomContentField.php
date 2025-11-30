<?php

namespace App\MoonShine\Resources\Portal;

use MoonShine\Ace\Fields\Code;
use MoonShine\EasyMde\Fields\Markdown;
use MoonShine\TinyMce\Fields\TinyMce;
use MoonShine\UI\Fields\Field;
use MoonShine\UI\Fields\Textarea;

trait HasCustomContentField
{
    protected function getContentField(): Field
    {
        $fieldClass = match (request('type')) {
            'php' => Code::class,
            'html' => TinyMce::class,
            'markdown' => Markdown::class,
            default => Textarea::class,
        };

        $field = $fieldClass::make(__('base.translation_content'), 'content')
            ->setAttribute('rows', '10');

        if ($field instanceof Code) {
            $field->language('php');
        }

        return $field;
    }
}
