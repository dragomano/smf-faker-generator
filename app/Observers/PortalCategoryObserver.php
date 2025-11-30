<?php

namespace App\Observers;

use App\Models\PortalCategory;

class PortalCategoryObserver
{
    public function deleted(PortalCategory $category): void
    {
        $category->pages()->update(['category_id' => 0]);
    }
}
