<?php

namespace Tests\Unit;

use Tests\TestCase;
use Fguzman\Rules\SortableColumn;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SortableColumnTest extends TestCase
{
   /** @test */
   public function validates_sortable_values()
   {
       $rule = new SortableColumn(['id','name','email','date']);

       $this->assertTrue($rule->passes('sort', 'id|asc'));
       $this->assertTrue($rule->passes('sort', 'id|desc'));
       $this->assertTrue($rule->passes('sort', 'name|asc'));
       $this->assertTrue($rule->passes('sort', 'email|asc'));
       $this->assertTrue($rule->passes('sort', 'name|desc'));
       $this->assertTrue($rule->passes('sort', 'email|desc'));

       $this->assertFalse($rule->passes('sort', 'first_name|asc'));
       $this->assertFalse($rule->passes('sort', 'name|descendent'));
       $this->assertFalse($rule->passes('sort', 'asc-name'));
       $this->assertFalse($rule->passes('sort', 'email-'));
       $this->assertFalse($rule->passes('sort', 'name|descx'));
       $this->assertFalse($rule->passes('sort', 'desc-name'));
   }
}
