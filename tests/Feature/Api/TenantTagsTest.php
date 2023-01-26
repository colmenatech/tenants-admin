<?php

namespace Tests\Feature\Api;

use App\Models\Tag;
use App\Models\User;
use App\Models\Tenant;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TenantTagsTest extends TestCase
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
    public function it_gets_tenant_tags()
    {
        $tenant = Tenant::factory()->create();
        $tag = Tag::factory()->create();

        $tenant->tags()->attach($tag);

        $response = $this->getJson(route('api.tenants.tags.index', $tenant));

        $response->assertOk()->assertSee($tag->name);
    }

    /**
     * @test
     */
    public function it_can_attach_tags_to_tenant()
    {
        $tenant = Tenant::factory()->create();
        $tag = Tag::factory()->create();

        $response = $this->postJson(
            route('api.tenants.tags.store', [$tenant, $tag])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $tenant
                ->tags()
                ->where('tags.id', $tag->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_tags_from_tenant()
    {
        $tenant = Tenant::factory()->create();
        $tag = Tag::factory()->create();

        $response = $this->deleteJson(
            route('api.tenants.tags.store', [$tenant, $tag])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $tenant
                ->tags()
                ->where('tags.id', $tag->id)
                ->exists()
        );
    }
}
