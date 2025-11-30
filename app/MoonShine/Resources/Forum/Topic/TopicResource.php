<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Forum\Topic;

use App\Models\Message;
use App\Models\Topic;
use App\MoonShine\Resources\Forum\Topic\Pages\DetailPage;
use App\MoonShine\Resources\Forum\Topic\Pages\FormPage;
use App\MoonShine\Resources\Forum\Topic\Pages\IndexPage;
use Illuminate\Support\Facades\DB;
use MoonShine\Contracts\Core\TypeCasts\DataWrapperContract;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Support\Attributes\Icon;
use Throwable;

#[Icon('chat-bubble-bottom-center-text')]
/**
 * @extends ModelResource<Topic>
 */
class TopicResource extends ModelResource
{
    protected string $model = Topic::class;

    protected string $column = 'firstMessage.subject';

    public function getTitle(): string
    {
        return __('base.topics');
    }

    public function search(): array
    {
        return ['firstMessage.subject', 'firstMessage.body'];
    }

    protected function pages(): array
    {
        return [
            IndexPage::class,
            FormPage::class,
            DetailPage::class,
        ];
    }

    /**
     * @throws Throwable
     */
    protected function afterCreated(DataWrapperContract $item): DataWrapperContract
    {
        DB::transaction(function () use ($item) {
            $model = $item->getOriginal();
            $data = request()->all();

            $message = Message::create([
                'id_topic' => $model->id_topic,
                'id_board' => $data['id_board'],
                'poster_time' => time(),
                'id_member' => $data['id_member_started'],
                'subject' => $data['subject'],
                'poster_name' => $model->member?->real_name ?? '',
                'poster_email' => $model->member?->email_address ?? '',
                'body' => $data['body'],
                'approved' => $data['approved'],
            ]);

            $model->updateQuietly([
                'id_first_msg' => $message->id_msg,
                'id_last_msg' => $message->id_msg,
                'num_replies' => 0,
                'num_views' => 1,
            ]);
        });

        return $item;
    }

    protected function afterUpdated(DataWrapperContract $item): DataWrapperContract
    {
        $model = $item->getOriginal();
        $data = request()->only(['subject', 'body']);

        if (! empty($data)) {
            Message::where('id_msg', $model->id_first_msg)->update([
                'subject' => $data['subject'],
                'body' => $data['body'],
            ]);
        }

        return $item;
    }
}
