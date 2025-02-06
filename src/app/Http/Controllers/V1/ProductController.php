<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductCreateOrUpdateRequest;
use App\Http\Requests\ProductSearchRequest;
use App\Http\Resources\ProductResource;
use App\Services\ProductService;
use Exception;
use Illuminate\Http\JsonResponse;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ProductController extends Controller
{
    public function __construct(
        protected ProductService $productService
    ) {}

    /**
     * @OA\Post(
     *     path="/api/v1/products",
     *     summary="Create or Update Products",
     *     tags={"Product"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="name", type="string", example="iPhone 15 Pro"),
     *                 @OA\Property(property="category", type="integer", example=1),
     *                 @OA\Property(property="price", type="number", format="float", example=1299.99),
     *                 @OA\Property(property="stock", type="integer", example=50),
     *             )
     *         )
     *     ),
     *     @OA\Response(response=202, description="Products have been queued for processing.")
     * )
     * @throws Exception
     */
    public function store(ProductCreateOrUpdateRequest $request): JsonResponse
    {
        $this->productService->enqueueProducts($request->toDTO());

        return $this->successResponse(__('messages.product_queued'),$request->toDTO(), ResponseAlias::HTTP_ACCEPTED);
    }


    /**
     * @OA\Get(
     *     path="/api/v1/products/search",
     *     summary="Search Products",
     *     tags={"Product"},
     *     @OA\Parameter(
     *         name="query",
     *         in="query",
     *         description="Performs a keyword search",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="category",
     *         in="query",
     *         description="Filter by Category ID",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="min_price",
     *         in="query",
     *         description="Filter by minimum price",
     *         required=false,
     *         @OA\Schema(type="number", format="float", example=1000.00)
     *     ),
     *     @OA\Parameter(
     *         name="max_price",
     *         in="query",
     *         description="Filter by maximum price",
     *         required=false,
     *         @OA\Schema(type="number", format="float", example=5000.00)
     *     ),
     *     @OA\Parameter(
     *         name="min_stock",
     *         in="query",
     *         description="Filter by minimum stock quantity",
     *         required=false,
     *         @OA\Schema(type="integer", example=10)
     *     ),
     *     @OA\Parameter(
     *         name="max_stock",
     *         in="query",
     *         description="Filter by maximum stock quantity",
     *         required=false,
     *         @OA\Schema(type="integer", example=100)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Search results returned successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Search results retrieved successfully."),
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/ProductDTO"))
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid search query"
     *     )
     * )
     */
    public function search(ProductSearchRequest $request): JsonResponse
    {
        $products = $this->productService->search($request->toDTO());

        return $this->successResponse(__('messages.search_results'), ProductResource::collection($products), ResponseAlias::HTTP_FORBIDDEN);
    }
}
