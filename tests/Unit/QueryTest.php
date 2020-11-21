<?php

namespace Tests\Unit;

use Tests\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class QueryTest extends TestCase
{
    use RefreshDatabase;

    public $user;
    /** @test */
    function a_user_can_search_by_name_with_user_query_filter()
    {
        User::create([
            'name' => 'Felipe',
            'email' => 'felipe@test.com'
        ]);
        $this->user = User::create([
            'name' => 'Delia',
            'email'  => 'deli@test.com'
        ]);

        $this->assertEquals($this->user->name, User::query()->findByName('Delia')->name);
    }
    /** @test */
    function a_user_can_search_by_email_with_user_query_filter()
    {
        $this->user = User::create([
            'name' => 'Felipe',
            'email' => 'felipe@test.com'
        ]);
        //another users
        User::create([
            'name' => 'Delia',
            'email'  => 'deli@test.com'
        ]);

        $this->assertEquals($this->user->id, User::query()->findByEmail('felipe@test.com')->id);
    }
    /** @test */
    function apply_filters_by_name()
    {
        User::create([
            'name' => 'Felipe',
            'email' => 'felipe@test.com'
        ]);
        //another users
        User::create([
            'name' => 'Delia',
            'email'  => 'deli@test.com'
        ]);

        $this->assertContains('Delia',
            User::query()->applyFilters(null, ['search' => 'Delia'])
                        ->get()->pluck('name')->toArray()
        );
        $this->assertNotContains('Felipe',
            User::query()->applyFilters(null, ['search' => 'Delia'])
                    ->get()->pluck('email')->toArray()
        );

    }
    /** @test */
    function apply_filter_by_email()
    {
        User::create([
            'name' => 'Felipe',
            'email' => 'felipe@test.com'
        ]);
        User::create([
            'name' => 'Delia',
            'email'  => 'deli@test.com'
        ]);

        $this->assertContains('felipe@test.com',
            User::query()->applyFilters(null, ['search' => 'felipe@test.com'])
                        ->get()->pluck('email')->toArray()
        );
        $this->assertNotContains('deli@test.com',
            User::query()->applyFilters(null, ['search' => 'felipe@test.com'])
                    ->get()->pluck('email')->toArray()
        );
    }
}

