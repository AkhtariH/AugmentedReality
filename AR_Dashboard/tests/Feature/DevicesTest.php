<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Schema;
use Factory;

use App\Models\Device;
use App\Models\Bridge;
use App\Models\Sensor;

class DevicesTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp() :void
    {
        parent::setUp();
        
        $this->bridge = Bridge::factory()->create(); 
        $this->device = Device::create(['ttn_dev_id' => 'HA2JF', 'bridge_id' => $this->bridge->id]);
    } 

    /** @test  */
    public function devices_table_has_expected_columns()
    {
        $this->assertTrue(Schema::hasColumns(
            'devices', ['id', 'ttn_dev_id', 'bridge_id']), 1);
    }

    /** @test  */
    public function a_device_has_one_bridge() {
        $this->assertEquals(1, $this->bridge->device->count());
    }
}
