<x-app-layout>
    <x-slot name="title">{{ __('Expense') . ' ' . __('Details') }}</x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Expense') . ' ' . __('Details') }}
        </h2>
    </x-slot>

    <div class="row">
        <div class="container-sm container-lg">
            <div class="bg-white shadow rounded-3 p-4 p-sm-8">
                <div class="w-100">
                    <!-- Expense Details -->
                    <section class="pt0 pb90 pb30-md">
                        <div class="container">
                            <div class="row wrap wow fadeInUp">
                                <div class="col-lg-8">
                                    <div class="column" id="printable-area">
                                        <div class="price-widget pt25 bdrs8">
                                            <h4><i
                                                    class="fa fa-file-invoice-dollar text-thm2 pe-2 vam align-baseline"></i>{{ __('Expense Details') }}
                                            </h4>
                                            <div class="category-list mt20">

                                                <p class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                    <span class="text">
                                                        <i class="fa fa-tag text-thm2 pe-2 vam"></i> Title
                                                    </span>
                                                    <span>{{ $expense->title }}</span>
                                                </p>

                                                <p class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                    <span class="text">
                                                        <i class="fa fa-tags text-thm2 pe-2 vam"></i> Category
                                                    </span>
                                                    <span>{{ $expense->expenseType->name ?? ($expense->category ?? 'N/A') }}</span>
                                                </p>

                                                <p class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                    <span class="text">
                                                        <i class="fa fa-building text-thm2 pe-2 vam"></i> Project
                                                    </span>
                                                    <span>{{ $expense->project->name ?? 'N/A' }}</span>
                                                </p>

                                                <p class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                    <span class="text">
                                                        <i class="fa fa-money-bill-wave text-thm2 pe-2 vam"></i> Amount
                                                        (TK.)
                                                    </span>
                                                    <span>{{ rtrim(rtrim(number_format($expense->amount, 2), '0'), '.') }}</span>
                                                </p>

                                                <p class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                    <span class="text">
                                                        <i class="fa fa-calendar-alt text-thm2 pe-2 vam"></i> Expense
                                                        Date
                                                    </span>
                                                    <span>{{ $expense->date ? $expense->date->format('d M Y') : 'N/A' }}</span>
                                                </p>

                                                <p class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                    <span class="text">
                                                        <i class="fa fa-circle-check text-thm2 pe-2 vam"></i> Status
                                                    </span>
                                                    @if ($expense->payment_status === 'paid')
                                                        <span class="badge bg-success">Paid</span>
                                                    @elseif($expense->payment_status === 'petty_cash')
                                                        <span class="badge bg-secondary">Petty Cash</span>
                                                    @else
                                                        <span class="badge bg-danger">Unpaid</span>
                                                    @endif
                                                </p>

                                                <p class="d-flex align-items-center justify-content-between">
                                                    <span class="text">
                                                        <i class="fa fa-user text-thm2 pe-2 vam"></i> Created By
                                                    </span>
                                                    <span>{{ $expense->user->name ?? ($expense->created_by ? 'User #' . $expense->created_by : 'N/A') }}</span>
                                                </p>

                                            </div>
                                        </div>

                                        <div class="service-about">
                                            <div class="p30 mb30 bg-white bdrs12 wow fadeInUp default-box-shadow1 bdr1">
                                                <h4><i class="fa fa-align-left pe-2 text-thm2"></i> Description</h4>
                                                <p class="text mb30">
                                                    {{ $expense->expense_details ?? 'No description provided' }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="d-flex justify-content-between">
                                        <div class="d-flex gap-2">
                                            @canany(['expenses.*', 'expenses.edit'])
                                                <a href="{{ route('expenses.edit', $expense->id) }}"
                                                    class="ud-btn btn-white2 py-0 ps-1 pe-2">
                                                    <i class="fa fa-edit me-1"></i> Edit
                                                </a>
                                            @endcanany
                                            @canany(['expenses.*', 'expenses.destroy'])
                                                <form action="{{ route('expenses.destroy', $expense->id) }}" method="POST"
                                                    class="d-inline">@csrf @method('DELETE')
                                                    <button class="ud-btn btn-thm6 py-0 ps-1 pe-2" data-confirm
                                                        data-confirm-title="Delete this expense?"
                                                        data-confirm-text="This cannot be undone!"
                                                        data-confirm-button="Yes, delete it!">
                                                        <i class="fas fa-trash-alt pe-1"></i> Delete
                                                    </button>
                                                </form>
                                            @endcanany
                                            <a href="{{ route('expenses.index') }}"
                                                class="ud-btn btn-white2 py-0 ps-1 pe-2">
                                                <i class="fa fa-arrow-left me-1"></i> Back
                                            </a>
                                        </div>
                                        <div class="d-flex justify-content-end">
                                            <button class="ud-btn btn-white2 py-0 ps-1 pe-2"
                                                onclick="printElement('printable-area')">
                                                <i class="fa fa-print me-1"></i> Print</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
