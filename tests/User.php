<?php

namespace Tests;

use Illuminate\Database\Eloquent\Model;
use Tests\Filters\UserFilter;
use Tests\UserQuery;

class User extends Model
{
    protected $guarded = [];

    /**
     * @return UserFilter
     */
    public function newQueryFilter()
    {
        return new UserFilter();
    }

    public function newEloquentBuilder($query)
    {
        return new UserQuery($query);
    }
}
