<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

use App\Models\User;
use App\Models\Bridge;

class DatabaseTest extends TestCase
{
    use WithFaker;

    /** @test  */
    public function users_table_has_expected_columns()
    {
        $this->assertTrue(Schema::hasColumns(
            'users', ['id','name', 'email', 'email_verified_at', 'password', 'remember_token', 'created_at', 'updated_at', 'type', 'profile_image']), 1);
    }

    /** @test  */
    public function bridges_table_has_expected_columns()
    {
        $this->assertTrue(Schema::hasColumns(
            'bridges', ['id', 'name', 'adress', 'supervisor', 'bridgeHash', 'created_at', 'updated_at']), 1);
    }

    /** @test  */
    public function devices_table_has_expected_columns()
    {
        $this->assertTrue(Schema::hasColumns(
            'devices', ['id', 'ttn_dev_id', 'bridge_id']), 1);
    }

    /** @test  */
    public function sensors_table_has_expected_columns()
    {
        $this->assertTrue(Schema::hasColumns(
            'sensors', ['id', 'sensor_type_id', 'name', 'active', 'threshold_value', 'device_id', 'ttn_sensor_id']), 1);
    }

    /** @test  */
    public function sensor_data_table_has_expected_columns()
    {
        $this->assertTrue(Schema::hasColumns(
            'sensor_data', ['id', 'sensor_id', 'data', 'error', 'created_at', 'updated_at', 'threshold_value']), 1);
    }

    /** @test  */
    public function sensor_type_table_has_expected_columns()
    {
        $this->assertTrue(Schema::hasColumns(
            'sensor_type', ['id', 'type', 'data_attribute']), 1);
    }

    /** @test  */
    public function user_bridge_table_has_expected_columns()
    {
        $this->assertTrue(Schema::hasColumns(
            'user_bridge', ['id', 'user_id', 'bridge_id']), 1);
    }
}
