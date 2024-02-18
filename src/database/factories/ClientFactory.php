<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Client;
use App\Models\Company;
use App\Models\CreatedBy;

class ClientFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Client::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'image_url' => $this->faker->word(),
            'created_by' => CreatedBy::factory(),
            'company_id' => Company::factory(),
            'street_address' => $this->faker->word(),
            'city' => $this->faker->city(),
            'state' => $this->faker->word(),
            'nationality' => $this->faker->word(),
        ];
    }
}
