<x-app-layout>
    <x-slot name="title">{{ __('User') . ' ' . __('Management') }}</x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User') . ' ' . __('Management') }}
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
                                    <div class="column" id="printable-area">
                                        <div
                                            class="px30 pt30 pb30 mb30 bg-white bdrs12 wow fadeInUp default-box-shadow1 bdr1">
                                            <div class="position-relative overflow-hidden d-flex align-items-center">
                                                <div class="row">
                                                    <div class="col-xl-12">
                                                        <div class="position-relative">
                                                            <div class="list-meta d-sm-flex align-items-center">
                                                                <a class="position-relative freelancer-single-style"
                                                                    href="#">
                                                                    <img class="rounded-circle wa-sm mb15-sm"
                                                                        src="{{ $user->profile_photo ? asset('storage/' . $user->profile_photo) : asset('storage/profile_images/default-profile.jpg') }}"
                                                                        alt="User Photo" width="150px">
                                                                </a>
                                                                <div class="ml20 ml0-xs">
                                                                    <h5 class="title mb-1">{{ $user->username }}</h5>
                                                                    <p class="mb-0">{{ $user->user_type }}</p>
                                                                    <p
                                                                        class="mb-0 dark-color fz15 fw500 list-inline-item ml15 mb5-sm ml0-xs">
                                                                        <i
                                                                            class="fa fa-calendar-check vam fz20 me-2 text-thm2"></i>
                                                                        Member since
                                                                        {{ $user->joining_date ? $user->joining_date->format('d M, Y') : 'Unknown' }}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- User Info -->
                                        <div class="price-widget pt25 bdrs8">
                                            <h4><i class="fa fa-user-circle text-thm2 pe-2"></i>User Details</h4>
                                            <div class="category-list mt20">
                                                <p class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                    <span class="text"><i
                                                            class="fa fa-id-badge text-thm2 pe-2 vam"></i>User ID</span>
                                                    <span>{{ $user->id }}</span>
                                                </p>

                                                <p class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                    <span class="text"><i
                                                            class="fa fa-user text-thm2 pe-2 vam"></i>Name</span>
                                                    <span>{{ ucwords(strtolower($user->name ?: 'Name not Found')) }}</span>
                                                </p>

                                                <p class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                    <span class="text"><i
                                                            class="fa fa-user text-thm2 pe-2 vam"></i>Username</span>
                                                    <span>{{ $user->username }}</span>
                                                </p>

                                                <p class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                    <span class="text"><i
                                                            class="fa fa-envelope text-thm2 pe-2 vam"></i>Email</span>
                                                    <span>{{ Str::lower($user->email) }}</span>
                                                </p>

                                                <p class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                    <span class="text"><i
                                                            class="fa fa-venus-mars text-thm2 pe-2 vam"></i>Gender</span>
                                                    <span>{{ Str::ucfirst($user->gender) }}</span>
                                                </p>

                                                <p class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                    <span class="text"><i
                                                            class="fa fa-phone text-thm2 pe-2 vam"></i>Contact</span>
                                                    <span>{{ $user->contact }}</span>
                                                </p>

                                                <p class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                    <span class="text"><i
                                                            class="fa fa-calendar-alt text-thm2 pe-2 vam"></i>Date of
                                                        Birth</span>
                                                    <span>{{ $user->date_of_birth?->format('d M, Y') }}</span>
                                                </p>

                                                <p class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                    <span class="text"><i
                                                            class="fa fa-briefcase text-thm2 pe-2 vam"></i>User
                                                        Type</span>
                                                    <span>{{ Str::ucfirst($user->user_type) ?? 'N/A' }}</span>
                                                </p>

                                                <p class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                    <span class="text"><i
                                                            class="fa fa-map-marker-alt text-thm2 pe-2 vam"></i>Address</span>
                                                    <span>{{ $user->address ?? 'N/A' }}</span>
                                                </p>
                                            </div>
                                        </div>

                                        <!-- About Me -->
                                        <div class="service-about">
                                            <div class="p30 mb30 bg-white bdrs12 wow fadeInUp default-box-shadow1 bdr1">
                                                <h4><i class="fa fa-info-circle text-thm2 pe-2"></i>About Me</h4>
                                                <p class="text mb30">
                                                    {{ $user->about_me ?: 'No information provided.' }}</p>
                                            </div>
                                        </div>

                                    </div> <!-- /.column -->

                                    <!-- Action Buttons -->
                                    <div class="d-flex justify-content-between">
                                        <div class="d-flex gap-2">
                                            @canany(['users.*', 'users.edit'])
                                                <a href="{{ route('users.edit', $user->id) }}"
                                                    class="ud-btn btn-white2 py-0 ps-1 pe-2">
                                                    <i class="fa fa-edit me-1"></i> Edit
                                                </a>
                                            @endcanany
                                            @canany(['users.*', 'users.destroy'])
                                                <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                                    class="d-inline">@csrf @method('DELETE')
                                                    <button class="ud-btn btn-thm6 py-0 ps-1 pe-2" data-confirm
                                                        data-confirm-title="Delete this user?"
                                                        data-confirm-text="This cannot be undone!"
                                                        data-confirm-button="Yes, delete it!">
                                                        <i class="fas fa-trash-alt pe-1"></i> Delete
                                                    </button>
                                                </form>
                                            @endcanany
                                            <a href="{{ route('users.index') }}"
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
