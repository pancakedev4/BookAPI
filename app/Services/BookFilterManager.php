<?php

namespace App\Services;

use App\Filters\BookFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class BookFilterManager
{
    protected array $filters = [];

    public function __construct(protected Request $request)
    {
    }

    public function addFilter(BookFilter $filter): self
    {
        $this->filters[] = $filter;
        return $this;
    }

    public function apply(Builder $query): Builder
    {
        foreach ($this->filters as $filter) {
            $query = $filter->apply($query);
        }

        return $query;
    }

    /**
     * Создает менеджер фильтров на основе запроса
     */
    public static function fromRequest(Request $request): self
    {
        $manager = new self($request);

        $sort = $request->get('sort', 'new');

        switch ($sort) {
            case 'popular':
                $manager->addFilter(new \App\Filters\SortByPopular());
                break;
            
            case 'alphabetical':
                $manager->addFilter(new \App\Filters\SortByAlphabetical());
                break;
            
            case 'featured':
                $manager->addFilter(new \App\Filters\SortByFeatured());
                break;
            
            case 'new':
            default:
                $manager->addFilter(new \App\Filters\SortByNewest());
                break;
        }

        return $manager;
    }

    /**
     * Получает заголовок для текущей сортировки
     */
    public function getSortTitle(): string
    {
        $sort = $this->request->get('sort', 'new');

        return match($sort) {
            'popular' => 'Популярные',
            'alphabetical' => 'По алфавиту',
            'featured' => 'Рекомендуемые',
            default => 'Новые',
        };
    }
}
