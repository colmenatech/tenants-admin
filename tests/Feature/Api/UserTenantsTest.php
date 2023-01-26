<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Tenant;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTenantsTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create(['email' => 'admin@admin.com']);

        Sanctum::actingAs($user, [], 'web');

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_gets_user_tenants()
    {
        $user = User::factory()->create();
        $tenants = Tenant::factory()
            ->count(2)
            ->create([
                'user_id' => $user->id,
            ]);

        $response = $this->getJson(route('api.users.tenants.index', $user));

        $response->assertOk()->assertSee($tenants[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_user_tenants()
    {
        $user = User::factory()->create();
        $data = Tenant::factory()
            ->make([
                'user_id' => $user->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.users.tenants.store', $user),
            $data
        );

        $this->assertDatabaseHas('tenants', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $tenant = Tenant::latest('id')->first();

        $this->assertEquals($user->id, $tenant->user_id);
    }
}
