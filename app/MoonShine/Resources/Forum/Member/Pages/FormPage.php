<?php

namespace App\MoonShine\Resources\Forum\Member\Pages;

use App\MoonShine\Resources\Forum\Membergroup\MembergroupResource;
use Illuminate\Validation\Rule;
use MoonShine\Contracts\Core\TypeCasts\DataWrapperContract;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\Laravel\Pages\Crud\FormPage as BaseFormPage;
use MoonShine\UI\Components\Collapse;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Tabs;
use MoonShine\UI\Components\Tabs\Tab;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\Email;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Password;
use MoonShine\UI\Fields\PasswordRepeat;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;

class FormPage extends BaseFormPage
{
    protected function fields(): iterable
    {
        return [
            Box::make([
                Tabs::make([
                    Tab::make(__('moonshine::ui.resource.main_information'), [
                        ID::make(__('base.id'), 'id_member'),

                        Text::make(__('base.username'), 'member_name')
                            ->required(),

                        Text::make(__('base.nickname'), 'real_name')
                            ->required(),

                        BelongsTo::make(
                            __('base.group'),
                            'group',
                            'group_name',
                            MembergroupResource::class
                        )
                            ->searchable(),

                        Email::make(__('base.email'), 'email_address')
                            ->copy()
                            ->required(),

                        Date::make(__('base.birthdate'), 'birthdate')
                            ->required()
                            ->format('Y-m-d')
                            ->default(date('Y-m-d')),

                        Switcher::make(__('base.activated'), 'is_activated')
                            ->default(true),
                    ]),

                    Tab::make(__('moonshine::ui.resource.password'), [
                        Collapse::make(__('moonshine::ui.resource.change_password'), [
                            Password::make(__('moonshine::ui.resource.password'), 'passwd')
                                ->customAttributes(['autocomplete' => 'new-password'])
                                ->eye(),

                            PasswordRepeat::make(__('moonshine::ui.resource.repeat_password'), 'password_repeat')
                                ->customAttributes(['autocomplete' => 'confirm-password'])
                                ->eye(),
                        ])->icon('lock-closed'),
                    ])->icon('lock-closed'),
                ]),
            ]),
        ];
    }

    protected function rules(DataWrapperContract $item): array
    {
        return [
            'member_name' => 'required|string',
            'date_registered' => 'integer',
            'posts' => 'integer',
            'id_group' => 'required|integer',
            'real_name' => [
                'required',
                'string',
                Rule::unique('members')->ignoreModel($item->getOriginal()),
            ],
            'passwd' => $item->getKey() !== null
                ? 'sometimes|nullable|min:6|required_with:password_repeat|same:password_repeat'
                : 'required|min:6|required_with:password_repeat|same:password_repeat',
            'email_address' => [
                'sometimes',
                'bail',
                'required',
                'email',
                Rule::unique('members')->ignoreModel($item->getOriginal()),
            ],
            'birthdate' => 'sometimes|date',
            'is_activated' => 'integer',
        ];
    }
}
