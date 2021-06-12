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

class UsersTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp() :void
    {
        parent::setUp();
        
        $this->user = User::factory()->create();
        $this->bridge = Bridge::factory()->create(); 
        $this->user_bridge = UserBridge::create(['user_id' => $this->user->id, 'bridge_id' => $this->bridge->id]);
    } 

    /** @test  */
    public function users_table_has_expected_columns()
    {
        $this->assertTrue(Schema::hasColumns(
            'users', ['id','name', 'email', 'email_verified_at', 'password', 'remember_token', 'created_at', 'updated_at', 'type', 'profile_image']), 1);
    }

    /** @test  */
    public function a_user_has_many_bridges() {
        $this->assertEquals(1, $this->user->user_bridge->count());
    }
}
