<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Brand;
use App\Models\Client;
use App\Models\CreatedBy;

class BrandFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Brand::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'image_url' => $this->faker->word(),
            'industry_code' => $this->faker->word(),
            'sub_industry_code' => $this->faker->word(),
            'slug' => $this->faker->slug(),
            'created_by' => CreatedBy::factory(),
            'client_id' => Client::factory(),
        ];
    }
}
