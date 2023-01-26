<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\Subscription;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubscriptionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Subscription::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'description' => $this->faker->text,
            'prince' => $this->faker->randomNumber(1),
            'entities_threshold' => [],
            'features_gates' => [],
        ];
    }
}
