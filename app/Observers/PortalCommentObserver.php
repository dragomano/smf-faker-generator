<?php

namespace App\Observers;

use App\Models\PortalComment;

class PortalCommentObserver
{
    public function created(PortalComment $comment): void
    {
        $comment->updateQuietly(['created_at' => time()]);

        $comment->page->updateQuietly(['last_comment_id' => $comment->id]);
        $comment->page->increment('num_comments');
    }

    public function updated(PortalComment $comment): void
    {
        $comment->updateQuietly(['updated_at' => time()]);
    }

    public function deleted(PortalComment $comment): void
    {
        $comment->page->decrement('num_comments');
    }
}
