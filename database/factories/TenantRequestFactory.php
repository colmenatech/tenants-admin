<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\TenantRequest;
use Illuminate\Database\Eloquent\Factories\Factory;

class TenantRequestFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TenantRequest::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'email' => $this->faker->unique->email,
            'phone' => $this->faker->unique->phoneNumber,
            'description' => $this->faker->text,
        ];
    }
}
