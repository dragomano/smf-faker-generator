<?php

namespace App\MoonShine\Resources\Portal\Block\Pages;

use App\Enums\ContentClass;
use App\Enums\Permission;
use App\Enums\Placement;
use App\Enums\TitleClass;
use App\MoonShine\Resources\Portal\Block\BlockTranslationResource;
use App\MoonShine\Resources\Portal\Param\ParamResource;
use Bugo\MoonShine\FontAwesome\Fields\IconSelect;
use MoonShine\Contracts\Core\TypeCasts\DataWrapperContract;
use MoonShine\Laravel\Fields\Relationships\RelationRepeater;
use MoonShine\Laravel\Pages\Crud\FormPage as BaseFormPage;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Layout\Column;
use MoonShine\UI\Components\Layout\Grid;
use MoonShine\UI\Components\Table\TableBuilder;
use MoonShine\UI\Components\Tabs;
use MoonShine\UI\Components\Tabs\Tab;
use MoonShine\UI\Fields\Hidden;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Select;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;

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
                        resource: BlockTranslationResource::class
                    )
                        ->removable()
                        ->vertical(),
                ]),

                Tab::make(__('base.additional'), [
                    Grid::make([
                        Column::make([
                            Box::make(__('base.basic_params'), [
                                IconSelect::make(__('base.icon'), 'icon')
                                    ->async()
                                    ->searchable(),

                                Hidden::make(__('base.content_type'), 'type')
                                    ->default(request('type')),

                                Select::make(__('base.placement'), 'placement')
                                    ->options(Placement::values())
                                    ->default(Placement::first()),

                                Number::make(__('base.priority'), 'priority')
                                    ->default(0)
                                    ->buttons()
                                    ->hint(__('base.display_order_hint')),

                                Switcher::make(__('base.status'), 'status')
                                    ->onValue(1)
                                    ->offValue(0)
                                    ->default(true),
                            ]),
                        ])
                            ->columnSpan(6),

                        Column::make([
                            Box::make(__('base.advanced_params'), [
                                Select::make(__('base.permissions'), 'permissions')
                                    ->options(Permission::values())
                                    ->default(Permission::ADMIN),

                                Text::make(__('base.areas'), 'areas')
                                    ->default('all')
                                    ->hint(__('base.areas_hint')),

                                Select::make(__('base.title_class'), 'title_class')
                                    ->options(TitleClass::values())
                                    ->default(TitleClass::first()),

                                Select::make(__('base.content_class'), 'content_class')
                                    ->options(ContentClass::values())
                                    ->default(ContentClass::first()),
                            ]),
                        ])
                            ->columnSpan(6),
                    ]),
                ]),

                Tab::make(__('base.params'), [
                    RelationRepeater::make(
                        '',
                        'params',
                        resource: ParamResource::class
                    )
                        ->removable()
                        ->modifyTable(
                            fn(TableBuilder $table) => $table
                                ->tdAttributes(
                                    function (?DataWrapperContract $data, int $row, int $cell) {
                                        if (empty($cell)) {
                                            return ['style' => 'width: 0'];
                                        }

                                        return [];
                                    }
                                )
                        ),
                ]),
            ]),
        ];
    }

    protected function rules(DataWrapperContract $item): array
    {
        return [
            'type' => ['required', 'string', 'max:255'],
            'placement' => ['required', 'string', 'max:10'],
            'icon' => ['nullable', 'string', 'max:60'],
            'priority' => ['integer', 'min:0', 'max:255'],
            'permissions' => ['integer', 'min:0', 'max:255'],
            'status' => ['integer', 'in:0,1'],
            'areas' => ['string', 'max:255'],
            'title_class' => ['nullable', 'string', 'max:255'],
            'content_class' => ['nullable', 'string', 'max:255'],
            'translations.*.title' => ['nullable', 'string', 'max:255'],
            'translations.*.content' => ['nullable', 'string'],
            'translations.*.description' => ['nullable', 'string', 'max:510'],
            'params.*.name' => ['required', 'string', 'max:60'],
            'params.*.value' => ['required', 'string', 'max:255'],
        ];
    }
}
