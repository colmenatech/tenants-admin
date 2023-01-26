<?php
namespace App\Http\Controllers\Api;

use App\Models\Tag;
use App\Models\Tenant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\TenantCollection;

class TagTenantsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Tag $tag
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Tag $tag)
    {
        $this->authorize('view', $tag);

        $search = $request->get('search', '');

        $tenants = $tag
            ->tenants()
            ->search($search)
            ->latest()
            ->paginate();

        return new TenantCollection($tenants);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Tag $tag
     * @param \App\Models\Tenant $tenant
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Tag $tag, Tenant $tenant)
    {
        $this->authorize('update', $tag);

        $tag->tenants()->syncWithoutDetaching([$tenant->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Tag $tag
     * @param \App\Models\Tenant $tenant
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Tag $tag, Tenant $tenant)
    {
        $this->authorize('update', $tag);

        $tag->tenants()->detach($tenant);

        return response()->noContent();
    }
}
