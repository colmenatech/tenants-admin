<?php
namespace App\Http\Controllers\Api;

use App\Models\Tag;
use App\Models\Tenant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\TagCollection;

class TenantTagsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Tenant $tenant
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Tenant $tenant)
    {
        $this->authorize('view', $tenant);

        $search = $request->get('search', '');

        $tags = $tenant
            ->tags()
            ->search($search)
            ->latest()
            ->paginate();

        return new TagCollection($tags);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Tenant $tenant
     * @param \App\Models\Tag $tag
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Tenant $tenant, Tag $tag)
    {
        $this->authorize('update', $tenant);

        $tenant->tags()->syncWithoutDetaching([$tag->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Tenant $tenant
     * @param \App\Models\Tag $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Tenant $tenant, Tag $tag)
    {
        $this->authorize('update', $tenant);

        $tenant->tags()->detach($tag);

        return response()->noContent();
    }
}
