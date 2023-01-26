<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Tenant;
use App\Models\Subscription;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubscriptionTenantsTest extends TestCase
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
    public function it_gets_subscription_tenants()
    {
        $subscription = Subscription::factory()->create();
        $tenants = Tenant::factory()
            ->count(2)
            ->create([
                'subscription_id' => $subscription->id,
            ]);

        $response = $this->getJson(
            route('api.subscriptions.tenants.index', $subscription)
        );

        $response->assertOk()->assertSee($tenants[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_subscription_tenants()
    {
        $subscription = Subscription::factory()->create();
        $data = Tenant::factory()
            ->make([
                'subscription_id' => $subscription->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.subscriptions.tenants.store', $subscription),
            $data
        );

        $this->assertDatabaseHas('tenants', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $tenant = Tenant::latest('id')->first();

        $this->assertEquals($subscription->id, $tenant->subscription_id);
    }
}
