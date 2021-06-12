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

class SensorsTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp() :void
    {
        parent::setUp();
    } 

    /** @test  */
    public function sensors_table_has_expected_columns()
    {
        $this->assertTrue(Schema::hasColumns(
            'sensors', ['id', 'sensor_type_id', 'name', 'active', 'threshold_value', 'device_id', 'ttn_sensor_id']), 1);
    }
}
