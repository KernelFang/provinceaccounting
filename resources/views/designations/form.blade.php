@php($item = $item ?? null)

<div class="row">
    <div class="col-sm-12">
        <div class="mb20">
            <x-input-label for="title" :value="__('Title')" />
            <x-text-input id="title" name="title" class="form-control" value="{{ old('title', $item->title ?? '') }}"
                required />
            <x-input-error :messages="$errors->get('title')" />
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
