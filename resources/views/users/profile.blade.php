<x-app-layout>
    <x-slot name="title">{{ __('My') . ' ' . __('Profile') }}</x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My') . ' ' . __('Profile') }}
        </h2>
    </x-slot>

    <div class="row">
        <div class="container-sm container-lg">
            <div class="bg-white shadow rounded-3 p-4 p-sm-8">
                <div class="w-100">
                    <!-- Profile Details -->
                    <section class="pt0 pb90 pb30-md">
                        <div class="container">
                            <div class="row wrap wow fadeInUp">
                                <div class="col-lg-8">
                                    <div class="column">
                                        <div
                                            class="px30 pt30 pb30 mb30 bg-white bdrs12 wow fadeInUp default-box-shadow1 bdr1">
                                            <div class="position-relative overflow-hidden d-flex align-items-center">
                                                <div class="row">
                                                    <div class="col-xl-12">
                                                        <div class="position-relative">
                                                            <div class="list-meta d-sm-flex align-items-center">
                                                                <a class="position-relative freelancer-single-style"
                                                                    href="">
                                                                    {{-- <span class="online"></span> --}}
                                                                    <img class="rounded-circle wa-sm mb15-sm"
                                                                        src="{{ $user->profile_photo ? asset('storage/' . $user->profile_photo) : asset('storage/profile_images/default-profile.jpg') }}"
                                                                        alt="Freelancer Photo" width="150px">
                                                                </a>
                                                                <div class="ml20 ml0-xs">
                                                                    <h5 class="title mb-1">{{ $user->username }}</h5>
                                                                    <p class="mb-0">{{ $user->user_type }}</p>
                                                                    <p
                                                                        class="mb-0 dark-color fz15 fw500 list-inline-item mt10 mb5-sm ml0-xs">
                                                                        <i class="flaticon-place vam fz20 me-2"></i>
                                                                        {{ $user->address ? $user->address : 'no address' }}
                                                                    </p>
                                                                    <p
                                                                        class="mb-0 dark-color fz15 fw500 list-inline-item ml15 mb5-sm ml0-xs">
                                                                        <i class="flaticon-30-days vam fz20 me-2"></i>
                                                                        Member since
                                                                        {{ $user->joining_date ? $user->joining_date->format('d M, Y') : ': unknown' }}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="price-widget pt25 bdrs8">
                                            <h4>Profile Details</h4>
                                            <div class="category-list mt20">
                                                <p class="d-flex align-items-center justify-content-between bdrb1 pb-2"
                                                    href="">
                                                    <span class="text"><i
                                                            class="flaticon-cv text-thm2 pe-2 vam"></i>User ID</span>
                                                    <span>{{ $user->id }}</span>
                                                </p>
                                                <p class="d-flex align-items-center justify-content-between bdrb1 pb-2"
                                                    href="">
                                                    <span class="text"><i
                                                            class="flaticon-cv text-thm2 pe-2 vam"></i>Name</span>
                                                    <span>{{ ucwords(strtolower($user->name ?: 'Name not Found')) }}</span>
                                                </p>
                                                <p class="d-flex align-items-center justify-content-between bdrb1 pb-2"
                                                    href="">
                                                    <span class="text"><i
                                                            class="flaticon-mail text-thm2 pe-2 vam"></i>Email</span>
                                                    <span>{{ Str::lower($user->email) }}</span>
                                                </p>
                                                <p class="d-flex align-items-center justify-content-between bdrb1 pb-2"
                                                    href="">
                                                    <span class="text"><i
                                                            class="flaticon-mars text-thm2 pe-2 vam"></i>Gender</span>
                                                    <span>{{ Str::ucfirst($user->gender) }}</span>
                                                </p>
                                                <p class="d-flex align-items-center justify-content-between bdrb1 pb-2"
                                                    href="">
                                                    <span class="text"><i
                                                            class="flaticon-place text-thm2 pe-2 vam"></i>Address</span>
                                                    <span>{{ $user->address }}</span>
                                                </p>
                                                <p class="d-flex align-items-center justify-content-between bdrb1 pb-2"
                                                    href="">
                                                    <span class="text"><i
                                                            class="flaticon-call text-thm2 pe-2 vam"></i>Contact</span>
                                                    <span>{{ $user->contact }}</span>
                                                </p>
                                                <p class="d-flex align-items-center justify-content-between bdrb1 pb-2"
                                                    href="">
                                                    <span class="text"><i
                                                            class="flaticon-calendar text-thm2 pe-2 vam"></i>Date of
                                                        Birth</span>
                                                    <span>{{ $user->date_of_birth?->format('d M, Y') }}</span>
                                                </p>
                                                <p class="d-flex align-items-center justify-content-between bdrb1 pb-2"
                                                    href="">
                                                    <span class="text"><i
                                                            class="flaticon-calendar text-thm2 pe-2 vam"></i>Joining
                                                        Date</span>
                                                    <span>{{ $user->joining_date?->format('d M, Y') }}</span>
                                                </p>
                                            </div>
                                        </div>
                                        @if ($owner)
                                            <div class="price-widget pt25 bdrs8">
                                                <div class="pt25 bdrs8">
                                                    @php
                                                        $user = optional($owner->user);

                                                        function safeUcwords($value)
                                                        {
                                                            return $value ? ucwords(strtolower($value)) : '—';
                                                        }
                                                    @endphp

                                                    <div class="category-list mt20">
                                                        <p
                                                            class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                            <span class="text"><i
                                                                    class="flaticon-cv text-thm2 pe-2 vam"></i>Father's
                                                                Name</span>
                                                            <span>{{ safeUcwords($owner->fathers_name) }}</span>
                                                        </p>

                                                        <p
                                                            class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                            <span class="text"><i
                                                                    class="flaticon-cv text-thm2 pe-2 vam"></i>Mother's
                                                                Name</span>
                                                            <span>{{ safeUcwords($owner->mothers_name) }}</span>
                                                        </p>

                                                        <p
                                                            class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                            <span class="text"><i
                                                                    class="flaticon-cv text-thm2 pe-2 vam"></i>Spouse
                                                                Name</span>
                                                            <span>{{ safeUcwords($owner->spouse_name) }}</span>
                                                        </p>

                                                        <p
                                                            class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                            <span class="text"><i
                                                                    class="flaticon-cv text-thm2 pe-2 vam"></i>First
                                                                Nominee</span>
                                                            <span>{{ safeUcwords($owner->first_nominee) }}</span>
                                                        </p>

                                                        <p
                                                            class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                            <span class="text"><i
                                                                    class="flaticon-cv text-thm2 pe-2 vam"></i>Second
                                                                Nominee</span>
                                                            <span>{{ safeUcwords($owner->second_nominee) }}</span>
                                                        </p>

                                                        <p
                                                            class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                            <span class="text"><i
                                                                    class="flaticon-cv text-thm2 pe-2 vam"></i>Third
                                                                Nominee</span>
                                                            <span>{{ safeUcwords($owner->third_nominee) }}</span>
                                                        </p>

                                                        <p
                                                            class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                            <span class="text"><i
                                                                    class="flaticon-place text-thm2 pe-2 vam"></i>Present
                                                                Address</span>
                                                            <span>{{ $owner->present_address ?: '—' }}</span>
                                                        </p>

                                                        <p
                                                            class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                            <span class="text"><i
                                                                    class="flaticon-place text-thm2 pe-2 vam"></i>Permanent
                                                                Address</span>
                                                            <span>{{ $owner->parmanent_address ?: '—' }}</span>
                                                        </p>

                                                        <p
                                                            class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                            <span class="text"><i
                                                                    class="flaticon-document text-thm2 pe-2 vam"></i>NID
                                                                No</span>
                                                            <span>{{ $owner->nid_no ?: '—' }}</span>
                                                        </p>

                                                        <p
                                                            class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                            <span class="text"><i
                                                                    class="flaticon-document text-thm2 pe-2 vam"></i>TIN
                                                                No</span>
                                                            <span>{{ $owner->tin_no ?: '—' }}</span>
                                                        </p>

                                                        <p
                                                            class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                            <span class="text"><i
                                                                    class="flaticon-place text-thm2 pe-2 vam"></i>Membership</span>
                                                            <span>{{ $owner->membership ?: '—' }}</span>
                                                        </p>

                                                        <p
                                                            class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                            <span class="text"><i
                                                                    class="flaticon-document text-thm2 pe-2 vam"></i>Lifetime
                                                                Membership Fee</span>
                                                            <span>{{ $owner->lifetime_membership_fee ?: '—' }}</span>
                                                        </p>

                                                        <p
                                                            class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                            <span class="text"><i
                                                                    class="flaticon-document text-thm2 pe-2 vam"></i>Status</span>
                                                            <span
                                                                class="badge {{ $owner->status ? 'bg-success' : 'bg-danger' }}">
                                                                {{ $owner->status ? 'Active' : 'Inactive' }}
                                                            </span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        <div class="service-about">
                                            <div
                                                class="p30 mb30 bg-white bdrs12 wow fadeInUp default-box-shadow1 bdr1">
                                                <h4>About Me</h4>
                                                <p class="text mb30">{{ $user->about_me }}</p>
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
