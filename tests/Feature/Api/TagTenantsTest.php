<?php

namespace Tests\Feature\Api;

use App\Models\Tag;
use App\Models\User;
use App\Models\Tenant;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TagTenantsTest extends TestCase
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
    public function it_gets_tag_tenants()
    {
        $tag = Tag::factory()->create();
        $tenant = Tenant::factory()->create();

        $tag->tenants()->attach($tenant);

        $response = $this->getJson(route('api.tags.tenants.index', $tag));

        $response->assertOk()->assertSee($tenant->name);
    }

    /**
     * @test
     */
    public function it_can_attach_tenants_to_tag()
    {
        $tag = Tag::factory()->create();
        $tenant = Tenant::factory()->create();

        $response = $this->postJson(
            route('api.tags.tenants.store', [$tag, $tenant])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $tag
                ->tenants()
                ->where('tenants.id', $tenant->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_tenants_from_tag()
    {
        $tag = Tag::factory()->create();
        $tenant = Tenant::factory()->create();

        $response = $this->deleteJson(
            route('api.tags.tenants.store', [$tag, $tenant])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $tag
                ->tenants()
                ->where('tenants.id', $tenant->id)
                ->exists()
        );
    }
}
