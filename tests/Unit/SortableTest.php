<?php

namespace Tests\Unit;

use Fguzman\Sortable;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SortableTest extends TestCase
{
    /** @test */
    function gets_the_info_about_the_column_name_and_the_order_direction()
    {
        $this->assertSame(['name', 'asc'], Sortable::info('name|asc'));
        $this->assertSame(['name', 'desc'], Sortable::info('name|desc'));
        $this->assertSame(['email', 'asc'], Sortable::info('email|asc'));
        $this->assertSame(['email', 'desc'], Sortable::info('email|desc'));
    }
}
