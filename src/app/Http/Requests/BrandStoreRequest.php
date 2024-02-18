<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BrandStoreRequest extends FormRequest
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
            'image_url' => ['nullable', 'string'],
            'industry_code' => ['nullable', 'string'],
            'sub_industry_code' => ['nullable', 'string'],
            'slug' => ['nullable', 'string'],
            'client_id' => ['required', 'integer', 'exists:Clients,id'],
        ];
    }
}
