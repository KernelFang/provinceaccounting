@php($item = $item ?? null)

<div class="row">
    <div class="col-sm-12">
        <div class="mb20">
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" class="form-control" value="{{ old('name', $item->name ?? '') }}"
                required />
            <x-input-error :messages="$errors->get('name')" />
        </div>
    </div>

    <div class="col-sm-12">
        <div class="mb20">
            <x-input-label for="remarks" :value="__('Remarks')" />
            <textarea id="remarks" name="remarks" class="form-control">{{ old('remarks', $item->remarks ?? '') }}</textarea>
            <x-input-error :messages="$errors->get('remarks')" />
        </div>
    </div>
</div>
