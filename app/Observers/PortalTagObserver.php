<?php

namespace App\Observers;

use App\Models\PortalTag;

class PortalTagObserver
{
    public function deleted(PortalTag $tag): void
    {
        $tag->pages()->detach();
    }
}
