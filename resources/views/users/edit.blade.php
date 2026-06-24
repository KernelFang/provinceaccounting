<x-app-layout>
    <x-slot name="title">{{ __('User') . ' ' . __('Management') }}</x-slot>

    <x-slot name="header">
        <h2 class="">
            {{ __('User') . ' ' . __('Management') }}
        </h2>
    </x-slot>

    <x-slot name="style">
        <link rel="stylesheet" href="{{ asset('theme/v1/css/cropper.css') }}">
        <link rel="stylesheet" href="{{ asset('theme/v1/css/image-upload.css') }}">
        <style>
            .permission-card {
                transition: all 0.2s ease;
            }

            .permission-card:hover {
                transform: translateY(-3px);
                box-shadow: 0 8px 20px rgba(0, 0, 0, 0.06);
            }

            .permission-pill {
                padding: 6px 14px;
                border-radius: 50px;
                border: 1px solid #ddd;
                cursor: pointer;
                font-size: 13px;
                transition: 0.2s;
                background: #f8f9fa;
            }

            .permission-pill input {
                display: none;
            }

            .permission-pill.active {
                background: #24AAE0;
                color: #fff;
                border-color: #24AAE0;
            }

            .permission-pill:hover {
                background: #e9f2ff;
            }

            .module-count {
                font-size: 12px;
            }
        </style>
    </x-slot>

    <x-slot name="script">
        <!-- Compressor.js CDN -->
        <script src="{{ asset('theme/v1/js/compressor.js') }}"></script>
        <!-- Cropper.js -->
        <script src="{{ asset('theme/v1/js/cropper.js') }}"></script>
        <script src="{{ asset('theme/v1/js/image-upload.js') }}"></script>
    </x-slot>


    <div class="row">
        <div class="col-xl-12">
            <div class="ps-widget bgc-white bdrs4 p30 mb30 overflow-hidden position-relative">
                <div class="bdrb1 pb15 mb25">
                    <h5 class="list-title">{{ __('Update') . ' ' . __('Profile') . ' ' . __('Photo') }}</h5>
                </div>
                <div class="col-xl-7">
                    <script>
                        window.Laravel = {
                            csrfToken: '{{ csrf_token() }}'
                        };
                    </script>
                    <div class="profile-box d-flex align-items-center flex-wrap flex-sm-nowrap mb30">
                        <div class="profile-img mb20-sm mx-auto mx-sm-0" style="max-width:130px;max-heigh:130px">
                            <!-- Profile image, initially shown as a placeholder -->
                            <img id="profileImage" class="w-100 rounded-circle"
                                src="{{ $user->profile_photo ? asset('storage/' . $user->profile_photo) : asset('storage/profile_images/default-profile.jpg') }}"
                                alt="Profile Image">
                        </div>
                        <div class="profile-content ml30 ml0-xs">
                            <div class="d-flex align-items-center justify-content-center justify-content-sm-start my-3">
                                <a href="#" class="upload-btn" id="uploadBtn">
                                    <span class="flaticon-images text-thm2 align-middle mr5"></span>Upload
                                </a>
                                <input type="file" id="imageUpload" accept=".jpg,.jpeg,.png"
                                    style="display: none;" />

                                <!-- Save button triggers the image upload to backend -->
                                <a href="#" class="ud-btn btn-thm ml50 py-1 px-3" id="saveBtn">
                                    <span class="flaticon-save text-thm2 align-middle mr5"></span>Save
                                </a>

                            </div>
                            <p class="text mb-0 text-center text-sm-start">Max file size is 1MB, Minimum dimension:
                                300x300. Suitable files are
                                .jpg, .jpeg & .png.</p>
                        </div>
                    </div>

                    <!-- Cropper Modal (Hidden initially) -->
                    <div id="cropperModal" class="modal">
                        <div class="modal-content">
                            <div class="modalTop d-flex justify-content-end">
                                <button type="button" class="btn-close" id="closeModal"></button>
                            </div>
                            <div class="cropper-container">
                                <img id="cropperImage" src="" alt="Crop Image">
                            </div>
                            <div class="slider-container">
                                <div class="form-group me-2">
                                    <input type="range" class="zoom-slider form-control" id="zoomSlider"
                                        min="0.5" max="3" step="0.01" value="1"
                                        style="height: 25px;padding: 0.15rem 0.3rem">
                                    <p class="zoom-value">Zoom: <span id="zoomValue">1</span>x</p>
                                </div>
                                <div class="form-group ms-2">
                                    <input type="range" class="rotate-slider form-control" id="rotateSlider"
                                        min="-180" max="180" step="1" value="0"
                                        style="height: 25px;padding: 0.15rem 0.3rem">
                                    <p class="rotate-value">Rotate: <span id="rotateValue">0</span>°</p>
                                </div>
                            </div>
                            <button id="cropButton" class="ud-btn btn-thm">Crop Image</button>
                        </div>
                    </div>
                </div>
            </div>

            <form method="post" action="{{ route('users.update', $user->id) }}" class="form-style1">
                {{ method_field('PATCH') }}
                @csrf

                <div class="ps-widget bgc-white bdrs4 p30 mb30 overflow-hidden position-relative">
                    <div class="bdrb1 pb15 mb25">
                        <h5 class="list-title">{{ __('Update') . ' ' . __('Profile') . ' ' . __('Details') }}</h5>
                    </div>
                    <div class="col-lg-7">

                        <div class="row">
                            @include('users.form')
                        </div>
                    </div>
                </div>

                @if (!empty($canEditPermissions))
                    <div class="ps-widget bgc-white bdrs4 p30 mb30 overflow-hidden position-relative">
                        <div class="d-flex justify-content-between align-items-center bdrb1 pb15 mb25">
                            <h5 class="list-title mb-0">{{ __('Permissions') }}</h5>

                            <!-- Global Controls -->
                            <div class="d-flex align-items-center gap-3">
                                <input type="text" id="permissionSearch" class="form-control form-control-sm"
                                    placeholder="Search module..." style="max-width:200px;">

                                <button type="button" id="selectAllGlobal" class="btn btn-sm btn-outline-primary">
                                    Select All
                                </button>

                                <button type="button" id="clearAllGlobal" class="btn btn-sm btn-outline-danger">
                                    Clear All
                                </button>
                            </div>
                        </div>

                        @php
                            $userPerms = $userPermissions ?? [];
                            $roleDefaults = config('permissions.' . $user->user_type, []);
                        @endphp

                        <div class="permissions-grid row g-4">
                            @foreach ($siteModules as $module => $actions)
                                @php
                                    $available = array_values(
                                        array_filter((array) $actions, fn($a) => !in_array($a, ['store', 'update'])),
                                    );

                                    $selected = (array) ($userPerms[$module] ?? []);
                                    $roleActions = (array) ($roleDefaults[$module] ?? []);

                                    if (in_array('*', $roleActions)) {
                                        $roleActions = $available;
                                    }

                                    if (in_array('*', $selected)) {
                                        $selected = $available;
                                    }

                                    $granted = array_values(
                                        array_intersect(
                                            $available,
                                            array_values(array_unique(array_merge($selected, $roleActions))),
                                        ),
                                    );
                                @endphp

                                <div class="col-md-6 col-xl-4 permission-module" data-module="{{ $module }}">

                                    <div class="card permission-card h-100">
                                        <div class="card-header d-flex justify-content-between align-items-center">

                                            <div>
                                                <input type="checkbox" class="form-check-input module-select-all"
                                                    id="module_all_{{ $module }}"
                                                    data-module="{{ $module }}"
                                                    @if (count($granted) === count($available) && count($available) > 0) checked @endif>

                                                <strong class="text-capitalize ms-2">
                                                    {{ str_replace('-', ' ', $module) }}
                                                </strong>
                                            </div>

                                            <span class="badge bg-primary module-count">
                                                {{ count($granted) }}/{{ count($available) }}
                                            </span>
                                        </div>

                                        <div class="card-body">
                                            <div class="d-flex flex-wrap gap-2">
                                                @foreach ($available as $action)
                                                    @php $isGranted = in_array($action, $granted); @endphp

                                                    <label class="permission-pill {{ $isGranted ? 'active' : '' }}">
                                                        <input type="checkbox"
                                                            name="permissions[{{ $module }}][]"
                                                            value="{{ $action }}"
                                                            class="action-checkbox action-{{ $module }}"
                                                            data-module="{{ $module }}"
                                                            @if ($isGranted) checked @endif>

                                                        {{ ucfirst($action) }}
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="ps-widget bgc-white bdrs4 p30 mb30 overflow-hidden position-relative">
                    <div class="bdrb1 pb15 mb25">
                        <h5 class="list-title">{{ __('Change') . ' ' . __('Password') }}</h5>
                    </div>
                    <div class="col-lg-7">
                        <div class="col-sm-6">
                            <div class="mb20">
                                <x-input-label class="heading-color" for="password" :value="__('Password')" />
                                <x-text-input type="password" class="form-control" id="password" name="password"
                                    autocomplete="new-password" placeholder="********" />

                                <x-input-error :messages="$errors->get('password')" />
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="mb20">
                                <x-input-label class="heading-color" for="password_confirmation" :value="__('Confirm Password')" />
                                <x-text-input type="password" class="form-control" id="password_confirmation"
                                    name="password_confirmation" autocomplete="new-password"
                                    placeholder="********" />

                                <x-input-error :messages="$errors->get('password_confirmation')" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ps-widget bgc-white bdrs4 p30 mb30 overflow-hidden position-relative">
                    <div class="col-md-12">
                        <div class="text-start">
                            <x-primary-button type="submit">{{ __('Update Record') }}</x-primary-button>

                            @if (session('status') === 'user-updated')
                                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                                    class="text-sm text-gray">
                                    <i class="fal fa-arrow-right-long"></i>
                                    {{ __('Saved.') }}
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {

                // Toggle module select all
                document.querySelectorAll('.module-select-all').forEach(function(el) {
                    el.addEventListener('change', function() {
                        let mod = this.dataset.module;
                        let checked = this.checked;

                        document.querySelectorAll('.action-' + mod).forEach(function(inp) {
                            inp.checked = checked;
                            inp.closest('.permission-pill').classList.toggle('active', checked);
                        });

                        updateModuleCount(mod);
                    });
                });

                // Individual permission toggle
                document.querySelectorAll('.action-checkbox').forEach(function(inp) {
                    inp.addEventListener('change', function() {
                        let mod = this.dataset.module;
                        this.closest('.permission-pill')
                            .classList.toggle('active', this.checked);

                        let all = Array.from(document.querySelectorAll('.action-' + mod));
                        let selectAll = document.querySelector('#module_all_' + mod);
                        selectAll.checked = all.every(i => i.checked);

                        updateModuleCount(mod);
                    });
                });

                // Update badge counter
                function updateModuleCount(mod) {
                    let total = document.querySelectorAll('.action-' + mod).length;
                    let checked = document.querySelectorAll('.action-' + mod + ':checked').length;

                    let container = document.querySelector('.permission-module[data-module="' + mod + '"]');
                    container.querySelector('.module-count').innerText = checked + '/' + total;
                }

                // Global Select All
                const selectAllGlobalBtn = document.getElementById('selectAllGlobal');
                if (selectAllGlobalBtn) {
                    selectAllGlobalBtn.addEventListener('click', function() {
                        document.querySelectorAll('.action-checkbox').forEach(function(inp) {
                            inp.checked = true;
                            inp.closest('.permission-pill').classList.add('active');
                        });
                        document.querySelectorAll('.module-select-all').forEach(el => el.checked = true);
                    });
                }

                // Global Clear All
                const clearAllGlobalBtn = document.getElementById('clearAllGlobal');
                if (clearAllGlobalBtn) {
                    clearAllGlobalBtn.addEventListener('click', function() {
                        document.querySelectorAll('.action-checkbox').forEach(function(inp) {
                            inp.checked = false;
                            inp.closest('.permission-pill').classList.remove('active');
                        });
                        document.querySelectorAll('.module-select-all').forEach(el => el.checked = false);
                    });
                }

                // Search Filter
                const permissionSearch = document.getElementById('permissionSearch');
                if (permissionSearch) {
                    permissionSearch.addEventListener('keyup', function() {
                        let value = this.value.toLowerCase();

                        document.querySelectorAll('.permission-module').forEach(function(card) {
                            let moduleName = card.dataset.module.toLowerCase();
                            card.style.display = moduleName.includes(value) ? '' : 'none';
                        });
                    });
                }

            });
        </script>
</x-app-layout>
