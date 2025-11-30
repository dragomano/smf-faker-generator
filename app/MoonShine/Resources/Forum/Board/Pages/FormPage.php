<?php

namespace App\MoonShine\Resources\Forum\Board\Pages;

use App\Models\Board;
use Illuminate\Validation\Rule;
use MoonShine\Contracts\Core\TypeCasts\DataWrapperContract;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\Laravel\Pages\Crud\FormPage as BaseFormPage;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Select;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;

class FormPage extends BaseFormPage
{
    protected function fields(): iterable
    {
        return [
            Box::make([
                ID::make(__('base.id'), 'id_board'),

                Text::make(__('base.title'), 'name')
                    ->required(),

                Textarea::make(__('base.description'), 'description')
                    ->required(),

                BelongsTo::make(__('base.category'), 'category', 'name'),

                Number::make(__('base.child_level'), 'child_level')
                    ->min(0)
                    ->default(0),

                Select::make(__('base.parent_board'), 'id_parent')
                    ->options(function() {
                        $currentId = $this->getResource()->getItem()?->id_board;

                        return [0 => __('base.none')] + Board::when(
                                $currentId, fn($query) => $query->where('id_board', '!=', $currentId)
                            )
                            ->pluck('name', 'id_board')
                            ->toArray();
                    })
                    ->searchable(),

                Text::make(__('base.user_groups'), 'member_groups')
                    ->default('-1,0'),
            ]),
        ];
    }

    protected function rules(DataWrapperContract $item): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'id_cat' => ['required', 'integer', 'exists:categories,id_cat'],
            'child_level' => ['integer'],
            'id_parent' => [
                'integer',
                function (string $attribute, mixed $value) {
                    if ((int) $value === 0) {
                        return;
                    }

                    $rule = Rule::exists('boards', 'id_board');
                    validator(['value' => $value], ['value' => $rule])->validate();
                },
            ],
            'member_groups' => ['string', 'max:255'],
        ];
    }
}
