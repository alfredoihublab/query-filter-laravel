<?php

namespace Tests\Filters;

use Fguzman\QueryFilter;
use Fguzman\Rules\SortableColumn;
use Fguzman\Sortable;
use Tests\UserQuery;

class UserFilter extends QueryFilter
{
    public function rules(): array
    {
        return [
            'search' => 'filled',
        ];
    }

    public function search(UserQuery $query, $search)
    {
        return $query->where(function ($query) use ($search) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
        });
    }
}
