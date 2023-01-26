<?php

namespace Database\Factories;

use App\Models\Tenant;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class TenantFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Tenant::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'status' => $this->faker->boolean,
            'name' => $this->faker->unique->name(),
            'domain' => $this->faker->unique->domainName,
            'database' => $this->faker->unique->text(255),
            'system_settings' => [],
            'settings' => [],
            'user_id' => \App\Models\User::factory(),
            'subscription_id' => \App\Models\Subscription::factory(),
            'tenant_request_id' => \App\Models\TenantRequest::factory(),
        ];
    }
}
