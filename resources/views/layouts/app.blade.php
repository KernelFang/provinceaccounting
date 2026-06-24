<!DOCTYPE html>
<html dir="ltr" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- <meta name="keywords"
        content="gen z travels, gen z, gen z travel agency, gen z tours, gen z vacations, gen z travel services, gen z flight bookings, gen z hotel reservations, gen z tour packages, gen z travel insurance">
    <meta name="description" content="Gen Z Travels is a travel agency that offers a wide range of travel services, including flight bookings, hotel reservations, tour packages, and travel insurance. We are committed to providing our customers with the best travel experience possible."> --}}
    <meta name="CreativeLayers" content="ATFN">

    <!-- Title -->
    <title>{{ $title ?? config('app.name', 'Gen Z Travels') }}</title>

    <!-- css file -->
    <link rel="stylesheet" href="{{ asset('theme/v1/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('theme/v1/css/jquery-ui.min.css') }}">
    <link rel="stylesheet" href="{{ asset('theme/v1/css/ace-responsive-menu.css') }}">
    <link rel="stylesheet" href="{{ asset('theme/v1/css/menu.css') }}">
    <link rel="stylesheet" href="{{ asset('theme/v1/css/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('theme/v1/css/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('theme/v1/css/bootstrap-select.min.css') }}">
    <link rel="stylesheet" href="{{ asset('theme/v1/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('theme/v1/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('theme/v1/css/slider.css') }}">
    <link rel="stylesheet" href="{{ asset('theme/v1/css/sweetalert2.css') }}">
    <link rel="stylesheet" href="{{ asset('theme/v1/css/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('theme/v1/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('theme/v1/css/ud-custom-spacing.css') }}">

    {{-- daterangepicker CSS (CDN) --}}
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <!-- Dashboard stylesheet -->
    <link rel="stylesheet" href="{{ asset('theme/v1/css/dashbord_navitaion.css') }}">

    <!-- Responsive stylesheet -->
    <link rel="stylesheet" href="{{ asset('theme/v1/css/responsive.css') }}">

    <style>
        .hover-bgc-color {
            background-color: #F0EFEC40 !important;
        }

        #menu .mm-listview i {
            min-width: 20px;
            text-align: center;
        }
    </style>

    <!-- Css loading -->
    @isset($style)
        {{ $style }}
    @endisset

    <!-- Favicon -->
    <link href="{{ asset('theme/v1/images/favicon.ico') }}" sizes="128x128" rel="shortcut icon" type="image/x-icon" />
</head>

