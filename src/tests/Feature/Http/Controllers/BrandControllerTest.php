<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Brand;
use App\Models\Client;
use App\Models\CreatedBy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\BrandController
 */
final class BrandControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $brands = Brand::factory()->count(3)->create();

        $response = $this->get(route('brand.index'));
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\BrandController::class,
            'store',
            \App\Http\Requests\BrandStoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $name = $this->faker->name();
        $industry_code = $this->faker->word();
        $sub_industry_code = $this->faker->word();
        $slug = $this->faker->slug();
        $created_by = CreatedBy::factory()->create();
        $client = Client::factory()->create();

        $response = $this->post(route('brand.store'), [
            'name' => $name,
            'industry_code' => $industry_code,
            'sub_industry_code' => $sub_industry_code,
            'slug' => $slug,
            'created_by' => $created_by->id,
            'client_id' => $client->id,
        ]);

        $brands = Brand::query()
            ->where('name', $name)
            ->where('industry_code', $industry_code)
            ->where('sub_industry_code', $sub_industry_code)
            ->where('slug', $slug)
            ->where('created_by', $created_by->id)
            ->where('client_id', $client->id)
            ->get();
        $this->assertCount(1, $brands);
        $brand = $brands->first();
    }
}
