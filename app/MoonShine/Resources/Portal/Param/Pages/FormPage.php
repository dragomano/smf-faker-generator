<?php

namespace App\MoonShine\Resources\Portal\Param\Pages;

use MoonShine\Laravel\Pages\Crud\FormPage as BaseFormPage;
use MoonShine\UI\Fields\Hidden;
use MoonShine\UI\Fields\Text;

class FormPage extends BaseFormPage
{
    protected function fields(): iterable
    {
        return [
            Hidden::make(column: 'id'),

            Text::make(__('base.param'), 'name')
                ->required(),

            Text::make(__('base.value'), 'value')
                ->required(),
        ];
    }
}
