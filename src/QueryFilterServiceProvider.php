<?php
namespace Fguzman;

use Fguzman\Commands\MakeQuery;
use Fguzman\Commands\MakeFilter;
use Illuminate\Support\ServiceProvider;

class QueryFilterServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                MakeQuery::class,
                MakeFilter::class
            ]);
        }
    }
}
