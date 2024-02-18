<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientStoreRequest extends FormRequest
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
            'name' => ['required', 'string'],
            'image_url' => ['nullable', 'string'],
            'created_by' => ['required'],
            'company_id' => ['required', 'integer', 'exists:Companies,id'],
            'street_address' => ['nullable', 'string'],
            'city' => ['nullable', 'string'],
            'state' => ['nullable', 'string'],
            'nationality' => ['nullable', 'string'],
        ];
    }
}
