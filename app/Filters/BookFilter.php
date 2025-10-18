<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

interface BookFilter
{
    public function apply(Builder $query): Builder;
}
