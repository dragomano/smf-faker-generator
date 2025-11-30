<?php

namespace App\Observers;

use App\Models\PortalTranslation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class TranslationObserver
{
    public function saved(PortalTranslation $translation): void
    {
        $this->touchParent($translation);
    }

    public function deleted(PortalTranslation $translation): void
    {
        $this->touchParent($translation);
    }

    private function touchParent(PortalTranslation $translation): void
    {
        $type = Relation::morphMap()[$translation->type] ?? null;
        $id = $translation->item_id ?? null;

        if ($type && $id) {
            /* @var Model $type */
            $parent = new $type;

            if (Schema::hasColumn($parent->getTable(), 'updated_at')) {
                DB::table($parent->getTable())
                    ->where($parent->getKeyName(), $id)
                    ->update(['updated_at' => time()]);
            }
        }
    }
}
