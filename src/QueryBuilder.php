<?php

namespace Fguzman;

use BadMethodCallException;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;

class QueryBuilder extends Builder
{
    private $filters;
    /**
     * Apply filters in the model query
     *
     */
    public function applyFilters(QueryBuilder $filter = null,array $data = null)
    {
        return $this->filterBy($filter ?: $this->newQueryFilter(), $data ?: request()->all());    }
    /**
     * return a new filter instance to apply
     */
    protected function newQueryFilter()
    {
        if (method_exists($this->model, 'newQueryFilter')) {
            return $this->model->newQueryFilter();
        }

        if (class_exists($filtersClass = '\App\Filters\\'.class_basename($this->model).'Filter')) {
            return new $filtersClass;
        }
        throw new \BadMethodCallException(
            sprintf(
                'no query filter was found  for the model [%s]',
                get_class($this->model)
            )
        );
    }
    /**
     * Apply filters to the model
     */
    public function filterBy(QueryFilter $filters, array $data)
    {
        $this->filters = $filters;

        return $filters->applyTo($this, $data);
    }
    /**
     * custom query in sql format
     */
    public function whereQuery($subquery, $operator, $value = null)
    {
        $this->addBinding($subquery->getBindings());
        $this->where(DB::raw("({$subquery->toSql()})"), $operator, $value);

        return $this;
    }

    public function onlyTrashedIf($value)
    {
        if ($value) {
            $this->onlyTrashed();
        }

        return $this;
    }
    /**
     * custom paginate the given query
     */
    public function paginate($perPage = null, $columns = ['*'], $pageName = 'page', $page = null)
    {
        $paginator = parent::paginate($perPage, $columns, $pageName, $page);

        if ($this->filters) {
            $paginator->appends($this->filters->valid());
        }

        return $paginator;
    }
}
