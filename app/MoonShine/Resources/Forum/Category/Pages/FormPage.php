<?php

namespace App\MoonShine\Resources\Forum\Category\Pages;

use MoonShine\Contracts\Core\TypeCasts\DataWrapperContract;
use MoonShine\Laravel\Pages\Crud\FormPage as BaseFormPage;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;

class FormPage extends BaseFormPage
{
    protected function fields(): iterable
    {
        return [
            Box::make([
                ID::make(__('base.id'), 'id_cat'),

                Text::make(__('base.title'), 'name')
                    ->required(),

                Textarea::make(__('base.description'), 'description')
                    ->required(),

                Switcher::make(__('base.collapsible'), 'can_collapse')
                    ->default(true)
            ]),
        ];
    }

    protected function rules(DataWrapperContract $item): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'can_collapse' => ['integer'],
        ];
    }
}
