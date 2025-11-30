<?php

namespace App\MoonShine\Resources\Forum\Membergroup\Pages;

use MoonShine\Contracts\Core\TypeCasts\DataWrapperContract;
use MoonShine\Laravel\Pages\Crud\FormPage as BaseFormPage;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\Color;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;

class FormPage extends BaseFormPage
{
    protected function fields(): iterable
    {
        return [
            Box::make([
                ID::make(__('base.id'), 'id_group'),

                Text::make(__('base.group'), 'group_name')
                    ->required(),

                Textarea::make(__('base.description'), 'description')
                    ->required(),

                Color::make(__('base.color'), 'online_color')
                    ->required()
                    ->default(''),

                Number::make(__('base.min_messages'), 'min_posts')
                    ->hint(__('base.min_messages_hint'))
                    ->min(-1)
                    ->default(-1),
            ]),
        ];
    }

    protected function rules(DataWrapperContract $item): array
    {
        return [
            'group_name' => ['required', 'string'],
            'description' => ['required', 'string'],
            'online_color' => ['required', 'string'],
            'min_posts' => ['required', 'integer', 'min:-1'],
        ];
    }
}
