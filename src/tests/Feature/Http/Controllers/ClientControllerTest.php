<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Client;
use App\Models\Company;
use App\Models\CreatedBy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ClientController
 */
final class ClientControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $clients = Client::factory()->count(3)->create();

        $response = $this->get(route('client.index'));
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ClientController::class,
            'store',
            \App\Http\Requests\ClientStoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $name = $this->faker->name();
        $created_by = CreatedBy::factory()->create();
        $company = Company::factory()->create();

        $response = $this->post(route('client.store'), [
            'name' => $name,
            'created_by' => $created_by->id,
            'company_id' => $company->id,
        ]);

        $clients = Client::query()
            ->where('name', $name)
            ->where('created_by', $created_by->id)
            ->where('company_id', $company->id)
            ->get();
        $this->assertCount(1, $clients);
        $client = $clients->first();
    }
}
