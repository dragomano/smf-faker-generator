<?php

namespace App\MoonShine\Resources\Portal\Comment\Pages;

use App\MoonShine\Resources\Portal\Comment\CommentTranslationResource;
use MoonShine\Contracts\Core\TypeCasts\DataWrapperContract;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\Laravel\Fields\Relationships\RelationRepeater;
use MoonShine\Laravel\Pages\Crud\FormPage as BaseFormPage;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Layout\Column;
use MoonShine\UI\Components\Layout\Grid;
use MoonShine\UI\Components\Tabs;
use MoonShine\UI\Components\Tabs\Tab;
use MoonShine\UI\Fields\Number;

class FormPage extends BaseFormPage
{
    protected function fields(): iterable
    {
        return [
            Tabs::make([
                Tab::make(__('base.content'), [
                    RelationRepeater::make(
                        '',
                        'translations',
                        resource: CommentTranslationResource::class
                    )
                        ->removable()
                        ->vertical(),
                ]),

                Tab::make(__('base.additional'), [
                    Grid::make([
                        Column::make([
                            Box::make([
                                BelongsTo::make(__('base.page'), 'page', 'translation.title')
                                    ->disabled(function () {
                                        $segments = request()->segments();
                                        $lastSegment = end($segments);

                                        return is_numeric($lastSegment);
                                    })
                                    ->searchable(),

                                Number::make(__('base.parent_comment'), 'parent_id'),

                                BelongsTo::make(__('base.author'), 'member', 'real_name')
                                    ->asyncSearch('real_name')
                                    ->asyncOnInit()
                                    ->required(),
                            ]),
                        ])
                            ->columnSpan(4),
                    ]),
                ]),
            ]),
        ];
    }

    protected function rules(DataWrapperContract $item): array
    {
        return [
            'page_id' => ['required', 'integer', 'exists:lp_pages,page_id'],
            'parent_id' => ['required', 'integer'],
            'author_id' => ['required', 'integer', 'exists:members,id_member'],
            'translations.*.content' => ['required', 'string'],
        ];
    }
}
