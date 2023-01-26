<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class TenantRequestUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => [
                'required',
                Rule::unique('tenant_requests', 'email')->ignore(
                    $this->tenantRequest
                ),
                'email',
            ],
            'phone' => [
                'required',
                Rule::unique('tenant_requests', 'phone')->ignore(
                    $this->tenantRequest
                ),
                'max:255',
                'string',
            ],
            'description' => ['required', 'string'],
            'image' => ['nullable', 'image', 'max:2048'],
        ];
    }
}
