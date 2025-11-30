<?php

namespace App\MoonShine\Resources\Portal\Category\Pages;

use App\Models\PortalCategory;
use App\MoonShine\Resources\Portal\Category\CategoryTranslationResource;
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
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Select;
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
                        resource: CategoryTranslationResource::class
                    )
                        ->removable()
                        ->vertical(),
                ]),

                Tab::make(__('base.additional'), [
                    Grid::make([
                        Column::make([
                            Box::make([
                                Select::make(__('base.parent_category'), 'parent_id')
                                    ->options(function() {
                                        $currentId = $this->getResource()->getItem()?->getKey();

                                        $categories = PortalCategory::query()
                                            ->when($currentId, fn($query) => $query->where('category_id', '!=', $currentId))
                                            ->get();

                                        $options = $categories->pluck('translation.title', 'category_id')->toArray();

                                        return [0 => __('base.none')] + $options;
                                    })
                                    ->searchable(),

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

                                Number::make(__('base.priority'), 'priority')
                                    ->buttons()
                                    ->default(0)
                                    ->updateOnPreview()
                                    ->badge(),

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
            'parent_id' => ['integer'],
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('lp_categories')->ignoreModel($item->getOriginal()),
            ],
            'icon' => ['nullable', 'string', 'max:60'],
            'priority' => ['integer', 'min:0'],
            'status' => ['required', 'integer', 'in:0,1'],
            'translations.*.title' => ['required', 'string', 'max:255'],
            'translations.*.content' => ['nullable', 'string'],
            'translations.*.description' => ['nullable', 'string', 'max:510'],
        ];
    }
}
