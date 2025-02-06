<?php

namespace Database\Seeders;

use App\Data\ProductDTO;
use App\Services\ProductService;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function __construct(protected ProductService $productService)
    {}

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonPath = database_path('seeders/data/products.json');
        if (!file_exists($jsonPath)) {

            $this->command->error("JSON dosyası bulunamadı: {$jsonPath}");
            return;

        }

        $products = json_decode(file_get_contents($jsonPath), true);
        if (!$products) {

            $this->command->error("JSON formatı hatalı!");
            return;

        }

        try {
            $productsCollection = ProductDTO::collection($products);

            $this->productService->enqueueProducts($productsCollection);

            $this->command->info('Ürünler kuyruğa eklendi.');

        } catch (\Exception $e) {

            $this->command->error("Hata: " . $e->getMessage());

        }
    }
}
