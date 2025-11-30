<?php

namespace App\Observers;

use App\Models\PortalPage;

class PortalPageObserver
{
    public function retrieved(PortalPage $page): void
    {
        //$page->increment('num_views');
    }

    public function created(PortalPage $page): void
    {
        $page->increment('num_views');
        $page->updateQuietly(['created_at' => time()]);
    }

    public function updated(PortalPage $page): void
    {
        $page->updateQuietly(['updated_at' => time()]);
    }

    public function deleted(PortalPage $page): void
    {
        $lastComment = $page->comments()->latest('id')->first();

        $page->updateQuietly([
            'deleted_at' => time(),
            'last_comment_id' => $lastComment ? $lastComment->id : 0,
        ]);

        $page->comments()->delete();
        $page->tags()->detach();
    }

    public function restored(PortalPage $page): void
    {
        $page->updateQuietly(['deleted_at' => 0]);
    }
}
