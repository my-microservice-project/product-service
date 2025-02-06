<?php

namespace App\Pipelines\Stages;

use App\Actions\CreateProductAction;
use App\Actions\UpdateProductAction;
use App\Data\ProductDTO;
use Closure;
use Illuminate\Support\Facades\Log;

class UpdateOrCreateProduct
{
    public function __construct(
        protected CreateProductAction $createProductAction,
        protected UpdateProductAction $updateProductAction
    )
    {}

    public function handle(ProductDTO $productDTO, Closure $next): ProductDTO
    {
        $decidedAction = $this->decideAction($productDTO);
        Log::info('UpdateOrCreateProduct stage is called', ['decided_action_name' => $decidedAction::class]);
        $productDTO = $decidedAction->execute($productDTO);
        return $next($productDTO);
    }

    private function decideAction(ProductDTO $productDTO): CreateProductAction|UpdateProductAction
    {
        return $productDTO->hasId() ? $this->updateProductAction : $this->createProductAction;
    }
}
