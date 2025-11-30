<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Portal\Param;

use App\Models\PortalParam;
use App\MoonShine\Resources\Portal\Param\Pages\FormPage;
use MoonShine\Laravel\Resources\ModelResource;

/**
 * @extends ModelResource<PortalParam>
 */
class ParamResource extends ModelResource
{
    protected string $model = PortalParam::class;

    protected function pages(): array
    {
        return [
            FormPage::class,
        ];
    }
}
