<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\TenantRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\TenantResource;
use App\Http\Resources\TenantCollection;

class TenantRequestTenantsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\TenantRequest $tenantRequest
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, TenantRequest $tenantRequest)
    {
        $this->authorize('view', $tenantRequest);

        $search = $request->get('search', '');

        $tenants = $tenantRequest
            ->tenants()
            ->search($search)
            ->latest()
            ->paginate();

        return new TenantCollection($tenants);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\TenantRequest $tenantRequest
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, TenantRequest $tenantRequest)
    {
        $this->authorize('create', Tenant::class);

        $validated = $request->validate([
            'status' => ['required', 'boolean'],
            'name' => ['required', 'unique:tenants,name', 'max:255', 'string'],
            'domain' => [
                'required',
                'unique:tenants,domain',
                'max:255',
                'string',
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
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $tenant = $tenantRequest->tenants()->create($validated);

        return new TenantResource($tenant);
    }
}
