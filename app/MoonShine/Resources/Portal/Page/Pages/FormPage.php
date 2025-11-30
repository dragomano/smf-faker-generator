<?php

namespace App\MoonShine\Resources\Portal\Page\Pages;

use App\Enums\EntryType;
use App\Enums\PageStatus;
use App\Enums\Permission;
use App\Models\PortalCategory;
use App\MoonShine\Resources\Portal\Comment\CommentResource;
use App\MoonShine\Resources\Portal\Tag\TagResource;
use App\MoonShine\Resources\Portal\Translation\TranslationResource;
use Illuminate\Validation\Rule;
use MoonShine\Contracts\Core\TypeCasts\DataWrapperContract;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\Laravel\Fields\Relationships\BelongsToMany;
use MoonShine\Laravel\Fields\Relationships\HasMany;
use MoonShine\Laravel\Fields\Relationships\RelationRepeater;
use MoonShine\Laravel\Fields\Slug;
use MoonShine\Laravel\Pages\Crud\FormPage as BaseFormPage;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Layout\Column;
use MoonShine\UI\Components\Layout\Grid;
use MoonShine\UI\Components\Tabs;
use MoonShine\UI\Components\Tabs\Tab;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\Hidden;
use MoonShine\UI\Fields\Select;

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
                        resource: TranslationResource::class
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

                                Select::make(__('base.category'), 'category_id')
                                    ->options(fn() => [0 => __('base.none')] + PortalCategory::get()
                                        ->pluck('translation.title', 'category_id')
                                        ->toArray()
                                    )
                                    ->searchable(),

                                BelongsTo::make(__('base.author'), 'member', 'real_name')
                                    ->asyncSearch('real_name')
                                    ->asyncOnInit()
                                    ->required()
                                    ->default(0),

                                Hidden::make(__('base.content_type'), 'type')
                                    ->default(request('type')),

                                Select::make(__('base.page_type'), 'entry_type')
                                    ->options(EntryType::values())
                                    ->default(EntryType::DEFAULT),

                                Select::make(__('base.permissions'), 'permissions')
                                    ->options(Permission::values())
                                    ->default(Permission::ADMIN),

                                Select::make(__('base.status'), 'status')
                                    ->options(PageStatus::values())
                                    ->default(PageStatus::ACTIVE),

                                BelongsToMany::make(__('base.tags'), 'tags', resource: TagResource::class)
                                    ->selectMode()
                                    ->searchable()
                                    ->selectMaxItems(6),

                                Hidden::make('', 'page_id'),

                                Date::make(__('base.created_at'), 'created_at')
                                    ->withTime()
                                    ->showWhen('page_id', 0),
                            ]),
                        ])
                            ->columnSpan(4),
                    ]),
                ]),

                Tab::make(__('base.comments'), [
                    HasMany::make('', 'comments', resource: CommentResource::class)
                        ->creatable()
                        ->disableOutside()
                ]),
            ]),
        ];
    }

    protected function rules(DataWrapperContract $item): array
    {
        return [
            'category_id' => ['required', 'integer'],
            'author_id' => ['required', 'integer', 'exists:members,id_member'],
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('lp_pages')->ignoreModel($item->getOriginal()),
            ],
            'type' => ['required', 'string', 'max:10'],
            'permissions' => ['required', 'integer', 'between:0,4'],
            'status' => ['required', 'integer', 'between:0,4'],
            'translations.*.title' => ['required', 'string', 'max:255'],
            'translations.*.content' => ['required', 'string'],
            'translations.*.description' => ['nullable', 'string', 'max:510'],
            'params.*.name' => ['required', 'string', 'max:60'],
            'params.*.value' => ['required', 'string', 'max:255'],
        ];
    }
}
