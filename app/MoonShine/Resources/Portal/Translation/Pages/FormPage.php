<?php

namespace App\MoonShine\Resources\Portal\Translation\Pages;

use App\MoonShine\Resources\Portal\HasCustomContentField;
use MoonShine\Laravel\Pages\Crud\FormPage as BaseFormPage;
use MoonShine\UI\Fields\Select;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;

class FormPage extends BaseFormPage
{
    use HasCustomContentField;

    protected function getLanguages(): array
    {
        $languages = config('app.languages');
        $locales = config('moonshine.locales');
        $combined = array_combine($languages, $locales);

        $default = $languages[config('app.locale', 'ru')] ?? null;

        if ($default && isset($combined[$default])) {
            return [$default => $combined[$default]] + array_diff_key($combined, [$default => true]);
        }

        return $combined;
    }

    final protected function fields(): iterable
    {
        return [
            Select::make(__('base.translation_language'), 'lang')
                ->options($this->getLanguages()),

            ...$this->customFields(),
        ];
    }

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

            $this->getContentField(),
        ];
    }
}
