<?php

namespace App\MoonShine\Resources\Forum\Message\Pages;

use MoonShine\Contracts\Core\TypeCasts\DataWrapperContract;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;
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
                ID::make(__('base.id'), 'id_msg'),

                Text::make(__('base.title'), 'subject')
                    ->required(),

                Textarea::make(__('base.message_body'), 'body')
                    ->required()
                    ->setAttribute('rows', '10'),

                BelongsTo::make(__('base.subject'), 'topic')
                    ->required()
                    ->searchable(),

                BelongsTo::make(__('base.board'), 'board')
                    ->required()
                    ->searchable(),

                BelongsTo::make(__('base.author'), 'member')
                    ->searchable()
                    ->required(),

                Switcher::make(__('base.approved'), 'approved'),
            ]),
        ];
    }

    protected function rules(DataWrapperContract $item): array
    {
        return [
            'id_topic' => ['required', 'integer'],
            'id_board' => ['required', 'integer'],
            'id_member' => ['required', 'integer'],
            'subject' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
            'approved' => ['integer', 'in:0,1'],
        ];
    }
}
