<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\CompanyController
 */
final class CompanyControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $companies = Company::factory()->count(3)->create();

        $response = $this->get(route('company.index'));
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CompanyController::class,
            'store',
            \App\Http\Requests\CompanyStoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $name = $this->faker->name();

        $response = $this->post(route('company.store'), [
            'name' => $name,
        ]);

        $companies = Company::query()
            ->where('name', $name)
            ->get();
        $this->assertCount(1, $companies);
        $company = $companies->first();
    }
}
