<?php

namespace App\Http\Controllers\Api;

use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\TenantResource;
use App\Http\Resources\TenantCollection;

class SubscriptionTenantsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Subscription $subscription
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Subscription $subscription)
    {
        $this->authorize('view', $subscription);

        $search = $request->get('search', '');

        $tenants = $subscription
            ->tenants()
            ->search($search)
            ->latest()
            ->paginate();

        return new TenantCollection($tenants);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Subscription $subscription
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Subscription $subscription)
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
            'tenant_request_id' => ['nullable', 'exists:tenant_requests,id'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $tenant = $subscription->tenants()->create($validated);

        return new TenantResource($tenant);
    }
}
