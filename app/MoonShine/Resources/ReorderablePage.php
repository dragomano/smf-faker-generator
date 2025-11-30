<?php

namespace App\MoonShine\Resources;

use Illuminate\Http\JsonResponse;
use MoonShine\Contracts\Core\DependencyInjection\CrudRequestContract;
use MoonShine\Support\Attributes\AsyncMethod;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Laravel\Pages\Crud\IndexPage;
use MoonShine\Support\ListOf;
use MoonShine\UI\Components\ActionButton;
use MoonShine\UI\Components\Table\TableBuilder;

abstract class ReorderablePage extends IndexPage
{
    #[AsyncMethod]
    public function reorder(CrudRequestContract $request): JsonResponse
    {
        $resource = $this->getResource();

        assert($resource instanceof ReorderableResource);

        if ($request->filled('data')) {
            [$primaryKey, $sortColumn] = $resource->getReorderableConfig();

            $ids = explode(',', $request->input('data'));

            foreach ($ids as $position => $id) {
                $resource
                    ->getModel()
                    ->newQuery()
                    ->where($primaryKey, $id)
                    ->update([$sortColumn => $position + 1]);
            }
        }

        return response()->json(['success' => true]);
    }

    protected function modifyListComponent(ComponentContract $component): ComponentContract
    {
        assert($component instanceof TableBuilder);

        return $component
            ->reorderable(
                /* @uses reorder */
                $this->getResource()->getAsyncMethodUrl('reorder')
            )
            ->customAttributes([
                'data-handle' => '.handle',
            ]);
    }

    protected function buttons(): ListOf
    {
        return parent::buttons()
            ->prepend(
                ActionButton::make()
                    ->icon('bars-4')
                    ->square()
                    ->secondary()
                    ->customAttributes([
                        'style' => 'cursor: move',
                        'class' => 'handle',
                    ])
            );
    }
}
