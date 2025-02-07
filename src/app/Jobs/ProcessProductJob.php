<?php

namespace App\Jobs;

use App\Pipelines\ProductUpdateOrCreatePipeline;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Bus\Queueable;
use App\Data\ProductDTO;

class ProcessProductJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(protected ProductDTO $productDTO)
    {}

    public function handle(): void
    {
        app(Pipeline::class)
            ->send($this->productDTO)
            ->through(ProductUpdateOrCreatePipeline::stages())
            ->thenReturn();
    }
}
