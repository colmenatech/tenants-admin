<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\TenantRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\TenantRequestResource;
use App\Http\Resources\TenantRequestCollection;
use App\Http\Requests\TenantRequestStoreRequest;
use App\Http\Requests\TenantRequestUpdateRequest;

class TenantRequestController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', TenantRequest::class);

        $search = $request->get('search', '');

        $tenantRequests = TenantRequest::search($search)
            ->latest()
            ->paginate();

        return new TenantRequestCollection($tenantRequests);
    }

    /**
     * @param \App\Http\Requests\TenantRequestStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(TenantRequestStoreRequest $request)
    {
        $this->authorize('create', TenantRequest::class);

        $validated = $request->validated();
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $tenantRequest = TenantRequest::create($validated);

        return new TenantRequestResource($tenantRequest);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\TenantRequest $tenantRequest
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, TenantRequest $tenantRequest)
    {
        $this->authorize('view', $tenantRequest);

        return new TenantRequestResource($tenantRequest);
    }

    /**
     * @param \App\Http\Requests\TenantRequestUpdateRequest $request
     * @param \App\Models\TenantRequest $tenantRequest
     * @return \Illuminate\Http\Response
     */
    public function update(
        TenantRequestUpdateRequest $request,
        TenantRequest $tenantRequest
    ) {
        $this->authorize('update', $tenantRequest);

        $validated = $request->validated();

        if ($request->hasFile('image')) {
            if ($tenantRequest->image) {
                Storage::delete($tenantRequest->image);
            }

            $validated['image'] = $request->file('image')->store('public');
        }

        $tenantRequest->update($validated);

        return new TenantRequestResource($tenantRequest);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\TenantRequest $tenantRequest
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, TenantRequest $tenantRequest)
    {
        $this->authorize('delete', $tenantRequest);

        if ($tenantRequest->image) {
            Storage::delete($tenantRequest->image);
        }

        $tenantRequest->delete();

        return response()->noContent();
    }
}
