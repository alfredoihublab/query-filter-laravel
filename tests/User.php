<?php

namespace Tests;

use Tests\UserQuery;
use Tests\Filters\UserFilter;
use Illuminate\Database\Eloquent\Model;

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
