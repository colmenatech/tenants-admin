<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Tenant;
use App\Models\TenantRequest;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TenantRequestTenantsTest extends TestCase
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
    public function it_gets_tenant_request_tenants()
    {
        $tenantRequest = TenantRequest::factory()->create();
        $tenants = Tenant::factory()
            ->count(2)
            ->create([
                'tenant_request_id' => $tenantRequest->id,
            ]);

        $response = $this->getJson(
            route('api.tenant-requests.tenants.index', $tenantRequest)
        );

        $response->assertOk()->assertSee($tenants[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_tenant_request_tenants()
    {
        $tenantRequest = TenantRequest::factory()->create();
        $data = Tenant::factory()
            ->make([
                'tenant_request_id' => $tenantRequest->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.tenant-requests.tenants.store', $tenantRequest),
            $data
        );

        $this->assertDatabaseHas('tenants', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $tenant = Tenant::latest('id')->first();

        $this->assertEquals($tenantRequest->id, $tenant->tenant_request_id);
    }
}
