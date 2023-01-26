<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\TenantResource;
use App\Http\Resources\TenantCollection;

class UserTenantsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, User $user)
    {
        $this->authorize('view', $user);

        $search = $request->get('search', '');

        $tenants = $user
            ->tenants()
            ->search($search)
            ->latest()
            ->paginate();

        return new TenantCollection($tenants);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
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
            'subscription_id' => ['required', 'exists:subscriptions,id'],
            'tenant_request_id' => ['nullable', 'exists:tenant_requests,id'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $tenant = $user->tenants()->create($validated);

        return new TenantResource($tenant);
    }
}