<body>
    <div class="wrapper">
        <div class="preloader"></div>

        <!-- Main Header Nav -->
        <header class="header-nav nav-innerpage-style menu-home4 dashboard_header main-menu">
            <!-- Ace Responsive Menu -->
            <nav class="posr">
                <div class="container-fluid pr30 pr15-xs pl30 posr menu_bdrt1">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-6 col-lg-auto">
                            <div class="text-center text-lg-start d-flex align-items-center">
                                <div class="dashboard_header_logo position-relative me-2 me-xl-5">
                                    <a href="{{ route('dashboard') }}" class="logo"><img
                                            src="{{ asset('theme/v1/images/logo.png') }}" alt="Header Logo"
                                            style="width: 100px; height: auto;" alt=""></a>
                                </div>
                                <div class="fz20 ml90">
                                    <a href="#" class="dashboard_sidebar_toggle_icon vam"><img
                                            src="{{ asset('theme/v1/images/dashboard-navicon.svg') }}"
                                            alt=""></a>
                                </div>

                                <a class="login-info d-block d-xl-none ml40 vam" data-bs-toggle="modal"
                                    href="#exampleModalToggle" role="button"><span class="flaticon-loupe"></span></a>
                            </div>
                        </div>
                        <div class="col-6 col-lg-auto">
                            <div class="text-center text-lg-end header_right_widgets">
                                <ul
                                    class="dashboard_dd_menu_list d-flex align-items-center justify-content-center justify-content-sm-end mb-0 p-0">
                                    <li class="user_setting">
                                        <div class="dropdown">
                                            @php
                                                $loggedInUserPic =
                                                    auth()->user()->profile_photo ??
                                                    'profile_images/default-profile.jpg';
                                            @endphp
                                            <a class="btn d-flex align-items-center" href="#"
                                                data-bs-toggle="dropdown">
                                                <div class="mr10">
                                                    <span class="d-block">{!! Auth::user()->name ?: '<span class="text-muted">Name not found</span>' !!}
                                                    </span>
                                                    <span class="text-secondary float-end"
                                                        style="font-size: 0.9rem">({{ Auth::user()->user_type }})
                                                    </span>
                                                </div>
                                                <img src="{{ asset('storage/' . $loggedInUserPic) }}" alt="user.png"
                                                    width="40" height="40" class="rounded-circle">
                                            </a>
                                            <div class="dropdown-menu">
                                                <div class="user_setting_content">
                                                    <p class="fz15 fw400 ff-heading mt30 pl30">Account</p>
                                                    <a class="dropdown-item" href="{{ route('users.profile') }}"><i
                                                            class="flaticon-photo mr10"></i>My Profile</a>

                                                    <form method="POST" action="{{ route('logout') }}">
                                                        @csrf

                                                        <a href="{{ route('logout') }}" class="dropdown-item"
                                                            onclick="event.preventDefault(); this.closest('form').submit();">
                                                            <i class="flaticon-logout mr10"></i>
                                                            {{ __('Log Out') }}</a>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </header>
        <!-- Search Modal -->
        <div class="search-modal">
            <div class="modal fade" id="exampleModalToggle" aria-hidden="true"
                aria-labelledby="exampleModalToggleLabel" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalToggleLabel"></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                                    class="fal fa-xmark"></i></button>
                        </div>
                        <div class="modal-body">
                            <div class="popup-search-field search_area">
                                <input type="text" class="form-control border-0"
                                    placeholder="What service are you looking for today?">
                                <label><span class="far fa-magnifying-glass"></span></label>
                                <button class="ud-btn btn-thm" type="submit">Search</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="hiddenbar-body-ovelay"></div>

        <!-- Mobile Nav  -->
        <div id="page" class="mobilie_header_nav stylehome1">
            <div class="mobile-menu">
                <div class="header bdrb1">
                    <div class="menu_and_widgets">
                        <div class="mobile_menu_bar d-flex justify-content-between align-items-center">
                            <a class="mobile_logo" href="#">
                                <img src="{{ asset('theme/v1/images/logo.png') }}" alt="Header Logo"
                                    style="width: 50px; height: auto;">
                            </a>
                            <div class="right-side text-end">
                                <ul
                                    class="dashboard_dd_menu_list d-flex align-items-center justify-content-center justify-content-sm-end mb-0 p-0">
                                    <li class="user_setting">
                                        <div class="dropdown">
                                            @php
                                                $loggedInUserPic =
                                                    auth()->user()->profile_photo ??
                                                    'profile_images/default-profile.jpg';
                                            @endphp
                                            <a class="btn d-flex align-items-center" href="#"
                                                data-bs-toggle="dropdown">
                                                <div class="mr10">
                                                    <span class="d-block">{!! Auth::user()->name ?: '<span class="text-muted">Name not found</span>' !!}
                                                    </span>
                                                    <span class="text-secondary float-end"
                                                        style="font-size: 0.9rem">({{ Auth::user()->user_type }})
                                                    </span>
                                                </div>
                                                <img src="{{ asset('storage/' . $loggedInUserPic) }}" alt="user.png"
                                                    width="35" height="35" class="rounded-circle">
                                            </a>
                                            <div class="dropdown-menu p-2" style="max-width: 215px">
                                                <div class="user_setting_content">
                                                    <p class="fz15 fw400 ff-heading mt10 pl30">Account</p>
                                                    <a class="dropdown-item py-0 fz15"
                                                        href="{{ route('users.profile') }}" style="line-height: 3"><i
                                                            class="flaticon-photo mr10"></i>My Profile</a>

                                                    @if (auth()->user()->user_type == 'freelancer')
                                                        <p class="fz15 fw400 ff-heading mt10 pl30">Wallet</p>
                                                        @php
                                                            $wallet = auth()->user()?->wallet;
                                                        @endphp

                                                        @if ($wallet)
                                                            <p class="fz15 pl30 text-black lh-1">Balance:
                                                                {{ $wallet->balance }}
                                                            </p>

                                                            <a class="dropdown-item py-0"
                                                                href="{{ route('wallets.show', auth()->user()->id) }}"
                                                                style="line-height: 3"><i
                                                                    class="flaticon-wallet mr10"></i>Wallet</a>
                                                        @else
                                                            @canany(['wallets.*', 'wallets.create'])
                                                                <a class="dropdown-item py-0"
                                                                    href="{{ route('wallets.create') }}"
                                                                    style="line-height: 3"><i
                                                                        class="flaticon-wallet mr10"></i>Wallet</a>
                                                            @endcanany
                                                        @endif
                                                    @endif

                                                    <form method="POST" action="{{ route('logout') }}">
                                                        @csrf

                                                        <a href="{{ route('logout') }}" class="dropdown-item py-0"
                                                            onclick="event.preventDefault(); this.closest('form').submit();"
                                                            style="line-height: 3">
                                                            <i class="flaticon-logout mr10"></i>
                                                            {{ __('Log Out') }}</a>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <a class="menubar ml30" href="#menu">
                                            <img src="{{ asset('theme/v1/images/mobile-dark-nav-icon.svg') }}"
                                                alt="">
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="posr">
                        <div class="mobile_menu_close_btn"><span class="far fa-times"></span></div>
                    </div>
                </div>
            </div>
            <!-- /.mobile-menu -->
            <nav id="menu" class="">
                @include('layouts.menus.navbar_mobile')
            </nav>
        </div>

        <div class="dashboard_content_wrapper">
            <div class="dashboard dashboard_wrapper pr30 pr0-xl">
                <div class="dashboard__sidebar d-none d-lg-block">
                    @include('layouts.menus.navbar_desktop')
                </div>
                <div class="dashboard__main pl0-md">
                    <div class="dashboard__content hover-bgc-color">
                        <div class="row pb20">

                            <!-- Page Heading -->
                            @isset($header)
                                <header class="col-lg-12">
                                    <div class="dashboard_title_area d-flex justify-content-between">
                                        {{ $header }}

                                        {{-- <a href="{{ url()->previous() }}"
                                            class="ud-btn btn-white mb25 me-4 px-2 py-0"><i
                                                class="fa-regular fa-circle-left me-2"
                                                style="transform: rotate(0deg);"></i>Back
                                        </a> --}}
                                    </div>
                                </header>
                            @endisset
                        </div>

                        <!-- Page Content -->
                        <main>
                            {{ $slot }}
                        </main>

                    </div>
                    <footer class="dashboard_footer pt30 pb30">
                        <div class="container">
                            <div class="row align-items-center justify-content-center justify-content-md-end">
                                <div class="col-auto">
                                    <div class="copyright-widget">
                                        <p class="mb-md-0">© Gen Z Travels, 2026. All rights reserved.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </footer>
                </div>
            </div>
        </div>
        <a class="scrollToHome" href="#"><i class="fas fa-angle-up"></i></a>
    </div>
    <!-- Wrapper End -->
    <script src="{{ asset('theme/v1/js/jquery-3.6.4.min.js') }}"></script>
    <script src="{{ asset('theme/v1/js/jquery-migrate-3.0.0.min.js') }}"></script>
    <script src="{{ asset('theme/v1/js/popper.min.js') }}"></script>
    <script src="{{ asset('theme/v1/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('theme/v1/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('theme/v1/js/jquery.mmenu.all.js') }}"></script>
    <script src="{{ asset('theme/v1/js/ace-responsive-menu.js') }}"></script>
    {{-- <script src="{{ asset('theme/v1/js/chart.min.js') }}"></script>
    <script src="{{ asset('theme/v1/js/chart-custome.js') }}"></script> --}}
    <script src="{{ asset('theme/v1/js/jquery-scrolltofixed-min.js') }}"></script>
    <script src="{{ asset('theme/v1/js/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('theme/v1/js/datatables.js') }}"></script>
    <script src="{{ asset('theme/v1/js/isotop.js') }}"></script>
    <!-- moment and daterangepicker (CDN) -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <!-- showAlert function -->
    <script>
        function showAlert(icon, title, message) {
            Swal.fire({
                toast: true,
                position: "top-end",
                icon: icon,
                title: title,
                text: message,
                timer: 3000,
                showConfirmButton: false
            });
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.body.addEventListener('click', async (e) => {
                const trigger = e.target.closest('[data-confirm]');
                if (!trigger) return;

                const form = trigger.closest('form');
                const missingFields = [];

                // Validate required fields and collect missing field names
                if (form) {
                    form.querySelectorAll('[required]').forEach(input => {
                        if (!input.value.trim()) {
                            const label = form.querySelector(`label[for="${input.id}"]`);
                            const name = label ? label.innerText : input.name ||
                                'Unnamed field';
                            missingFields.push(name);
                            input.classList.add('is-invalid'); // optional styling
                        } else {
                            input.classList.remove('is-invalid');
                        }
                    });

                    if (missingFields.length > 0) {
                        return Swal.fire({
                            icon: 'error',
                            title: 'Missing Required Fields',
                            html: `
                            <div style="text-align:center;">
                                <ul style="list-style:none;padding:0;margin:0;font-size:1rem">
                                    ${missingFields.map(name => `
                                                <li style="margin-bottom:5px;">
                                                    <span style="
                                                        display: inline-block;
                                                        width: 10px;
                                                        height: 10px;
                                                        background-color: #e3342f;
                                                        border-radius: 50%;
                                                        margin-right: 5px;
                                                    "></span>
                                                    <span style="color:brown;">${name} is required.</span>
                                                </li>
                                            `).join('')}
                                </ul>
                            </div>
                        `,
                            confirmButtonText: 'OK'
                        });
                    }
                }

                e.preventDefault(); // Prevent default if confirmation is needed

                // Confirmation options
                const options = {
                    title: trigger.dataset.confirmTitle || 'Are you sure?',
                    text: trigger.dataset.confirmText || 'This action cannot be undone.',
                    icon: trigger.dataset.confirmIcon || 'warning',
                    confirmButtonText: trigger.dataset.confirmButton || 'Yes',
                    cancelButtonText: trigger.dataset.cancelButton || 'Cancel',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6'
                };

                const result = await Swal.fire(options);

                if (!result.isConfirmed) return;

                // Action
                if (form) return form.submit();
                if (trigger.href) return window.location.href = trigger.href;
                const action = trigger.dataset.confirmAction;
                if (action && typeof window[action] === 'function') return window[action](trigger);
            });
        });
    </script>

    <script>
        // Print helper: clones the content of the element with the given id into a new window and prints it.
        function printElement(printableId) {
            const el = document.getElementById(printableId);
            if (!el) return alert('Printable area not found');

            // Collect stylesheet links to preserve styles in print window
            const links = Array.from(document.querySelectorAll('link[rel="stylesheet"]')).map(l => l.href);

            const html =
                `<!doctype html><html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">${links.map(h=>`<link rel="stylesheet" href="${h}">`).join('')}</head><body>${el.outerHTML}</body></html>`;

            const w = window.open('', '_blank');
            if (!w) return alert('Unable to open print window. Please allow popups.');
            w.document.open();
            w.document.write(html);
            w.document.close();

            // Give the browser a moment to load styles before printing
            w.focus();
            setTimeout(() => {
                w.print();
                // optionally close after printing
                // w.close();
            }, 500);
        }
    </script>

    <script>
        window.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('input[type="checkbox"].reset-on-load').forEach(function(checkbox) {
                checkbox.checked = false;
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            var table = $('#recordDataTableOne').DataTable({
                "paging": false,
                "searching": true,
                "ordering": true,
                "info": true, // Show table info like "Showing 1 to 10 of 50 entries"

                // Enable extensions
                "dom": '<"middle"Bf><"bottom"r>t<"bottom"ip>', // Buttons, filtering, table, pagination, info
                "lengthMenu": [10, 25, 50, 100, 200],
                "buttons": [
                    'colvis', // Column visibility toggle
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
                "colReorder": true,
                // "fixedHeader": true,
                "responsive": true,
                "rowReorder": true,
                "columnDefs": [{
                        "responsivePriority": 1,
                        "targets": 0
                    },
                    {
                        "responsivePriority": 2,
                        "targets": -1
                    },
                    {
                        "targets": -1,
                        "visible": true,
                        "orderable": false
                    }
                ],

                // Language settings
                "language": {
                    "lengthMenu": "Show _MENU_ entries",
                    "zeroRecords": "No matching records found",
                    "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                    "infoEmpty": "Showing 0 to 0 of 0 entries",
                    "infoFiltered": "(filtered from _MAX_ total entries)"
                }
            });
        });

        /**
         * HOW TO USE THIS (recordDataTableTwo) TABLE:
         * Add any of the following data-attributes to your <table> tag to override defaults:
         * data-paging="true/false"      -> Enable/Disable pagination (Default: false)
         * data-searching="true/false"   -> Enable/Disable search box (Default: false)
         * data-ordering="true/false"    -> Enable/Disable column sorting (Default: true)
         * data-info="true/false"        -> Enable/Disable "Showing X of Y" text (Default: true)
         * data-responsive="true/false"  -> Enable/Disable mobile responsiveness (Default: true)
         * data-col-reorder="true/false" -> Enable/Disable column dragging (Default: true)
         * data-row-reorder="true/false" -> Enable/Disable row dragging (Default: true)
         * data-buttons="false"          -> Hide ALL export buttons
         */

        $(document).ready(function() {
            $('.recordDataTableTwo').each(function() {
                var $table = $(this);

                // Prevent double initialization if the script runs twice
                if ($.fn.dataTable.isDataTable($table)) return;

                // 1. Helper for simple Boolean toggles
                var getCfg = function(attr, def) {
                    var val = $table.attr('data-' + attr);
                    if (val === undefined) return def;
                    return val.toLowerCase() === 'true';
                };

                // 2. Button Show/Hide Logic (Simplified)
                // Default is true. If data-buttons="false", it hides them.
                var showButtons = getCfg('buttons', true);
                
                // var defaultButtons = ['copy', 'csv', 'excel', 'pdf', 'print'];
                var defaultButtons = [
                    'copy',
                    'csv',
                    'excel',
                    {
                        extend: 'pdfHtml5',
                        orientation: 'portrait',
                        pageSize: 'A4',
                        exportOptions: {
                            columns: ':visible' // Important: only export what fits on screen
                        },
                        customize: function(doc) {
                            // 1. Safety check: ensure table exists in the doc
                            if (doc.content[1] && doc.content[1].table) {
                                // Force columns to fit within the Portrait page width
                                doc.content[1].table.widths = Array(doc.content[1].table.body[0]
                                    .length).fill('*');
                            }

                            // 2. Set Global Styles (This avoids the "undefined" error)
                            doc.defaultStyle = {
                                fontSize: 9,
                                alignment: 'center'
                            };

                            // 3. Target the Header specifically (This one is usually always defined)
                            if (doc.styles.tableHeader) {
                                doc.styles.tableHeader.fontSize = 10;
                                doc.styles.tableHeader.bold = true;
                                doc.styles.tableHeader.fillColor = '#222d61';
                                doc.styles.tableHeader.color = 'white';
                                doc.styles.tableHeader.margin = [2, 5, 2, 5];
                            }

                            // 4. Force the first column (The Month/Label) to align left
                            // We loop through the body rows and set alignment for the first cell
                            if (doc.content[1] && doc.content[1].table) {
                                var rowCount = doc.content[1].table.body.length;
                                for (var i = 1; i < rowCount; i++) { // Start at 1 to skip header
                                    doc.content[1].table.body[i][0].alignment = 'left';
                                }
                            }
                        }
                    },
                    'print'
                ];

                // 3. Initialize DataTable
                var table = $table.DataTable({
                    paging: getCfg('paging', false),
                    searching: getCfg('searching', false),
                    ordering: getCfg('ordering', true),
                    info: getCfg('info', true),
                    responsive: getCfg('responsive', true),
                    colReorder: getCfg('col-reorder', true),
                    rowReorder: getCfg('row-reorder', true),

                    // Toggle 'B' in DOM based on showButtons boolean
                    dom: (showButtons) ? 'Bfrtip' : 'frtip',
                    buttons: (showButtons) ? defaultButtons : [],

                    columnDefs: [{
                            responsivePriority: 1,
                            targets: 0
                        },
                        {
                            responsivePriority: 2,
                            targets: -1
                        },
                        {
                            targets: -1,
                            orderable: false
                        }
                    ],
                    language: {
                        lengthMenu: "Show _MENU_ entries",
                        zeroRecords: "No matching records found",
                        info: "Showing _START_ to _END_ of _TOTAL_ entries",
                        infoEmpty: "Showing 0 to 0 of 0 entries",
                        infoFiltered: "(filtered from _MAX_ total entries)"
                    }
                });

                // 4. Handle Button Placement (Scoped to this specific table's container)
                var $btnTarget = $table.closest('.ps-widget').find('.datatable-buttons');

                if (showButtons && $btnTarget.length) {
                    $btnTarget.empty(); // Clear previous buttons to avoid duplication
                    table.buttons().container().appendTo($btnTarget);
                }
            });
        });

        // $(document).ready(function() {
        //     $('.recordDataTableTwo').each(function() {
        //         var $table = $(this);

        //         // Helper function to get data attribute or return a default value
        //         // Usage: getCfg('option-name', defaultValue)
        //         var getCfg = function(attr, def) {
        //             var val = $table.attr('data-' + attr);
        //             if (val === undefined) return def;
        //             return val === 'true'; // Converts string "true"/"false" to boolean
        //         };

        //         // Initialize DataTable with dynamic overrides
        //         var table = $table.DataTable({
        //             paging: getCfg('paging', false), // Default: false
        //             searching: getCfg('searching', false), // Default: false
        //             ordering: getCfg('ordering', true), // Default: true
        //             info: getCfg('info', true), // Default: true
        //             responsive: getCfg('responsive', true), // Default: true
        //             colReorder: getCfg('col-reorder', true), // Default: true
        //             rowReorder: getCfg('row-reorder', true), // Default: true
        //             dom: 'Bfrtip',
        //             buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
        //             columnDefs: [{
        //                     responsivePriority: 1,
        //                     targets: 0
        //                 },
        //                 {
        //                     responsivePriority: 2,
        //                     targets: -1
        //                 },
        //                 {
        //                     targets: -1,
        //                     visible: true,
        //                     orderable: false
        //                 }
        //             ],
        //             language: {
        //                 lengthMenu: "Show _MENU_ entries",
        //                 zeroRecords: "No matching records found",
        //                 info: "Showing _START_ to _END_ of _TOTAL_ entries",
        //                 infoEmpty: "Showing 0 to 0 of 0 entries",
        //                 infoFiltered: "(filtered from _MAX_ total entries)"
        //             }
        //         });

        //         // Move buttons
        //         table.buttons().container().appendTo(
        //             $table.closest('.ps-widget').find('.datatable-buttons')
        //         );
        //     });
        // });

        // $(document).ready(function() {
        //     $('.recordDataTableTwo').each(function() {
        //         var $table = $(this);

        //         // Check if data-ordering="false" is explicitly set on the table element
        //         // If not present, it defaults to true
        //         var isOrderingDisabled = $table.attr('data-ordering') === 'false';

        //         // Initialize DataTable
        //         var table = $table.DataTable({
        //             paging: false,
        //             searching: false,
        //             ordering: !isOrderingDisabled, // If isOrderingDisabled is true, ordering becomes false
        //             info: true,
        //             dom: 'Bfrtip', // buttons will be moved manually
        //             buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
        //             colReorder: true,
        //             responsive: true,
        //             rowReorder: true,
        //             columnDefs: [{
        //                     responsivePriority: 1,
        //                     targets: 0
        //                 },
        //                 {
        //                     responsivePriority: 2,
        //                     targets: -1
        //                 },
        //                 {
        //                     targets: -1,
        //                     visible: true,
        //                     orderable: false
        //                 }
        //             ],
        //             language: {
        //                 lengthMenu: "Show _MENU_ entries",
        //                 zeroRecords: "No matching records found",
        //                 info: "Showing _START_ to _END_ of _TOTAL_ entries",
        //                 infoEmpty: "Showing 0 to 0 of 0 entries",
        //                 infoFiltered: "(filtered from _MAX_ total entries)"
        //             }
        //         });

        //         // Move buttons to the header placeholder
        //         table.buttons().container().appendTo(
        //             $table.closest('.ps-widget').find('.datatable-buttons')
        //         );
        //     });
        // });
    </script>

    <script>
        $(document).ready(function() {
            var $dateFields = $('.daterangepicker-field');

            if ($dateFields.length > 0) {
                $dateFields.each(function() {
                    var $this = $(this);

                    // Support multiple input formats (MM/DD/YYYY and YYYY-MM-DD)
                    var startDate, endDate;
                    if ($this.data('start')) {
                        var ds = $this.data('start');
                        var de = $this.data('end');
                        // Try strict parse with common formats, then fallback to lenient parse
                        startDate = moment(ds, ['MM/DD/YYYY', 'YYYY-MM-DD'], true);
                        if (!startDate.isValid()) {
                            startDate = moment(ds);
                        }
                        endDate = moment(de, ['MM/DD/YYYY', 'YYYY-MM-DD'], true);
                        if (!endDate.isValid()) {
                            endDate = moment(de);
                        }
                        // Final fallback
                        if (!startDate.isValid()) startDate = moment().startOf('month');
                        if (!endDate.isValid()) endDate = moment();
                    } else {
                        startDate = moment().startOf('month');
                        endDate = moment();
                    }

                    function updateDisplay(start, end) {
                        $this.val(start.format('MMM DD, YYYY') + ' - ' + end.format('MMM DD, YYYY'));
                    }

                    $this.daterangepicker({
                        showDropdowns: true,
                        showWeekNumbers: true,
                        alwaysShowCalendars: true,
                        startDate: startDate,
                        endDate: endDate,
                        ranges: {
                            'Today': [moment(), moment()],
                            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1,
                                'days')],
                            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                            'This Month': [moment().startOf('month'), moment().endOf('month')],
                            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment()
                                .subtract(1, 'month').endOf('month')
                            ],
                            'Lifetime': [moment('2000-01-01'), moment()]
                        },
                        locale: {
                            format: 'MM/DD/YYYY' // Keep this for internal use
                        }
                    }, function(start, end, label) {
                        updateDisplay(start, end);
                        console.log(
                            'New date range selected for',
                            $this.attr('name') || 'element', ':',
                            start.format('YYYY-MM-DD'), 'to', end.format('YYYY-MM-DD'),
                            '(predefined range:', label + ')'
                        );
                    });

                    // Set initial display value
                    updateDisplay(startDate, endDate);
                });
            }
        });
    </script>

    <!-- Script loading -->
    @isset($script)
        {{ $script }}
    @endisset

    <!-- Allow views to push additional scripts -->
    @stack('scripts')


    <!-- Dashboard Script -->
    <script src="{{ asset('theme/v1/js/dashboard-script.js') }}"></script>

    <!-- Custom script for all pages -->
    <x-toast-alert />
    <script src="{{ asset('theme/v1/js/script.js') }}"></script>
</body>

</html>
