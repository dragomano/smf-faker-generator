<?php

namespace App\Observers;

use App\Models\Message;

class MessageObserver
{
    /**
     * Handle the Message "created" event.
     *
     * @param Message $message
     * @return void
     */
    public function created(Message $message): void
    {
        $message->member->increment('posts');
        $message->topic->increment('num_replies');
        $message->topic->update(['id_last_msg' => $message->id_msg]);
        $message->board->increment('num_posts');
    }

    /**
     * Handle the Message "updated" event.
     *
     * @param Message $message
     * @return void
     */
    public function updated(Message $message)
    {
        //
    }

    /**
     * Handle the Message "deleted" event.
     *
     * @param Message $message
     * @return void
     */
    public function deleted(Message $message): void
    {
        $message->member->decrement('posts');
        $message->topic->decrement('num_replies');
        $message->board->decrement('num_posts');

        if (empty($lastMsg = $message->topic->messages->last()->id_msg)) {
            $message->topic->delete();
        } else {
            $message->topic->update(['id_last_msg' => $lastMsg]);
        }
    }

    /**
     * Handle the Message "restored" event.
     *
     * @param Message $message
     * @return void
     */
    public function restored(Message $message)
    {
        //
    }

    /**
     * Handle the Message "force deleted" event.
     *
     * @param Message $message
     * @return void
     */
    public function forceDeleted(Message $message)
    {
        //
    }
}
