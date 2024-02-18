<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Client;
use App\Models\ClientContact;

class ClientContactFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ClientContact::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'client_id' => Client::factory(),
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'email' => $this->faker->safeEmail(),
            'phone_number' => $this->faker->phoneNumber(),
            'is_primary' => $this->faker->boolean(),
        ];
    }
}
