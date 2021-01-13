<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */
//    public function test_roles_can_be_created()
//    {
//        // Run the DatabaseSeeder...
//        $this->seed();
//
//    }
public function test_there_is_a_user_in_db()
{
    if($this->assertDatabaseCount('users', 1)){
        $this->assertTrue(true);

}


}}
