<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Schema;
use Factory;

use App\Models\User;
use App\Models\Bridge;
use App\Models\UserBridge;

class BridgesTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp() :void
    {
        parent::setUp();
    } 

    /** @test  */
    public function bridges_table_has_expected_columns()
    {
        $this->assertTrue(Schema::hasColumns(
            'bridges', ['id', 'name', 'adress', 'supervisor', 'bridgeHash', 'created_at', 'updated_at']), 1);
    }
}
