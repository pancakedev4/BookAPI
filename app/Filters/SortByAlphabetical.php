<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class SortByAlphabetical implements BookFilter
{
    public function apply(Builder $query): Builder
    {
        return $query->orderBy('title', 'asc');
    }
}
