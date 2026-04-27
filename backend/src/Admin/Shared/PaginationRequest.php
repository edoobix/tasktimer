<?php

namespace App\Admin\Shared;

class PaginationRequest
{
    public function __construct(
        public ?int $page = 1,
        public ?int $limit = 20,
    ) {
    }
}
