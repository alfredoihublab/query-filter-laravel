<?php

namespace Fguzman;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

abstract class QueryFilter
{
    /**
     * valid data for the filter
     * @var array
     */
    protected $valid = [];

    abstract public function rules(): array;
    /**
     * Apply filter to query
     */
    public function applyTo($query, array $filters)
    {
        $rules = $this->rules();

        $validator = Validator::make(array_intersect_key($filters, $rules), $rules);

        $this->valid = $validator->valid();

        foreach ($this->valid as $name => $value) {
            $this->applyFilter($query, $name, $value);
        }

        return $query;
    }

    protected function applyFilter($query, $name, $value)
    {
        $method = Str::camel($name);

        if (method_exists($this, $method)) {
            $this->$method($query, $value);
        } else {
            $query->where($name, $value);
        }
    }
    /**
     * Get data valid for the filter
     */

    public function valid()
    {
        return $this->valid;
    }
    /**
     * Order by column
     */
    public function order(Builder $query, string $value)
    {
        [$column, $direction] = Sortable::info($value);

        $query->orderBy($this->getColumnName($column), $direction);
    }
    /**
     * Get column in alias array
     */
    protected function getColumnName($alias)
    {
        return $this->aliases[$alias] ?? $alias;
    }
}
