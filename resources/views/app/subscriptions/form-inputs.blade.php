@php $editing = isset($subscription) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.text
            name="name"
            label="Name"
            :value="old('name', ($editing ? $subscription->name : ''))"
            maxlength="255"
            placeholder="Name"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.textarea
            name="description"
            label="Description"
            maxlength="255"
            required
            >{{ old('description', ($editing ? $subscription->description : ''))
            }}</x-inputs.textarea
        >
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="price"
            label="Price"
            :value="old('price', ($editing ? $subscription->price : ''))"
            max="255"
            step="0.01"
            placeholder="Price"
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.textarea
            name="entities_threshold"
            label="Entities Threshold"
            maxlength="255"
            >{{ old('entities_threshold', ($editing ?
            json_encode($subscription->entities_threshold) : ''))
            }}</x-inputs.textarea
        >
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.textarea
            name="features_gates"
            label="Features Gates"
            maxlength="255"
            >{{ old('features_gates', ($editing ?
            json_encode($subscription->features_gates) : ''))
            }}</x-inputs.textarea
        >
    </x-inputs.group>
</div>
