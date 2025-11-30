<?php

namespace App\Models\Traits;

use Carbon\Carbon;

trait HasUnixTimeFields
{
    public function getTimestampAttribute($value): ?Carbon
    {
        if (! $value) {
            return null;
        }

        if ($value instanceof Carbon) {
            return $value;
        }

        return Carbon::createFromTimestamp((int) $value);
    }

    public function setTimestampAttribute($value, string $attribute): void
    {
        if ($value instanceof Carbon) {
            $this->attributes[$attribute] = $value->getTimestamp();
        } elseif (is_numeric($value)) {
            $this->attributes[$attribute] = (int) $value;
        } elseif (! empty($value)) {
            $this->attributes[$attribute] = Carbon::parse($value)->getTimestamp();
        } else {
            $this->attributes[$attribute] = null;
        }
    }
}
