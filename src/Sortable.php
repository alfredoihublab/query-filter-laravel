<?php

namespace Fguzman;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class Sortable
{
    protected $currentUrl;
    protected $query = [];

    public function __construct($currentUrl)
    {
        $this->currentUrl = $currentUrl;
    }

    public static function info($sort)
    {
        if (Str::endsWith($sort, '|desc')) {
            return [Str::substr($sort, 0, -5), 'desc'];
        } else {
            return [Str::substr($sort, 0, -4), 'asc'];
        }
    }
}
