<?php

namespace App\Observers;

use App\Models\Topic;

class TopicObserver
{
    public function retrieved(Topic $topic): void
    {
        //$topic->increment('num_views');
    }

    public function created(Topic $topic): void
    {
        $topic->board->increment('num_topics');
    }

    public function deleted(Topic $topic): void
    {
        $topic->board->decrement('num_topics');
    }
}
