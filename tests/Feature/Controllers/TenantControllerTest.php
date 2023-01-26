<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Tenant;

use App\Models\Subscription;
use App\Models\TenantRequest;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TenantControllerTest extends TestCase
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

    protected function castToJson($json)
    {
        if (is_array($json)) {
            $json = addslashes(json_encode($json));
        } elseif (is_null($json) || is_null(json_decode($json))) {
            throw new \Exception(
                'A valid JSON string was not provided for casting.'
            );
        }

        return \DB::raw("CAST('{$json}' AS JSON)");
    }

    /**
     * @test
     */
    public function it_displays_index_view_with_tenants()
    {
        $tenants = Tenant::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('tenants.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.tenants.index')
            ->assertViewHas('tenants');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_tenant()
    {
        $response = $this->get(route('tenants.create'));

        $response->assertOk()->assertViewIs('app.tenants.create');
    }

    /**
     * @test
     */
    public function it_stores_the_tenant()
    {
        $data = Tenant::factory()
            ->make()
            ->toArray();

        $data['system_settings'] = json_encode($data['system_settings']);
        $data['settings'] = json_encode($data['settings']);

        $response = $this->post(route('tenants.store'), $data);

        $data['system_settings'] = $this->castToJson($data['system_settings']);
        $data['settings'] = $this->castToJson($data['settings']);

        $this->assertDatabaseHas('tenants', $data);

        $tenant = Tenant::latest('id')->first();

        $response->assertRedirect(route('tenants.edit', $tenant));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_tenant()
    {
        $tenant = Tenant::factory()->create();

        $response = $this->get(route('tenants.show', $tenant));

        $response
            ->assertOk()
            ->assertViewIs('app.tenants.show')
            ->assertViewHas('tenant');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_tenant()
    {
        $tenant = Tenant::factory()->create();

        $response = $this->get(route('tenants.edit', $tenant));

        $response
            ->assertOk()
            ->assertViewIs('app.tenants.edit')
            ->assertViewHas('tenant');
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

        $data['system_settings'] = json_encode($data['system_settings']);
        $data['settings'] = json_encode($data['settings']);

        $response = $this->put(route('tenants.update', $tenant), $data);

        $data['id'] = $tenant->id;

        $data['system_settings'] = $this->castToJson($data['system_settings']);
        $data['settings'] = $this->castToJson($data['settings']);

        $this->assertDatabaseHas('tenants', $data);

        $response->assertRedirect(route('tenants.edit', $tenant));
    }

    /**
     * @test
     */
    public function it_deletes_the_tenant()
    {
        $tenant = Tenant::factory()->create();

        $response = $this->delete(route('tenants.destroy', $tenant));

        $response->assertRedirect(route('tenants.index'));

        $this->assertModelMissing($tenant);
    }
}
