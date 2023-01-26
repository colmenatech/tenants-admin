<?php

namespace App\Http\Controllers\Api;

use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SubscriptionResource;
use App\Http\Resources\SubscriptionCollection;
use App\Http\Requests\SubscriptionStoreRequest;
use App\Http\Requests\SubscriptionUpdateRequest;

class SubscriptionController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Subscription::class);

        $search = $request->get('search', '');

        $subscriptions = Subscription::search($search)
            ->latest()
            ->paginate();

        return new SubscriptionCollection($subscriptions);
    }

    /**
     * @param \App\Http\Requests\SubscriptionStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(SubscriptionStoreRequest $request)
    {
        $this->authorize('create', Subscription::class);

        $validated = $request->validated();
        $validated['entities_threshold'] = json_decode(
            $validated['entities_threshold'],
            true
        );

        $validated['features_gates'] = json_decode(
            $validated['features_gates'],
            true
        );

        $subscription = Subscription::create($validated);

        return new SubscriptionResource($subscription);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Subscription $subscription
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Subscription $subscription)
    {
        $this->authorize('view', $subscription);

        return new SubscriptionResource($subscription);
    }

    /**
     * @param \App\Http\Requests\SubscriptionUpdateRequest $request
     * @param \App\Models\Subscription $subscription
     * @return \Illuminate\Http\Response
     */
    public function update(
        SubscriptionUpdateRequest $request,
        Subscription $subscription
    ) {
        $this->authorize('update', $subscription);

        $validated = $request->validated();

        $validated['entities_threshold'] = json_decode(
            $validated['entities_threshold'],
            true
        );

        $validated['features_gates'] = json_decode(
            $validated['features_gates'],
            true
        );

        $subscription->update($validated);

        return new SubscriptionResource($subscription);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Subscription $subscription
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Subscription $subscription)
    {
        $this->authorize('delete', $subscription);

        $subscription->delete();

        return response()->noContent();
    }
}
