<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Portal\Comment;

use App\Models\PortalComment;
use App\MoonShine\Resources\Portal\Comment\Pages\DetailPage;
use App\MoonShine\Resources\Portal\Comment\Pages\FormPage;
use App\MoonShine\Resources\Portal\Comment\Pages\IndexPage;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Support\Attributes\Icon;

#[Icon('chat-bubble-bottom-center-text')]
/**
 * @extends ModelResource<PortalComment>
 */
class CommentResource extends ModelResource
{
    protected string $model = PortalComment::class;

    protected array $with = ['page', 'member', 'parent', 'translations'];

    public function getTitle(): string
    {
        return __('base.comments');
    }

    public function search(): array
    {
        return [
            'message',
            'page.translation.title',
            'member.real_name',
        ];
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
