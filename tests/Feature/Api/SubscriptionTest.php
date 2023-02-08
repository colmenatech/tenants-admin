<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Subscription;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubscriptionTest extends TestCase
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
    public function it_gets_subscriptions_list()
    {
        $subscriptions = Subscription::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.subscriptions.index'));

        $response->assertOk()->assertSee($subscriptions[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_subscription()
    {
        $data = Subscription::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.subscriptions.store'), $data);

        unset($data['unit_of_periodicity']);

        $this->assertDatabaseHas('subscriptions', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_subscription()
    {
        $subscription = Subscription::factory()->create();

        $data = [
            'name' => $this->faker->name(),
            'description' => $this->faker->text,
            'price' => $this->faker->randomNumber(1),
            'entities_threshold' => [],
            'features_gates' => [],
            'unit_of_periodicity' => 'hour',
        ];

        $response = $this->putJson(
            route('api.subscriptions.update', $subscription),
            $data
        );

        unset($data['unit_of_periodicity']);

        $data['id'] = $subscription->id;

        $this->assertDatabaseHas('subscriptions', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_subscription()
    {
        $subscription = Subscription::factory()->create();

        $response = $this->deleteJson(
            route('api.subscriptions.destroy', $subscription)
        );

        $this->assertSoftDeleted($subscription);

        $response->assertNoContent();
    }
}
