<?php

namespace App\MoonShine\Resources\Forum\Topic\Pages;

use App\Models\Topic;
use App\MoonShine\Resources\Forum\Message\MessageResource;
use MoonShine\Contracts\Core\TypeCasts\DataWrapperContract;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\Laravel\Fields\Relationships\HasMany;
use MoonShine\Laravel\Pages\Crud\FormPage as BaseFormPage;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Layout\Column;
use MoonShine\UI\Components\Layout\Flex;
use MoonShine\UI\Components\Layout\Grid;
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
                ID::make(__('base.id'), 'id_topic'),

                Text::make(__('base.title'), 'subject')
                    ->required()
                    ->changeFill(fn(Topic $item) => $item->firstMessage?->subject ?? '')
                    ->onApply(fn($item) => $item),

                Textarea::make(__('base.message_body'), 'body')
                    ->required()
                    ->changeFill(fn(Topic $item) => $item->firstMessage?->body ?? '')
                    ->onApply(fn($item) => $item)
                    ->setAttribute('rows', '10'),

                Grid::make([
                    Column::make([
                        BelongsTo::make(__('base.board'), 'board', 'name'),
                    ], 6),

                    Column::make([
                        BelongsTo::make(__('base.author'), 'member', 'real_name')
                            ->searchable()
                            ->required()
                            ->default(0),
                    ], 6),
                ]),

                Flex::make([
                    Switcher::make(__('base.closed'), 'locked'),

                    Switcher::make(__('base.approved'), 'approved'),

                    Switcher::make(__('base.sticky'), 'is_sticky'),
                ])
                    ->style('flex-wrap: nowrap'),

                HasMany::make(__('base.messages'), 'messages', resource: MessageResource::class)
                    ->async()
                    ->creatable(),
            ]),
        ];
    }

    protected function rules(DataWrapperContract $item): array
    {
        return [
            'is_sticky' => 'integer|in:0,1',
            'id_board' => 'required|integer',
            'id_member_started' => 'required|integer',
            'locked' => 'integer|in:0,1',
            'approved' => 'integer|in:0,1',
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
        ];
    }
}
