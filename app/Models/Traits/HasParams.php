<?php

namespace App\Models\Traits;

use App\Models\PortalParam;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasParams
{
    abstract protected function getEntityName(): string;

    public function params(): HasMany
    {
        return $this->hasMany(PortalParam::class, 'item_id', $this->primaryKey)
            ->where('type', $this->getEntityName());
    }

    public function getParam(string $name, $default = null)
    {
        return $this->params()->where('name', $name)->value('value') ?? $default;
    }

    public function setParam(string $name, string $value): void
    {
        $this->params()->updateOrCreate(
            ['name' => $name],
            ['value' => $value]
        );
    }

    public function getParamsArray(): array
    {
        return $this->params()->pluck('value', 'name')->toArray();
    }

    public function hasParam(string $name): bool
    {
        return $this->params()->where('name', $name)->exists();
    }

    protected static function bootHasParams(): void
    {
        static::deleting(static function (self $model): void {
            $model->params()->delete();
        });
    }
}
