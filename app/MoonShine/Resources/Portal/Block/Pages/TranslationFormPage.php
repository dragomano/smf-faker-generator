<?php

namespace App\MoonShine\Resources\Portal\Block\Pages;

use App\MoonShine\Resources\Portal\Translation\Pages\FormPage;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;

class TranslationFormPage extends FormPage
{
    protected function customFields(): iterable
    {
        return [
            Text::make(__('base.translation_title'), 'title'),

            Textarea::make(__('base.translation_description'), 'description')
                ->setAttribute('rows', '3'),

            $this->getContentField(),
        ];
    }
}
