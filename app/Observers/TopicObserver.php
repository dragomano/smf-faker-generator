<?php

namespace App\Observers;

use App\Models\Message;
use App\Models\Topic;

class TopicObserver
{
    /**
     * Handle the Topic "created" event.
     *
     * @param Topic $topic
     * @return void
     */
    public function created(Topic $topic)
    {
        $message = Message::factory()->withRandomImage()->create([
            'id_topic' => $topic->id_topic,
            'id_board' => $topic->id_board,
            'id_member' => $topic->id_member_started,
            'poster_name' => $topic->member->real_name,
            'poster_email' => $topic->member->email_address,
        ]);

        $topic->update(['id_first_msg' => $message->id_msg]);
        $topic->board->increment('num_topics');
    }

    /**
     * Handle the Topic "updated" event.
     *
     * @param Topic $topic
     * @return void
     */
    public function updated(Topic $topic)
    {
        //
    }

    /**
     * Handle the Topic "deleted" event.
     *
     * @param Topic $topic
     * @return void
     */
    public function deleted(Topic $topic)
    {
        $topic->board->decrement('num_topics');
    }

    /**
     * Handle the Topic "restored" event.
     *
     * @param Topic $topic
     * @return void
     */
    public function restored(Topic $topic)
    {
        //
    }

    /**
     * Handle the Topic "force deleted" event.
     *
     * @param Topic $topic
     * @return void
     */
    public function forceDeleted(Topic $topic)
    {
        //
    }
}
