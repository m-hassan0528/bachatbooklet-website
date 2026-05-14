<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UniversalCodeRedeemRequest extends FormRequest
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
            'code' => ['required', 'string', 'size:10'],
            'brand_id' => ['required', 'exists:brands,id'],
            'customer_info' => ['nullable', 'array'],
            'customer_info.name' => ['nullable', 'string', 'max:255'],
            'customer_info.email' => ['nullable', 'email', 'max:255'],
            'customer_info.phone' => ['nullable', 'string', 'max:20'],
            'notes' => ['nullable', 'string', 'max:500'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'code' => 'code',
            'brand_id' => 'brand',
            'customer_info.name' => 'customer name',
            'customer_info.email' => 'customer email',
            'customer_info.phone' => 'customer phone',
            'notes' => 'notes',
        ];
    }
}
