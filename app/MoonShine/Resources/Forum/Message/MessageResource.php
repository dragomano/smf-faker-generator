<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Forum\Message;

use App\Models\Message;
use App\MoonShine\Resources\Forum\Message\Pages\DetailPage;
use App\MoonShine\Resources\Forum\Message\Pages\FormPage;
use App\MoonShine\Resources\Forum\Message\Pages\IndexPage;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Support\Attributes\Icon;

#[Icon('chat-bubble-left-right')]
/**
 * @extends ModelResource<Message>
 */
class MessageResource extends ModelResource
{
    protected string $model = Message::class;

    protected string $column = 'subject';

    protected array $with = ['topic'];

    protected bool $createInModal = true;

    protected bool $editInModal = true;

    public function getTitle(): string
    {
        return __('base.messages');
    }

    public function search(): array
    {
        return ['subject', 'body'];
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
