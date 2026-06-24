<div class="col-sm-6">
    <div class="mb20">
        <x-input-label class="heading-color" for="title" :value="__('Title')" />
        <x-text-input type="text" class="form-control" id="title" name="title" :value="old('title', $pettyCash->title ?? '')" required
            autocomplete="title" />

        <x-input-error :messages="$errors->get('title')" />
    </div>
</div>

<div class="col-sm-6">
    <div class="mb20">
        <x-input-label class="heading-color" for="transaction_type" :value="__('Transaction Type')" />
        <select id="transaction_type" name="transaction_type" class="form-control" required>
            <option value="" hidden>{{ __('Select transaction type') }}</option>
            <option value="credit_manual" @selected(old('transaction_type', $pettyCash->transaction_type ?? '') === 'credit_manual')>{{ __('Credit (Manual)') }}</option>
            <option value="debit_expense" @selected(old('transaction_type', $pettyCash->transaction_type ?? '') === 'debit_expense')>{{ __('Debit (Expense)') }}</option>
        </select>

        <x-input-error :messages="$errors->get('transaction_type')" />
    </div>
</div>

<div class="col-sm-6">
    <div class="mb20">
        <x-input-label class="heading-color" for="amount" :value="__('Amount')" />
        <x-text-input type="number" class="form-control" id="amount" name="amount" :value="old('amount', $pettyCash->amount ?? '')" step="0.01"
            min="0" required />

        <x-input-error :messages="$errors->get('amount')" />
    </div>
</div>

<div class="col-sm-6">
    <div class="mb20">
        <x-input-label class="heading-color" for="current_balance" :value="__('Current Balance')" />
        <x-text-input type="number" class="form-control" id="current_balance" name="current_balance" :value="old('current_balance', $pettyCash->current_balance ?? '')"
            step="0.01" min="0" required />

        <x-input-error :messages="$errors->get('current_balance')" />
    </div>
</div>

<div class="col-sm-6">
    <div class="mb20">
        <x-input-label class="heading-color" for="expense_id" :value="__('Expense Reference')" />
        <select id="expense_id" name="expense_id" class="form-control">
            <option value="">{{ __('None') }}</option>
            @foreach ($expenses ?? [] as $expense)
                <option value="{{ $expense->id }}" @selected(old('expense_id', $pettyCash->expense_id ?? '') == $expense->id)>
                    {{ $expense->transaction_reference ?? 'Expense #' . $expense->id }}</option>
            @endforeach
        </select>

        <x-input-error :messages="$errors->get('expense_id')" />
    </div>
</div>

<div class="col-sm-6">
    <div class="mb20">
        <x-input-label class="heading-color" for="date" :value="__('Date')" />
        <x-text-input type="date" class="form-control" id="date" name="date" :value="old('date', $pettyCash->date?->format('Y-m-d') ?? now()->format('Y-m-d'))" required />

        <x-input-error :messages="$errors->get('date')" />
    </div>
</div>

<div class="col-md-12">
    <div class="mb10">
        <x-input-label for="description" :value="__('Description')" />
        <textarea class="character-count" maxlength="400" cols="30" rows="4" name="description" id="description"
            placeholder="Description (Max 400 characters)">{{ old('description', $pettyCash->description ?? '') }}</textarea>
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
