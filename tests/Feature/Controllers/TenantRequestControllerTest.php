<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\TenantRequest;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TenantRequestControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(
            User::factory()->create(['email' => 'admin@admin.com'])
        );

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_displays_index_view_with_tenant_requests()
    {
        $tenantRequests = TenantRequest::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('tenant-requests.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.tenant_requests.index')
            ->assertViewHas('tenantRequests');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_tenant_request()
    {
        $response = $this->get(route('tenant-requests.create'));

        $response->assertOk()->assertViewIs('app.tenant_requests.create');
    }

    /**
     * @test
     */
    public function it_stores_the_tenant_request()
    {
        $data = TenantRequest::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('tenant-requests.store'), $data);

        $this->assertDatabaseHas('tenant_requests', $data);

        $tenantRequest = TenantRequest::latest('id')->first();

        $response->assertRedirect(
            route('tenant-requests.edit', $tenantRequest)
        );
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_tenant_request()
    {
        $tenantRequest = TenantRequest::factory()->create();

        $response = $this->get(route('tenant-requests.show', $tenantRequest));

        $response
            ->assertOk()
            ->assertViewIs('app.tenant_requests.show')
            ->assertViewHas('tenantRequest');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_tenant_request()
    {
        $tenantRequest = TenantRequest::factory()->create();

        $response = $this->get(route('tenant-requests.edit', $tenantRequest));

        $response
            ->assertOk()
            ->assertViewIs('app.tenant_requests.edit')
            ->assertViewHas('tenantRequest');
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
        ];

        $response = $this->put(
            route('tenant-requests.update', $tenantRequest),
            $data
        );

        $data['id'] = $tenantRequest->id;

        $this->assertDatabaseHas('tenant_requests', $data);

        $response->assertRedirect(
            route('tenant-requests.edit', $tenantRequest)
        );
    }

    /**
     * @test
     */
    public function it_deletes_the_tenant_request()
    {
        $tenantRequest = TenantRequest::factory()->create();

        $response = $this->delete(
            route('tenant-requests.destroy', $tenantRequest)
        );

        $response->assertRedirect(route('tenant-requests.index'));

        $this->assertSoftDeleted($tenantRequest);
    }
}
