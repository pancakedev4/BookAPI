<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class SortByFeatured implements BookFilter
{
    public function apply(Builder $query): Builder
    {
        return $query->where('is_featured', true)
            ->orderBy('created_at', 'desc');
    }
}
