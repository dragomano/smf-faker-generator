<?php

namespace App\MoonShine\Resources\Portal\Category\Pages;

use App\MoonShine\Resources\Portal\Translation\Pages\FormPage;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;

class TranslationFormPage extends FormPage
{
    protected function customFields(): iterable
    {
        return [
            Text::make(__('base.translation_title'), 'title')
                ->customAttributes([
                    'x-data' => '',
                    'x-on:input.debounce.500ms' => "
                        if (\$el.value) {
                            fetch('/admin/pages/generate-slug?title=' + encodeURIComponent(\$el.value))
                                .then(r => r.json())
                                .then(data => \$dispatch('slug-updated', data))
                        }
                    "
                ])
                ->required(),

            Textarea::make(__('base.translation_description'), 'description')
                ->setAttribute('rows', '3'),
        ];
    }
}
