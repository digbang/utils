<?php

namespace Digbang\Utils\Pagination;

use Digbang\Utils\PaginationData;
use Illuminate\Pagination\LengthAwarePaginator;

class EntityPagination extends LengthAwarePaginator
{
    protected $paginationData;

    public function __construct($items, int $total, PaginationData $paginationData, string $path = null)
    {
        $this->paginationData = $paginationData;
        $lastPage = $paginationData->getLimit() ? (int) ceil($total / $paginationData->getLimit()) : 1;
        $this->currentPage = max(min($paginationData->getPage(), $lastPage), 1);

        $perPage = ! $paginationData->getLimit() ? $total : $paginationData->getLimit();

        $path = $path ?: \Illuminate\Pagination\Paginator::resolveCurrentPath();

        parent::__construct($items, $total, $perPage, $this->currentPage, compact('path'));
    }

    public function getPaginationData(): PaginationData
    {
        return $this->paginationData;
    }

    public function getItems(): array
    {
        return $this->getCollection()->toArray();
    }
}
