<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class SortByNewest implements BookFilter
{
    public function apply(Builder $query): Builder
    {
        return $query->orderBy('created_at', 'desc');
    }
}
