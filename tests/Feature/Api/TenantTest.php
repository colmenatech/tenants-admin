<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Tenant;

use App\Models\Subscription;
use App\Models\TenantRequest;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TenantTest extends TestCase
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
    public function it_gets_tenants_list()
    {
        $tenants = Tenant::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.tenants.index'));

        $response->assertOk()->assertSee($tenants[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_tenant()
    {
        $data = Tenant::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.tenants.store'), $data);

        $this->assertDatabaseHas('tenants', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_tenant()
    {
        $tenant = Tenant::factory()->create();

        $user = User::factory()->create();
        $subscription = Subscription::factory()->create();
        $tenantRequest = TenantRequest::factory()->create();

        $data = [
            'status' => $this->faker->boolean,
            'name' => $this->faker->unique->name(),
            'domain' => $this->faker->unique->domainName,
            'database' => $this->faker->unique->text(255),
            'system_settings' => [],
            'settings' => [],
            'user_id' => $user->id,
            'subscription_id' => $subscription->id,
            'tenant_request_id' => $tenantRequest->id,
        ];

        $response = $this->putJson(route('api.tenants.update', $tenant), $data);

        $data['id'] = $tenant->id;

        $this->assertDatabaseHas('tenants', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_tenant()
    {
        $tenant = Tenant::factory()->create();

        $response = $this->deleteJson(route('api.tenants.destroy', $tenant));

        $this->assertModelMissing($tenant);

        $response->assertNoContent();
    }
}
