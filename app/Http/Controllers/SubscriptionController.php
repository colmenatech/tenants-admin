<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;
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
            ->paginate(5)
            ->withQueryString();

        return view(
            'app.subscriptions.index',
            compact('subscriptions', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Subscription::class);

        return view('app.subscriptions.create');
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

        return redirect()
            ->route('subscriptions.edit', $subscription)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Subscription $subscription
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Subscription $subscription)
    {
        $this->authorize('view', $subscription);

        return view('app.subscriptions.show', compact('subscription'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Subscription $subscription
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Subscription $subscription)
    {
        $this->authorize('update', $subscription);

        return view('app.subscriptions.edit', compact('subscription'));
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

        return redirect()
            ->route('subscriptions.edit', $subscription)
            ->withSuccess(__('crud.common.saved'));
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

        return redirect()
            ->route('subscriptions.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
