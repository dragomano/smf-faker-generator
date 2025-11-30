<?php

namespace App\MoonShine\Resources\Portal;

use App\Enums\ContentType;
use Illuminate\Support\Collection;
use MoonShine\Contracts\UI\ActionButtonContract;
use MoonShine\Laravel\Pages\Crud\FormPage;
use MoonShine\Support\ListOf;
use MoonShine\UI\Components\ActionButton;

trait HasCustomCreateButtons
{
    protected function topLeftButtons(): ListOf
    {
        $createUrl = $this->getCreateUrl();

        return new ListOf(
            ActionButtonContract::class,
            $this->getContentTypes()
                ->map(fn($label, $key) =>
                    ActionButton::make(__('moonshine::ui.create') . ': ' . $label, "$createUrl?type=$key")
                        ->primary()
                        ->icon('plus')
                )
                ->values()
                ->toArray()
        );
    }

    protected function getCreateUrl(): string
    {
        $formPage = $this->getResource()
            ->getPages()
            ->first(fn($page) => $page instanceof FormPage);

        return $this->getResource()
            ->getRouter()
            ->withPage($formPage)
            ->to('resource.page');
    }

    protected function getContentTypes(): Collection
    {
        return collect(ContentType::values());
    }
}
