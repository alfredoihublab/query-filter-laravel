<?php

namespace Tests\Filters;

use Tests\UserQuery;
use Fguzman\Sortable;
use Fguzman\QueryFilter;
use Fguzman\Rules\SortableColumn;

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
