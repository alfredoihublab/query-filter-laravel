<?php

namespace Tests;

use Fguzman\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;

class UserQuery extends QueryBuilder
{
    public function findByEmail($email)
    {
        return $this->where(compact('email'))->first();
    }
    public function findByName($name)
    {
        return $this->where(compact('name'))->first();
    }
}
