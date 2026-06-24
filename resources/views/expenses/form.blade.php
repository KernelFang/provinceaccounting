<div class="col-sm-6">
    <div class="mb20">
        <x-input-label class="heading-color" for="title" :value="__('Title')" />
        <x-text-input type="text" class="form-control" id="title" name="title" :value="old('title', $expense->title ?? '')" required
            autocomplete="title" />

        <x-input-error :messages="$errors->get('title')" />
    </div>
</div>

<div class="col-sm-6">
    <div class="mb20">
        <div class="form-style1">
            <x-input-label class="heading-color" for="category" :value="__('Category')" />
            <div class="bootselect-multiselect">
                <select class="selectpicker" data-live-search="true" id="expense_type_id" name="expense_type_id"
                    required>
                    <option value="" disabled
                        {{ is_null(old('expense_type_id', $expense->expense_type_id ?? null)) ? 'selected' : '' }}>
                        Select</option>
                    @foreach ($categories ?? [] as $cat)
                        <option value="{{ $cat->id }}" @selected((int) old('expense_type_id', $expense->expense_type_id ?? null) === $cat->id)>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <x-input-error :messages="$errors->get('expense_type_id')" />
        </div>
    </div>
</div>

<div class="col-sm-6">
    <div class="mb20">
        <div class="form-style1">
            <x-input-label class="heading-color" for="payment_status" :value="__('Payment Status')" />
            <div class="bootselect-multiselect">
                <select class="selectpicker" data-live-search="false" id="payment_status" name="payment_status"
                    required>
                    <option value="" disabled
                        {{ is_null(old('payment_status', $expense->payment_status ?? null)) ? 'selected' : '' }}>Select
                    </option>
                    <option value="paid" @selected(old('payment_status', $expense->payment_status ?? null) === 'paid')>Paid</option>
                    <option value="unpaid" @selected(old('payment_status', $expense->payment_status ?? null) === 'unpaid')>Unpaid</option>
                    <option value="petty_cash" @selected(old('payment_status', $expense->payment_status ?? null) === 'petty_cash')>Petty Cash</option>
                </select>
            </div>

            <x-input-error :messages="$errors->get('payment_status')" />
        </div>
    </div>
</div>

<div class="col-sm-6">
    <div class="mb20">
        <x-input-label class="heading-color" for="amount" :value="__('Amount')" />
        <x-text-input type="number" class="form-control" id="amount" name="amount" :value="old('amount', $expense->amount ?? '')" step="0.01"
            min="0" required />

        <x-input-error :messages="$errors->get('amount')" />
    </div>
</div>

<div class="col-sm-6">
    <div class="mb20">
        <x-input-label class="heading-color" for="date" :value="__('Expense Date')" />
        <x-text-input type="date" class="form-control" id="date" name="date" :value="old('date', $expense->date?->format('Y-m-d') ?? now()->format('Y-m-d'))" required />

        <x-input-error :messages="$errors->get('date')" />
    </div>
</div>

<div class="col-md-12">
    <div class="mb10">
        <x-input-label for="description" :value="__('Description')" />
        <textarea class="character-count" maxlength="400" cols="30" rows="4" name="description" id="description"
            placeholder="Description (Max 400 characters)">{{ old('description', $expense->description ?? '') }}</textarea>
        <div class="form-feedback d-flex justify-content-between">
            <div class="form-error d-block text-start">
                <x-input-error :messages="$errors->get('description')" />
            </div>
            <div class="form-helper-text small text-muted d-block mt-2 text-end">
                <span class="remaining-characters">400</span>
                <span class="remaining-characters-text">characters remaining</span>
            </div>
        </div>
    </div>
</div>
