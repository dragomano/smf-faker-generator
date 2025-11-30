<?php

namespace App\MoonShine\Resources\Portal\Tag\Pages;

use App\MoonShine\Resources\Portal\Tag\TagTranslationResource;
use Bugo\MoonShine\FontAwesome\Fields\IconSelect;
use Illuminate\Validation\Rule;
use MoonShine\Contracts\Core\TypeCasts\DataWrapperContract;
use MoonShine\Laravel\Fields\Relationships\RelationRepeater;
use MoonShine\Laravel\Fields\Slug;
use MoonShine\Laravel\Pages\Crud\FormPage as BaseFormPage;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Layout\Column;
use MoonShine\UI\Components\Layout\Flex;
use MoonShine\UI\Components\Layout\Grid;
use MoonShine\UI\Components\Tabs;
use MoonShine\UI\Components\Tabs\Tab;
use MoonShine\UI\Fields\Switcher;

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
                        resource: TagTranslationResource::class
                    )
                        ->removable()
                        ->vertical(),
                ]),

                Tab::make(__('base.additional'), [
                    Grid::make([
                        Column::make([
                            Box::make([
                                Slug::make(__('base.slug'), 'slug')
                                    ->required()
                                    ->customAttributes([
                                        'x-data' => '',
                                        'x-on:slug-updated.window' => 'if (!$el.value && $event.detail.slug) $el.value = $event.detail.slug'
                                    ])
                                    ->unique(),

                                IconSelect::make(__('base.icon'), 'icon')
                                    ->async()
                                    ->searchable(),

                                Flex::make([
                                    Switcher::make(__('base.status'), 'status')
                                        ->sortable()
                                        ->default(1),
                                ]),
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
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('lp_tags')->ignoreModel($item->getOriginal()),
            ],
            'icon' => ['nullable', 'string', 'max:60'],
            'status' => ['required', 'integer', 'in:0,1'],
            'translations.*.title' => ['required', 'string', 'max:255'],
        ];
    }
}
