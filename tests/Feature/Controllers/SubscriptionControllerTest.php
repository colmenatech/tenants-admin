<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Subscription;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubscriptionControllerTest extends TestCase
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
    public function it_displays_index_view_with_subscriptions()
    {
        $subscriptions = Subscription::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('subscriptions.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.subscriptions.index')
            ->assertViewHas('subscriptions');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_subscription()
    {
        $response = $this->get(route('subscriptions.create'));

        $response->assertOk()->assertViewIs('app.subscriptions.create');
    }

    /**
     * @test
     */
    public function it_stores_the_subscription()
    {
        $data = Subscription::factory()
            ->make()
            ->toArray();

        $data['entities_threshold'] = json_encode($data['entities_threshold']);
        $data['features_gates'] = json_encode($data['features_gates']);

        $response = $this->post(route('subscriptions.store'), $data);

        $data['entities_threshold'] = $this->castToJson(
            $data['entities_threshold']
        );
        $data['features_gates'] = $this->castToJson($data['features_gates']);

        $this->assertDatabaseHas('subscriptions', $data);

        $subscription = Subscription::latest('id')->first();

        $response->assertRedirect(route('subscriptions.edit', $subscription));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_subscription()
    {
        $subscription = Subscription::factory()->create();

        $response = $this->get(route('subscriptions.show', $subscription));

        $response
            ->assertOk()
            ->assertViewIs('app.subscriptions.show')
            ->assertViewHas('subscription');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_subscription()
    {
        $subscription = Subscription::factory()->create();

        $response = $this->get(route('subscriptions.edit', $subscription));

        $response
            ->assertOk()
            ->assertViewIs('app.subscriptions.edit')
            ->assertViewHas('subscription');
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
            'prince' => $this->faker->randomNumber(1),
            'entities_threshold' => [],
            'features_gates' => [],
        ];

        $data['entities_threshold'] = json_encode($data['entities_threshold']);
        $data['features_gates'] = json_encode($data['features_gates']);

        $response = $this->put(
            route('subscriptions.update', $subscription),
            $data
        );

        $data['id'] = $subscription->id;

        $data['entities_threshold'] = $this->castToJson(
            $data['entities_threshold']
        );
        $data['features_gates'] = $this->castToJson($data['features_gates']);

        $this->assertDatabaseHas('subscriptions', $data);

        $response->assertRedirect(route('subscriptions.edit', $subscription));
    }

    /**
     * @test
     */
    public function it_deletes_the_subscription()
    {
        $subscription = Subscription::factory()->create();

        $response = $this->delete(
            route('subscriptions.destroy', $subscription)
        );

        $response->assertRedirect(route('subscriptions.index'));

        $this->assertSoftDeleted($subscription);
    }
}
