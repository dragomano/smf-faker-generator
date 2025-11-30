<?php

namespace App\MoonShine\Resources\Portal\Comment\Pages;

use App\MoonShine\Resources\Portal\Translation\Pages\FormPage;
use MoonShine\EasyMde\Fields\Markdown;

class TranslationFormPage extends FormPage
{
    protected function customFields(): iterable
    {
        return [
            Markdown::make(__('base.translation_content'), 'content')
                ->setAttribute('rows', '10')
                ->required(),
        ];
    }
}
