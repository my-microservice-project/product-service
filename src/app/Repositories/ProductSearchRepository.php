<?php

namespace App\Repositories;

use App\Data\ProductDTO;
use App\Data\ProductSearchDTO;
use App\Enums\ElasticIndexEnum;
use App\Managers\ElasticSearchManager;
use App\Repositories\Contracts\ProductSearchRepositoryInterface;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Illuminate\Support\Collection;

class ProductSearchRepository implements ProductSearchRepositoryInterface
{
    public function __construct(protected ElasticSearchManager $elasticSearchManager) {}

    /**
     * @throws ClientResponseException
     * @throws ServerResponseException
     */
    public function findProducts(ProductSearchDTO $dto): Collection
    {
        $query = $this->buildQuery($dto);
        $response = $this->elasticSearchManager->search($query);

        return $this->mapToDTOCollection($response);
    }

    /**
     * Elasticsearch sorgusunu oluşturur.
     */
    private function buildQuery(ProductSearchDTO $dto): array
    {
        return [
            'index' => ElasticIndexEnum::PRODUCTS->getValue(),
            'body' => [
                'query' => [
                    'bool' => [
                        'must' => array_filter([
                            $this->getTextSearchClause($dto->keyword),
                            ...$this->getOptionalFilters($dto)
                        ])
                    ]
                ]
            ]
        ];
    }

    /**
     * Hem "name" hem de "description" alanlarında arama yapar.
     */
    private function getTextSearchClause(string $query): array
    {
        $shouldQueries = array_merge(
            $this->matchPhrasePrefixQueries(['name', 'description'], $query),
            $this->fuzzyQueries(['name', 'description'], $query)
        );

        // Eğer `should` sorguları boşsa, bu bölümü tamamen kaldır
        if (empty($shouldQueries)) {
            return [];
        }

        return [
            'bool' => [
                'should' => $shouldQueries,
                'minimum_should_match' => 1
            ]
        ];
    }


    /**
     * `match_phrase_prefix` ile belirli alanlar üzerinde arama yapar.
     */
    private function matchPhrasePrefixQueries(array $fields, string $query): array
    {
        return array_map(fn ($field) => [
            'match_phrase_prefix' => [
                $field => [
                    'query' => $query,
                    'max_expansions' => 10
                ]
            ]
        ], $fields);
    }

    /**
     * `fuzzy` sorguları belirli alanlar için oluşturur.
     */
    private function fuzzyQueries(array $fields, string $query): array
    {
        return array_map(fn ($field) => [
            'fuzzy' => [
                $field => [
                    'value' => $query,
                    'fuzziness' => 'AUTO'
                ]
            ]
        ], $fields);
    }

    /**
     * Kategori, fiyat ve stok filtrelerini oluşturur.
     */
    private function getOptionalFilters(ProductSearchDTO $dto): array
    {
        return array_filter([
            $this->getCategoryFilter($dto->category),
            $this->getRangeFilter($dto->min_price, $dto->max_price, 'price'),
            $this->getRangeFilter($dto->min_stock, $dto->max_stock, 'stock')
        ]);
    }

    /**
     * Kategori filtresi oluşturur.
     */
    private function getCategoryFilter(?int $category): ?array
    {
        return $category ? ['term' => ['category' => $category]] : null;
    }

    /**
     * Genel amaçlı bir range filter oluşturur.
     */
    private function getRangeFilter(?float $min, ?float $max, string $field): ?array
    {
        $range = array_filter([
            'gte' => $min,
            'lte' => $max
        ]);

        return !empty($range) ? ['range' => [$field => $range]] : null;
    }

    /**
     * Elasticsearch sonucunu DTO koleksiyonuna dönüştürme
     */
    private function mapToDTOCollection(array $response): Collection
    {
        return collect($response['hits']['hits'] ?? [])
            ->map(fn ($item) => ProductDTO::from($item['_source']));
    }
}
