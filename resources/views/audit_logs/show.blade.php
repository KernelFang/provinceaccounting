<x-app-layout>
    <x-slot name="title">{{ __('Audit Log') . ' #' . $log->id }}</x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Audit Log') . ' #' . $log->id }}
        </h2>
    </x-slot>

    <div class="row">
        <div class="container-sm container-lg">
            <div class="bg-white shadow rounded-3 p-4 p-sm-8">
                <div class="w-100">
                    <section class="pt0 pb90 pb30-md">
                        <div class="container">
                            <div class="row wrap wow fadeInUp">
                                <div class="col-lg-10">
                                    <div class="column" id="printable-area">
                                        <div class="price-widget pt25 bdrs8">
                                            <h4><i class="fas fa-clipboard-list text-thm2 pe-2 vam align-baseline"></i>{{ __('Audit Log') . ' #' . $log->id }}</h4>
                                            <div class="category-list mt20">
                                                <p class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                    <span class="text">
                                                        <i class="fas fa-user text-thm2 pe-2 vam"></i>User
                                                    </span>
                                                    <span>
                                                        {!! $log->user
                                                            ? '<a href="' . route('users.show', $log->user->id) . '">' . e($log->user->name) . '</a>'
                                                            : '<span class="text-muted">System / Unknown</span>' !!}
                                                    </span>
                                                </p>

                                                <p class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                    <span class="text">
                                                        <i class="fas fa-bolt text-thm2 pe-2 vam"></i>Action
                                                    </span>
                                                    <span>{{ ucfirst($log->action) }}</span>
                                                </p>

                                                <p class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                    <span class="text">
                                                        <i class="fas fa-database text-thm2 pe-2 vam"></i>Model
                                                    </span>
                                                    <span>{{ $log->auditable_type }}</span>
                                                </p>

                                                <p class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                    <span class="text">
                                                        <i class="fas fa-id-badge text-thm2 pe-2 vam"></i>Record ID
                                                    </span>
                                                    <span>{{ $log->auditable_id }}</span>
                                                </p>

                                                <p class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                    <span class="text">
                                                        <i class="fas fa-globe text-thm2 pe-2 vam"></i>IP Address
                                                    </span>
                                                    <span>{{ $log->ip_address ?? 'N/A' }}</span>
                                                </p>

                                                <p class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                    <span class="text">
                                                        <i class="fas fa-calendar-alt text-thm2 pe-2 vam"></i>Created At
                                                    </span>
                                                    <span>{{ $log->created_at?->format('Y-m-d H:i:s') }}</span>
                                                </p>

                                                <p class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                    <span class="text">
                                                        <i class="fas fa-calendar-check text-thm2 pe-2 vam"></i>Updated
                                                        At
                                                    </span>
                                                    <span>{{ $log->updated_at?->format('Y-m-d H:i:s') }}</span>
                                                </p>
                                            </div>
                                        </div>

                                        <!-- Old & New Values -->
                                        <div class="service-about mt-4">
                                            <div class="p30 mb30 bg-white bdrs12 wow fadeInUp default-box-shadow1 bdr1">
                                                <h4><i class="fas fa-history text-thm2 pe-2"></i>Old Values</h4>

                                                <div class="px-4 pt-1">
                                                    @if ($log->old_values)
                                                        {{-- Raw JSON Format --}}
                                                        <h6 class="mt-3"><i class="fas fa-code pe-2 fs-6"></i>Raw JSON
                                                        </h6>
                                                        <pre class="bg-light p-3 rounded">{{ json_encode($log->old_values, JSON_PRETTY_PRINT) }}</pre>

                                                        @php
                                                            $oldValues = json_decode($log->old_values, true);
                                                        @endphp

                                                        @if (!empty($oldValues))
                                                            {{-- Accordion Wrapper for Human-Readable Format --}}
                                                            <div class="accordion-style2 mt-4">
                                                                <h2 class="accordion-header" id="oldValuesHeading">
                                                                    <button class="accordion-button collapsed fs-6"
                                                                        type="button" data-bs-toggle="collapse"
                                                                        data-bs-target="#oldValuesCollapse"
                                                                        aria-expanded="true"
                                                                        aria-controls="oldValuesCollapse">
                                                                        <i
                                                                            class="fas fa-eye text-thm2 pe-2"></i>Readable
                                                                        Format
                                                                    </button>
                                                                </h2>
                                                            </div>

                                                            <div class="accordion-style1 mt-4">
                                                                <div class="accordion" id="oldValuesAccordion">
                                                                    <div class="accordion-item">
                                                                        <div id="oldValuesCollapse"
                                                                            class="accordion-collapse collapse"
                                                                            aria-labelledby="oldValuesHeading"
                                                                            data-parent="#oldValuesAccordion">
                                                                            <div class="accordion-body">
                                                                                <div class="row">
                                                                                    <div
                                                                                        class="col-12 col-md-7 mx-auto">
                                                                                        <div
                                                                                            class="px-4 py-1 mt-3 bg-white bdrs12 wow fadeInUp default-box-shadow1 bdr1">
                                                                                            <div
                                                                                                class="category-list mt20 small">
                                                                                                @foreach ($oldValues as $key => $value)
                                                                                                    <p
                                                                                                        class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                                                                        <span
                                                                                                            class="text text-capitalize">
                                                                                                            <i
                                                                                                                class="fas fa-angle-right text-thm2 pe-2 vam"></i>{{ str_replace('_', ' ', $key) }}
                                                                                                        </span>
                                                                                                        <span>
                                                                                                            {{ is_array($value) ? json_encode($value) : $value }}
                                                                                                        </span>
                                                                                                    </p>
                                                                                                @endforeach
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div> <!-- /.accordion-body -->
                                                                        </div> <!-- /.accordion-collapse -->
                                                                    </div> <!-- /.accordion-item -->
                                                                </div> <!-- /.accordion -->
                                                            </div> <!-- /.accordion-style1 -->
                                                        @else
                                                            <p class="text-muted">No old values found.</p>
                                                        @endif
                                                    @else
                                                        <p class="text-muted">N/A</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>


                                        <div class="p30 mb30 bg-white bdrs12 wow fadeInUp default-box-shadow1 bdr1">
                                            <h4><i class="fas fa-sync-alt text-thm2 pe-2"></i>New Values</h4>

                                            <div class="px-4 pt-1">
                                                @if ($log->new_values)
                                                    {{-- Raw JSON Format --}}
                                                    <h6 class="mt-3"><i class="fas fa-code pe-2 fs-6"></i>Raw JSON
                                                    </h6>
                                                    <pre class="bg-light p-3 rounded">{{ json_encode($log->new_values, JSON_PRETTY_PRINT) }}</pre>

                                                    @php
                                                        $oldValues = json_decode($log->new_values, true);
                                                    @endphp

                                                    @if (!empty($oldValues))
                                                        {{-- Accordion Wrapper for Human-Readable Format --}}
                                                        <div class="accordion-style2 mt-4">
                                                            <h2 class="accordion-header" id="oldValuesHeading">
                                                                <button class="accordion-button collapsed fs-6"
                                                                    type="button" data-bs-toggle="collapse"
                                                                    data-bs-target="#oldValuesCollapse"
                                                                    aria-expanded="true"
                                                                    aria-controls="oldValuesCollapse">
                                                                    <i class="fas fa-eye text-thm2 pe-2"></i>Readable
                                                                    Format
                                                                </button>
                                                            </h2>
                                                        </div>

                                                        <div class="accordion-style1 mt-4">
                                                            <div class="accordion" id="oldValuesAccordion">
                                                                <div class="accordion-item">
                                                                    <div id="oldValuesCollapse"
                                                                        class="accordion-collapse collapse"
                                                                        aria-labelledby="oldValuesHeading"
                                                                        data-parent="#oldValuesAccordion">
                                                                        <div class="accordion-body">
                                                                            <div class="row">
                                                                                <div class="col-12 col-md-7 mx-auto">
                                                                                    <div
                                                                                        class="px-4 py-1 mt-3 bg-white bdrs12 wow fadeInUp default-box-shadow1 bdr1">
                                                                                        <div
                                                                                            class="category-list mt20 small">
                                                                                            @foreach ($oldValues as $key => $value)
                                                                                                <p
                                                                                                    class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                                                                    <span
                                                                                                        class="text text-capitalize">
                                                                                                        <i
                                                                                                            class="fas fa-angle-right text-thm2 pe-2 vam"></i>{{ str_replace('_', ' ', $key) }}
                                                                                                    </span>
                                                                                                    <span>
                                                                                                        {{ is_array($value) ? json_encode($value) : $value }}
                                                                                                    </span>
                                                                                                </p>
                                                                                            @endforeach
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div> <!-- /.accordion-body -->
                                                                    </div> <!-- /.accordion-collapse -->
                                                                </div> <!-- /.accordion-item -->
                                                            </div> <!-- /.accordion -->
                                                        </div> <!-- /.accordion-style1 -->
                                                    @else
                                                        <p class="text-muted">No old values found.</p>
                                                    @endif
                                                @else
                                                    <p class="text-muted">N/A</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="d-flex justify-content-between">
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('audit-logs.index') }}"
                                                class="ud-btn btn-white2 py-0 ps-1 pe-2">
                                                <i class="fa fa-arrow-left me-1"></i> Back to Audit Logs
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
                </div>
                </section>
            </div>
        </div>
    </div>
    </div>
</x-app-layout>
