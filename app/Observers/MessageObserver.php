<?php

namespace App\Observers;

use App\Models\Member;
use App\Models\Message;
use App\Models\Topic;

class MessageObserver
{
    public function created(Message $message): void
    {
        $message->member->increment('posts');
        $message->topic->increment('num_replies');

        Topic::where('id_topic', $message->id_topic)
            ->where('id_first_msg', 0)
            ->update(['id_first_msg' => $message->id_msg, 'num_replies' => 0]);

        $message->topic->updateQuietly(['id_last_msg' => $message->id_msg]);
        $message->board->increment('num_posts');

        $poster = Member::find($message->id_member);

        $data = ['poster_time' => time()];

        if (empty($message->poster_name)) {
            $data['poster_name'] = $poster->real_name;
        }

        if (empty($message->poster_email)) {
            $data['poster_email'] = $poster->email_address;
        }

        $message->updateQuietly($data);
    }

    public function updated(Message $message): void
    {
        $message->updateQuietly(['modified_time' => time()]);
    }

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
}
