@php $trainingType = $trainingType ?? null; @endphp

<div class="row">
    <div class="col-sm-6">
        <div class="mb20">
            <x-input-label class="heading-color" for="name" :value="__('Name')" />
            <x-text-input type="text" class="form-control" id="name" name="name" :value="old('name', $trainingType->name ?? '')" required />
            <x-input-error :messages="$errors->get('name')" />
        </div>
    </div>
</div>
