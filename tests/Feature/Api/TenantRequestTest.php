<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\TenantRequest;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TenantRequestTest extends TestCase
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
    public function it_gets_tenant_requests_list()
    {
        $tenantRequests = TenantRequest::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.tenant-requests.index'));

        $response->assertOk()->assertSee($tenantRequests[0]->email);
    }

    /**
     * @test
     */
    public function it_stores_the_tenant_request()
    {
        $data = TenantRequest::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.tenant-requests.store'), $data);

        unset($data['extra_data']);

        $this->assertDatabaseHas('tenant_requests', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_tenant_request()
    {
        $tenantRequest = TenantRequest::factory()->create();

        $data = [
            'email' => $this->faker->unique->email,
            'phone' => $this->faker->unique->phoneNumber,
            'description' => $this->faker->text,
            'extra_data' => [],
        ];

        $response = $this->putJson(
            route('api.tenant-requests.update', $tenantRequest),
            $data
        );

        unset($data['extra_data']);

        $data['id'] = $tenantRequest->id;

        $this->assertDatabaseHas('tenant_requests', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_tenant_request()
    {
        $tenantRequest = TenantRequest::factory()->create();

        $response = $this->deleteJson(
            route('api.tenant-requests.destroy', $tenantRequest)
        );

        $this->assertSoftDeleted($tenantRequest);

        $response->assertNoContent();
    }
}
