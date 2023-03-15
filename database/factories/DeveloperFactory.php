<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class DeveloperFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => '1',
            'firstname' => $this->faker->firstName,
            'lastname' => $this->faker->lastName,
            'nid' => $this->faker->numberBetween(100000, 50000000),
            'birthday' => $this->faker->date('Y-m-d'),
            'email' => $this->faker->email,
        ];
    }
}
