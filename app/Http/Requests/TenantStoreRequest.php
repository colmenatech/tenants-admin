<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class TenantStoreRequest extends FormRequest
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
            'status' => ['required', 'boolean'],
            'name' => ['required', 'unique:tenants,name', 'max:255', 'string'],
            'domain' => [
                'required',
                'unique:tenants,domain',
                'max:255',
                'string',
                'regex:/^[A-Za-z0-9\.]*[.](' . config('cms.domain') . ')$/',
            ],
            'database' => [
                'required',
                'unique:tenants,database',
                'max:255',
                'string',
            ],
            'image' => ['nullable', 'image', 'max:2048'],
            'system_settings' => ['nullable', 'json'],
            'settings' => ['nullable', 'json'],
            'user_id' => ['nullable', 'exists:users,id'],
            'subscription_id' => ['required', 'exists:subscriptions,id'],
            'tenant_request_id' => ['nullable', 'exists:tenant_requests,id'],
        ];
    }
}
