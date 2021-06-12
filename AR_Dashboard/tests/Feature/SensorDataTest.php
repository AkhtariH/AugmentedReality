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

class SensorDataTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp() :void
    {
        parent::setUp();
    } 

    /** @test  */
    public function sensor_data_table_has_expected_columns()
    {
        $this->assertTrue(Schema::hasColumns(
            'sensor_data', ['id', 'sensor_id', 'data', 'error', 'created_at', 'updated_at', 'threshold_value']), 1);
    }
}
