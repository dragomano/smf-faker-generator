<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Forum\Member;

use App\Models\Member;
use App\MoonShine\Resources\Forum\Member\Pages\DetailPage;
use App\MoonShine\Resources\Forum\Member\Pages\FormPage;
use App\MoonShine\Resources\Forum\Member\Pages\IndexPage;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Support\Attributes\Icon;

#[Icon('users')]
/**
 * @extends ModelResource<Member>
 */
class MemberResource extends ModelResource
{
    protected string $model = Member::class;

    protected string $column = 'real_name';

    protected bool $createInModal = true;

    protected bool $editInModal = true;

    public function getTitle(): string
    {
        return __('base.users');
    }

    public function search(): array
    {
        return ['member_name', 'email_address'];
    }

    protected function pages(): array
    {
        return [
            IndexPage::class,
            FormPage::class,
            DetailPage::class,
        ];
    }
}
