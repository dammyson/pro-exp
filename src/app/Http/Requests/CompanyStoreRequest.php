<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'address' => ['nullable', 'string'],
            'logo' => ['nullable', 'string'],
            'company_rc' => ['nullable', 'string'],
            'email' => ['nullable', 'email'],
            'phone_number' => ['nullable', 'string'],
            'website' => ['nullable', 'string'],
            'city' => ['nullable', 'string'],
            'state' => ['nullable', 'string'],
            'country' => ['nullable', 'string'],   
        ];
    }
}
