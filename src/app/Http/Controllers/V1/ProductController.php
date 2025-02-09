<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductCreateOrUpdateRequest;
use App\Http\Requests\ProductSearchRequest;
use App\Http\Resources\ProductResource;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ProductController extends Controller
{
    public function __construct(
        protected ProductService $productService
    ) {}

    #[OA\Post(
        path: "/api/v1/products",
        summary: "Create or Update Products",
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                type: "array",
                items: new OA\Items(
                    properties: [
                        new OA\Property(property: "name", type: "string", example: "iPhone 15 Pro"),
                        new OA\Property(property: "category", type: "integer", example: 1),
                        new OA\Property(property: "price", type: "number", format: "float", example: 1299.99),
                        new OA\Property(property: "stock", type: "integer", example: 50),
                    ]
                )
            )
        ),
        tags: ["Product"],
        responses: [
            new OA\Response(response: 202, description: "Products have been queued for processing.")
        ]
    )]
    public function store(ProductCreateOrUpdateRequest $request): JsonResponse
    {
        $this->productService->enqueueProducts($request->toDTO());

        return $this->successResponse(__('messages.product_queued'), $request->toDTO(), ResponseAlias::HTTP_ACCEPTED);
    }

    #[OA\Get(
        path: "/api/v1/products/search",
        summary: "Search Products",
        tags: ["Product"],
        parameters: [
            new OA\Parameter(
                name: "keyword",
                description: "Performs a keyword search",
                in: "query",
                required: true,
                schema: new OA\Schema(type: "string")
            ),
            new OA\Parameter(
                name: "category",
                description: "Filter by Category ID",
                in: "query",
                required: false,
                schema: new OA\Schema(type: "integer")
            ),
            new OA\Parameter(
                name: "min_price",
                description: "Filter by minimum price",
                in: "query",
                required: false,
                schema: new OA\Schema(type: "number", format: "float", example: 1000.00)
            ),
            new OA\Parameter(
                name: "max_price",
                description: "Filter by maximum price",
                in: "query",
                required: false,
                schema: new OA\Schema(type: "number", format: "float", example: 5000.00)
            ),
            new OA\Parameter(
                name: "min_stock",
                description: "Filter by minimum stock quantity",
                in: "query",
                required: false,
                schema: new OA\Schema(type: "integer", example: 10)
            ),
            new OA\Parameter(
                name: "max_stock",
                description: "Filter by maximum stock quantity",
                in: "query",
                required: false,
                schema: new OA\Schema(type: "integer", example: 100)
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Search results returned successfully",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "success", type: "boolean", example: true),
                        new OA\Property(property: "message", type: "string", example: "Search results retrieved successfully."),
                        new OA\Property(property: "data", type: "array", items: new OA\Items(ref: "#/components/schemas/ProductDTO"))
                    ],
                    type: "object"
                )
            ),
            new OA\Response(
                response: 400,
                description: "Invalid search query"
            )
        ]
    )]
    public function search(ProductSearchRequest $request): JsonResponse
    {
        $products = $this->productService->search($request->toDTO());

        return $this->successResponse(__('messages.search_results'), ProductResource::collection($products), ResponseAlias::HTTP_OK);
    }

    public function show(int $id): ProductResource
    {
        $product = $this->productService->getProductById($id);

        return ProductResource::make($product);
    }
}
