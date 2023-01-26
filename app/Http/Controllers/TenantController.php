<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Tenant;
use Illuminate\Http\Request;
use App\Models\Subscription;
use App\Models\TenantRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\TenantStoreRequest;
use App\Http\Requests\TenantUpdateRequest;

class TenantController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Tenant::class);

        $search = $request->get('search', '');

        $tenants = Tenant::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.tenants.index', compact('tenants', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Tenant::class);

        $users = User::pluck('name', 'id');
        $subscriptions = Subscription::pluck('name', 'id');
        $tenantRequests = TenantRequest::pluck('email', 'id');

        return view(
            'app.tenants.create',
            compact('users', 'subscriptions', 'tenantRequests')
        );
    }

    /**
     * @param \App\Http\Requests\TenantStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(TenantStoreRequest $request)
    {
        $this->authorize('create', Tenant::class);

        $validated = $request->validated();
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $validated['system_settings'] = json_decode(
            $validated['system_settings'],
            true
        );

        $validated['settings'] = json_decode($validated['settings'], true);

        $tenant = Tenant::create($validated);

        return redirect()
            ->route('tenants.edit', $tenant)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Tenant $tenant
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Tenant $tenant)
    {
        $this->authorize('view', $tenant);

        return view('app.tenants.show', compact('tenant'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Tenant $tenant
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Tenant $tenant)
    {
        $this->authorize('update', $tenant);

        $users = User::pluck('name', 'id');
        $subscriptions = Subscription::pluck('name', 'id');
        $tenantRequests = TenantRequest::pluck('email', 'id');

        return view(
            'app.tenants.edit',
            compact('tenant', 'users', 'subscriptions', 'tenantRequests')
        );
    }

    /**
     * @param \App\Http\Requests\TenantUpdateRequest $request
     * @param \App\Models\Tenant $tenant
     * @return \Illuminate\Http\Response
     */
    public function update(TenantUpdateRequest $request, Tenant $tenant)
    {
        $this->authorize('update', $tenant);

        $validated = $request->validated();
        if ($request->hasFile('image')) {
            if ($tenant->image) {
                Storage::delete($tenant->image);
            }

            $validated['image'] = $request->file('image')->store('public');
        }

        $validated['system_settings'] = json_decode(
            $validated['system_settings'],
            true
        );

        $validated['settings'] = json_decode($validated['settings'], true);

        $tenant->update($validated);

        return redirect()
            ->route('tenants.edit', $tenant)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Tenant $tenant
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Tenant $tenant)
    {
        $this->authorize('delete', $tenant);

        if ($tenant->image) {
            Storage::delete($tenant->image);
        }

        $tenant->delete();

        return redirect()
            ->route('tenants.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
