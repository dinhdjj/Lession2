<?php

namespace App\Core;

class Pagination
{
    public array $items = [];

    public int $currentPage;

    public int $totalPage;

    public int $perPage;

    public int $totalItems;

    public function __construct(array $items, int $currentPage, int $perPage, int $totalItems)
    {
        $this->items = $items;
        $this->currentPage = $currentPage;
        $this->totalPage = ceil($totalItems / $perPage);
        $this->perPage = $perPage;
        $this->totalItems = $totalItems;
    }
}
