<?php

namespace App\Observers;

use App\Models\Category;

class CategoryObserver
{
    public function created(Category $category): void
    {
        $category->increment('cat_order', Category::max('cat_order') + 1);
    }
}
