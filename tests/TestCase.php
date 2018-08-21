<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use Faker\Factory as Faker;

abstract class TestCase extends BaseTestCase
{
    
    use CreatesApplication, DatabaseMigrations, DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();
        $this->faker = Faker::create();
    }

    public function tearDown()
    {
        $this->artisan('migrate:reset');
        parent::tearDown();
    }

}
