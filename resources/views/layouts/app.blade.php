<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Title -->
    <title>{{ DiligentCreators('site_name') }}</title>
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('/') }}{{ DiligentCreators('logo_small') }}" type="image/x-icon" />
    <!-- Font Awesome -->
    <script src="{{ asset('plugins/fontawesome-free/js/all.min.js') }}"></script>
    @yield('styles')
    @if(DiligentCreators('notification_type') == 'toastr')
    <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
    @endif
    @if(DiligentCreators('notification_type') == 'sweetalerts')
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2/sweetalert2.min.css') }}">
    @endif
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <!-- Custom style -->
    <link rel="stylesheet" href="{{ asset('dist/css/customize.css') }}">

    @if (DiligentCreators('google_recaptcha') == 1)
        <script async src="https://www.google.com/recaptcha/api.js"></script>
    @endif
</head>

<body class="hold-transition layout-fixed layout-navbar-fixed sidebar-mini @yield('body_class')">

    <!-- Site wrapper -->
    <div class="wrapper">

        <!-- Navbar -->
        <nav id="nav" class="fixed main-header navbar navbar-expand">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                        <i class="fas fa-bars"></i>
                    </a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{ DiligentCreators('dashboard_url') }}{{ Auth::guard('admin')->user() ? '/admin' : '' }}"
                        class="nav-link">
                        @if (Auth::guard('admin')->user())
                            Admin Dashboard
                        @else
                            Dashboard
                        @endif
                    </a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">

                @if (Auth::guard('admin')->user())
                    <!-- Pending Support Ticket Dropdown Menu -->
                    <li class="nav-item dropdown">
                        <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
                            <i class="fa-regular fa-life-ring"></i>
                            @if ( getTotalSupportTicketByStatus(1) >= 1)
                                <span class="badge badge-danger navbar-badge">{{ getTotalSupportTicketByStatus(1) }}</span>
                            @endif
                        </a>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                            {{ pendingSupportTickets() }}
                            <a href="{{ route('admin.support-tickets.index') }}?status=1"
                                class="dropdown-item dropdown-footer">All Open Tickets</a>
                        </div>
                    </li>

                    <!-- Login History Dropdown Menu -->
                    <li class="nav-item dropdown">
                        <a class="nav-link" data-toggle="dropdown" href="#">
                            <i class="fa-solid fa-users"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                            {{ userLoginHistory() }}
                        </div>
                    </li>

                    <!-- User Log Activity Dropdown Menu -->
                    <li class="nav-item dropdown">
                        <a class="nav-link" data-toggle="dropdown" href="#">
                            <i class="fa-solid fa-clock-rotate-left"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                            {{ userLogActivity() }}
                            <div class="dropdown-divider"></div>
                            <a href="/admin/log-activity/user" class="dropdown-item dropdown-footer">See All User
                                Activity</a>
                        </div>
                    </li>
                @endif

                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" role="button">
                        <i class="fa-solid fa-expand"></i>
                    </a>
                </li>
                @if (DiligentCreators('theme_settings_is_active') == 1)
                <li class="nav-item">
                    <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                        <i class="fa-solid fa-window-restore"></i>
                    </a>
                </li>
                @endif
            </ul>
        </nav>
        <!-- /.navbar -->


        {{-- Sidebar --}}
        @if (request()->is('admin') || request()->is('admin/*'))
            @include('layouts.admin-sidebar')
        @else
            @include('layouts.sidebar')
        @endif
        {{-- Sidebar --}}


        {{-- Content --}}
        @yield('content')
        {{-- Content --}}


        {{-- Footer --}}
        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
                <b>Version</b> 2.0
            </div>
            <strong>
                Copyright &copy; {{ now()->year }}
                <a href="{{ DiligentCreators('site_url') }}" class="text-theme" target="_blank">
                    {{ DiligentCreators('site_name') }}
                </a>.
            </strong> All rights reserved.
        </footer>
        {{-- Footer --}}


        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark"></aside>
        <!-- /.control-sidebar -->

    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
    <!-- Theme Settings -->
    <script src="{{ asset('dist/js/theme-setting.js') }}"></script>
    <script>
        // Apply All Settings
        ApplyAllSettings();

        function ApplyAllSettings() {
            ShowThemeColor();
            // Mode
            ApplyDarkMode();
            // Sidebar Collapsed
            ApplySettings('Sidebar-Collapsed', "#sideBarCollapsedSettingsCheck", "body", 'sidebar-collapse');
            // Sidebar No Expand On Hover
            ApplySettings('Sidebar-No-Expand', "#sideBarNoExpandSettingsCheck", ".main-sidebar", 'sidebar-no-expand');
            // Nav Flat Style
            ApplySettings('Nav-Flat', "#navFlatSettingsCheck", ".nav-sidebar", 'nav-flat');
            // Nav Legacy Style
            ApplySettings('Nav-Legacy', "#navLegacySettingsCheck", ".nav-sidebar", 'nav-legacy');
            // Nav Compact Style
            ApplySettings('Nav-Compact', "#navCompactSettingsCheck", ".nav-sidebar", 'nav-compact');
            // Nav Indent Style
            ApplySettings('Nav-Child-Indent', "#navChildIndentSettingsCheck", ".nav-sidebar", 'nav-child-indent');
            // Nav Collapse Hide Child Style
            ApplySettings('Nav-Child-Hide-On-Collapse', "#navCollapseHideChildSettingsCheck", ".nav-sidebar",
                'nav-collapse-hide-child');
            // Footer Fixed Style
            ApplySettings('Sidebar-Footer-Fixed', "#sideBarFooterFixedSettingsCheck", "body", 'layout-footer-fixed');
            // Body Text Style
            ApplySettings('Body-Small-Text', "#bodyTextSettingsCheck", "body", 'text-sm');
        }



        // Save Settings
        function SaveSettings(settingName, settingValue) {
            localStorage.setItem(settingName, settingValue);
            // Apply All Settings
            ApplyAllSettings();
        }



        // Dark Mode
        function ApplyDarkMode() {

            // Get Setting
            let settingName = localStorage.getItem('Dark-Mode');

            // Elements
            let checkElement = $("#darkModeSettingsCheck"); // Checkbox
            let settingApplyElement = $("body"); // Body
            let settingApplyElement2 = $("#nav"); // Nav

            // Clear Settings
            settingApplyElement2.removeClass('navbar-white navbar-light navbar-dark'); // Nav

            // Apply Settings
            if (settingName == 0) {
                checkElement.removeAttr("checked"); // Remove Check
                settingApplyElement.removeClass('dark-mode'); // Body
                settingApplyElement2.addClass('navbar-white navbar-light'); // Nav
            } else if (settingName == 1) {
                checkElement.attr("checked", true); // Checked
                settingApplyElement.addClass('dark-mode'); // Body
                settingApplyElement2.addClass('navbar-dark'); // Nav
            } else if (settingName == null) {
                if ("{{ DiligentCreators('dark_mode') }}" == 1) {
                    checkElement.attr("checked", true); // Checked
                    settingApplyElement.addClass('dark-mode'); // Body
                    settingApplyElement2.addClass('navbar-dark'); // Nav
                } else {
                    checkElement.removeAttr("checked"); // Remove Check
                    settingApplyElement.removeClass('dark-mode'); // Body
                    settingApplyElement2.addClass('navbar-white navbar-light'); // Nav
                }
            }
        }



        // Theme Color
        function ShowThemeColor() {

            let themeColor = localStorage.getItem('Theme-Color');
            let themeMode = localStorage.getItem('Dark-Mode');

            if (themeMode == null) {
                if ("{{ DiligentCreators('dark_mode') }}" == 1) {
                    themeMode = "dark";
                } else {
                    themeMode = "light";
                }
            } else {
                if (themeMode == 1) {
                    themeMode = "dark";
                } else {
                    themeMode = "light";
                }
            }
            let themeColorSelect = $("#themeColorSettingsSelect");
            let sidebar = $(".main-sidebar");

            if (themeColor == null) {
                themeColor = "{{ DiligentCreators('theme_color') }}";
            }
            themeColorSelect.removeClass(
                'bg-white bg-danger bg-fuchsia bg-indigo bg-info bg-lightblue bg-lime bg-maroon bg-navy bg-orange bg-olive bg-pink bg-primary bg-purple bg-success bg-teal bg-warning'
            );
            $("#themeColorSettingsSelect option").each(function() {
                $(this).removeAttr("selected");
                if ($(this).val() == themeColor) {
                    $(this).attr("selected", true);
                    themeColorSelect.css({
                        "background": `var(--${themeColor})`,
                        "color": '#fff',
                    });
                }
            });

            sidebar.removeClass(
                'sidebar-dark-white sidebar-dark-danger sidebar-dark-fuchsia sidebar-dark-indigo sidebar-dark-info sidebar-dark-lightblue sidebar-dark-lime sidebar-dark-maroon sidebar-dark-navy sidebar-dark-orange sidebar-dark-olive sidebar-dark-pink sidebar-dark-primary sidebar-dark-purple sidebar-dark-success sidebar-dark-teal sidebar-dark-warning sidebar-light-white sidebar-light-danger sidebar-light-fuchsia sidebar-light-indigo sidebar-light-info sidebar-light-lightblue sidebar-light-lime sidebar-light-maroon sidebar-light-navy sidebar-light-orange sidebar-light-olive sidebar-light-pink sidebar-light-primary sidebar-light-purple sidebar-light-success sidebar-light-teal sidebar-light-warning'
            );
            sidebar.addClass(`sidebar-${themeMode}-${themeColor}`);

            $(":root").css("--themeColor", `var(--${themeColor})`);

            $(".text-theme").css({
                "color": `var(--${themeColor})`
            });

            $("button[type=submit], .btn-theme").css({
                "background": `var(--${themeColor})`,
                "border-color": `var(--${themeColor})`,
                "color": '#fff',
            });

            $(".text-theme").css({
                "color": `var(--${themeColor})`
            });

            $(".bg-theme").css({
                "background": `var(--${themeColor})`
            });

            $(".breadcrumb-item a").css({
                "color": `var(--${themeColor})`
            });

            $(".breadcrumb-item a").css({
                "color": `var(--${themeColor})`
            });


        }

        function ApplyThemeColor(themeColor) {
            if (themeColor != "") {
                localStorage.setItem('Theme-Color', themeColor);
            } else {
                localStorage.setItem('Theme-Color', "{{ DiligentCreators('theme_color') }}");
            }
            ShowThemeColor();
        }


        // Apply Nav Settings
        function ApplySettings(getSettingName, getCheckElement, getSettingApplyElement, getSettingApplyClass) {

            // Get Setting
            let settingName = localStorage.getItem(`${getSettingName}`);

            // Elements
            let checkElement = $(`${getCheckElement}`); // Checkbox
            let settingApplyElement = $(`${getSettingApplyElement}`); // Sidebar Nav

            // Apply Settings
            if (settingName == null || settingName == 0) {
                checkElement.removeAttr("checked"); // Remove Check
                settingApplyElement.removeClass(`${getSettingApplyClass}`); // Sidebar Nav
            } else {
                checkElement.attr("checked", true); // Checked
                settingApplyElement.addClass(`${getSettingApplyClass}`); // Sidebar Nav
            }
        }


        // Autocomplete Off
        $(document).ready(function() {
            $('input').attr('autocomplete', 'false');
        });
    </script>
    {{-- <script src="{{ asset('dist/js/customize.js') }}"></script> --}}
    {{-- Theme Setting --}}

    @if(DiligentCreators('notification_type') == 'toastr')
        <script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
        <script>
            // do not auto format code
            toastr.options = {
                "closeButton": {{ DiligentCreators('toastr_notification_close_button') }},
                "positionClass": "toast-{{ DiligentCreators('toastr_notification_position_class') }}",
                "newestOnTop": true,
                "timeOut": "{{ DiligentCreators('toastr_notification_time_out') }}",
                "progressBar": {{ DiligentCreators('toastr_notification_progress_bar') }},
            }
        </script>
        @if (Session::has('message'))
            <script>
                toastr.success("{{ session('message')['text'] }}");
            </script>
        @endif
        @if (Session::has('error'))
            <script>
                toastr.error("{{ session('error')['text'] }}");
            </script>
        @endif
        @if (Session::has('info'))
            <script>
                toastr.info("{{ session('info')['text'] }}");
            </script>
        @endif
        @if (Session::has('warning'))
            <script>
                toastr.warning("{{ session('warning')['text'] }}");
            </script>
        @endif
    @endif
    {{-- endif notification type == toastr --}}

    @if(DiligentCreators('notification_type') == 'sweetalerts')
        <script src="{{ asset('plugins/sweetalert2/sweetalert2.all.min.js') }}"></script>
        <script>
            // do not auto format code
            const Toast = Swal.mixin({
                toast: {{ DiligentCreators('sweet_alerts_type') }},
                position: "{{ DiligentCreators('sweet_alerts_position') }}",
                timer: {{ DiligentCreators('sweet_alerts_timer') }},
                timerProgressBar: {{ DiligentCreators('sweet_alerts_timer_progress_bar') }},
                animation: {{ DiligentCreators('sweet_alerts_animation') }},
                iconColor: "{{ DiligentCreators('sweet_alerts_icon_color') }}",
                color: "{{ DiligentCreators('sweet_alerts_text_color') }}",
                background: "{{ DiligentCreators('sweet_alerts_background_color') }}",
                customClass: {
                    confirmButton: "btn btn-{{ DiligentCreators('sweet_alerts_confirm_button') }}",
                    cancelButton: "btn btn-{{ DiligentCreators('sweet_alerts_cancel_button') }}",
                    popup: "sweetalert-custom-popup-class",
                },
                buttonsStyling: false,
                showConfirmButton: {{ DiligentCreators('sweet_alerts_show_confirm_button') }},
            });
            // Add your custom CSS styles
            const customStyles = document.createElement('style');
            customStyles.innerHTML = `
                .sweetalert-custom-popup-class {
                    color: {{ DiligentCreators('sweet_alerts_text_color') }};
                }
            `;

            // Append the custom styles to the document head
            document.head.appendChild(customStyles);
        </script>
        @if (Session::has('message'))
            <script>
                Toast.fire({
                    icon: 'success',
                    text: "{{ session('message')['text'] }}",
                })
            </script>
        @endif
        @if (Session::has('error'))
            <script>
                Toast.fire({
                    icon: 'error',
                    text: "{{ session('error')['text'] }}",
                })
            </script>
        @endif
        @if (Session::has('info'))
            <script>
                Toast.fire({
                    icon: 'info',
                    text: "{{ session('info')['text'] }}",
                })
            </script>
        @endif
        @if (Session::has('warning'))
            <script>
                Toast.fire({
                    icon: 'warning',
                    text: "{{ session('warning')['text'] }}",
                })
            </script>
        @endif
    @endif
    {{-- endif notification type == sweetalerts --}}
    @yield('scripts')
</body>

</html>
