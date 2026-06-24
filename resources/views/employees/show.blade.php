<x-app-layout>
    <x-slot name="title">{{ __('Employee') . ' ' . __('Details') }}</x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Employee') . ' ' . __('Details') }}
        </h2>
    </x-slot>

    <div class="row">
        <div class="container-sm container-lg">
            <div class="bg-white shadow rounded-3 p-4 p-sm-8">
                <div class="w-100">
                    <!-- Employee Details -->
                    <section class="pt0 pb90 pb30-md">
                        <div class="container">
                            <div class="row wrap wow fadeInUp">
                                <div class="col-lg-8">
                                    <div class="column" id="printable-area">
                                        <div class="price-widget pt25 bdrs8">
                                            <h4><i class="fa fa-user text-thm2 pe-2 vam align-baseline"></i>{{ __('Employee') . ' ' . __('Details') }}</h4>
                                            <div class="category-list mt20">

                                                <p class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                    <span class="text">
                                                        <i class="fa fa-id-card text-thm2 pe-2 vam"></i> {{ __('Employee Code') }}
                                                    </span>
                                                    <span>{{ $employee->employee_code }}</span>
                                                </p>

                                                <p class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                    <span class="text">
                                                        <i class="fa fa-user text-thm2 pe-2 vam"></i> {{ __('Name') }}
                                                    </span>
                                                    <span>{{ $employee->name }}</span>
                                                </p>

                                                <p class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                    <span class="text">
                                                        <i class="fa fa-envelope text-thm2 pe-2 vam"></i> {{ __('Email') }}
                                                    </span>
                                                    <span>{{ $employee->email ?? 'N/A' }}</span>
                                                </p>

                                                <p class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                    <span class="text">
                                                        <i class="fa fa-phone text-thm2 pe-2 vam"></i> {{ __('Phone') }}
                                                    </span>
                                                    <span>{{ $employee->phone ?? 'N/A' }}</span>
                                                </p>

                                                <p class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                    <span class="text">
                                                        <i class="fa fa-building text-thm2 pe-2 vam"></i> {{ __('Department') }}
                                                    </span>
                                                    <span>{{ optional($employee->department)->name ?? 'N/A' }}</span>
                                                </p>

                                                <p class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                    <span class="text">
                                                        <i class="fa fa-briefcase text-thm2 pe-2 vam"></i> {{ __('Designation') }}
                                                    </span>
                                                    <span>{{ optional($employee->designation)->title ?? 'N/A' }}</span>
                                                </p>

                                                <p class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                    <span class="text">
                                                        <i class="fa fa-genderless text-thm2 pe-2 vam"></i> {{ __('Gender') }}
                                                    </span>
                                                    <span>{{ $employee->gender ?? 'N/A' }}</span>
                                                </p>

                                                <p class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                    <span class="text">
                                                        <i class="fa fa-calendar text-thm2 pe-2 vam"></i> {{ __('DOB') }}
                                                    </span>
                                                    <span>{{ $employee->dob ?? 'N/A' }}</span>
                                                </p>

                                                <p class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                    <span class="text">
                                                        <i class="fa fa-calendar-day text-thm2 pe-2 vam"></i> {{ __('Joining Date') }}
                                                    </span>
                                                    <span>{{ $employee->joining_date ?? 'N/A' }}</span>
                                                </p>

                                                <p class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                    <span class="text">
                                                        <i class="fa fa-calendar-times text-thm2 pe-2 vam"></i> {{ __('Exit Date') }}
                                                    </span>
                                                    <span>{{ $employee->exit_date ?? 'N/A' }}</span>
                                                </p>

                                                <p class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                    <span class="text">
                                                        <i class="fa fa-check-circle text-thm2 pe-2 vam"></i> {{ __('Status') }}
                                                    </span>
                                                    <span>{{ $employee->status ?? 'N/A' }}</span>
                                                </p>

                                                <p class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                    <span class="text">
                                                        <i class="fa fa-cogs text-thm2 pe-2 vam"></i> {{ __('Employment Type') }}
                                                    </span>
                                                    <span>{{ $employee->employment_type ?? 'N/A' }}</span>
                                                </p>

                                                <p class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                    <span class="text">
                                                        <i class="fa fa-cogs text-thm2 pe-2 vam"></i> {{ __('Assigned Assets') }}
                                                    </span>
                                                    <span>{{ $employee->assigned_assets ?? 'N/A' }}</span>
                                                </p>

                                                <p class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                    <span class="text">
                                                        <i class="fa fa-map-marker-alt text-thm2 pe-2 vam"></i> {{ __('Address') }}
                                                    </span>
                                                    <span>{{ $employee->address ?? 'N/A' }}</span>
                                                </p>

                                                <p class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                    <span class="text">
                                                        <i class="fa fa-map-marker-alt text-thm2 pe-2 vam"></i> {{ __('Permanent Address') }}
                                                    </span>
                                                    <span>{{ $employee->permanent_address ?? 'N/A' }}</span>
                                                </p>

                                                <p class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                    <span class="text">
                                                        <i class="fa fa-user-circle text-thm2 pe-2 vam"></i> {{ __('Father Name') }}
                                                    </span>
                                                    <span>{{ $employee->father_name ?? 'N/A' }}</span>
                                                </p>

                                                <p class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                    <span class="text">
                                                        <i class="fa fa-user-circle text-thm2 pe-2 vam"></i> {{ __('Mother Name') }}
                                                    </span>
                                                    <span>{{ $employee->mother_name ?? 'N/A' }}</span>
                                                </p>

                                                <p class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                    <span class="text">
                                                        <i class="fa fa-user-circle text-thm2 pe-2 vam"></i> {{ __('Spouse Name') }}
                                                    </span>
                                                    <span>{{ $employee->spouse_name ?? 'N/A' }}</span>
                                                </p>

                                                <p class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                    <span class="text">
                                                        <i class="fa fa-id-card text-thm2 pe-2 vam"></i> {{ __('NID') }}
                                                    </span>
                                                    <span>{{ $employee->nid ?? 'N/A' }}</span>
                                                </p>

                                                <p class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                    <span class="text">
                                                        <i class="fa fa-comment-alt text-thm2 pe-2 vam"></i> {{ __('Remarks') }}
                                                    </span>
                                                    <span>{{ $employee->remarks ?? 'N/A' }}</span>
                                                </p>

                                            </div>
                                        </div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="d-flex justify-content-between">
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('employees.edit', $employee->id) }}"
                                                class="ud-btn btn-white2 py-0 ps-1 pe-2"><i class="fa fa-edit me-1"></i> Edit</a>
                                            <form action="{{ route('employees.destroy', $employee->id) }}" method="POST"
                                                class="d-inline">@csrf @method('DELETE')
                                                <button class="ud-btn btn-thm6 py-0 ps-1 pe-2" data-confirm
                                                    data-confirm-title="Delete this employee?"
                                                    data-confirm-text="This cannot be undone!"
                                                    data-confirm-button="Yes, delete it!"><i
                                                        class="fas fa-trash-alt pe-1"></i> Delete</button>
                                            </form>
                                            <a href="{{ route('employees.index') }}"
                                                class="ud-btn btn-white2 py-0 ps-1 pe-2"><i
                                                    class="fa fa-arrow-left me-1"></i> Back</a>
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
