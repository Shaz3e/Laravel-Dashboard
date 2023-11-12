<!-- Main Sidebar Container -->
<aside class="main-sidebar elevation-4">

    <!-- Brand Logo -->
    <a href="{{ DiligentCreators('dashboard_url') == null ? config('app.url') : DiligentCreators('dashboard_url') }}{{ Auth::guard('admin')->user() ? '/admin' : '' }}"
        class="brand-link">
        <img src="{{ asset('/') }}{{ DiligentCreators('logo_small') }}"
            alt="{{ DiligentCreators('site_name') == null ? config('app.name') : DiligentCreators('site_name') }}"
            class="brand-image" style="opacity: .8">
        <span
            class="brand-text text font-weight-light">{{ DiligentCreators('site_name') == null ? config('app.name') : DiligentCreators('site_name') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('avatars/avatar.jpg') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="{{ URL::to('admin/profile') }}"
                    class="d-block text-theme">{{ Auth::guard('admin')->user()->name }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul id="sidebarNav" class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">

                {{-- Profile --}}
                <li class="nav-item">
                    <a href="{{ URL::to('admin') }}"
                        class="nav-link {{ request()->is('admin') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dasbhaord</p>
                    </a>
                </li>

                {{-- Profile --}}
                <li class="nav-item">
                    <a href="{{ URL::to('admin/profile') }}"
                        class="nav-link {{ request()->is('admin/profile/*') || request()->is('admin/profile') ? 'active' : '' }}">
                        <i class="nav-icon fa fa-user"></i>
                        <p>Profile</p>
                    </a>
                </li>

                {{-- Clients --}}

                <li class="nav-item">
                    <a href="{{ URL::to('admin/clients') }}"
                        class="nav-link {{ request()->is('admin/clients/*') || request()->is('admin/clients') ? 'active' : '' }}">
                        <i class="fa fa-users nav-icon"></i>
                        <p>Clients</p>
                    </a>
                </li>

                {{-- Support Ticket --}}
                <li class="nav-item {{ request()->is('admin/support-tickets/*') || request()->is('admin/support-tickets') ? 'menu-open' : '' }}">
                    <a href="javascript:void(0)"
                        class="nav-link {{ request()->is('admin/support-tickets/*') || request()->is('admin/support-tickets') ? 'active' : '' }}">
                        <i class="nav-icon fa-regular fa-life-ring"></i>
                        <p>
                            Support Tickets
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.support-tickets.index') }}"
                                class="nav-link {{ request()->is('admin/support-tickets') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Support Dashboard</p>
                            </a>
                        </li>
                        <li
                            class="nav-item 
                            {{ request()->is('admin/support-tickets/manage/status/*') || request()->is('admin/support-tickets/manage/status') ? 'menu-open' : '' }}
                            {{ request()->is('admin/support-tickets/manage/priority/*') || request()->is('admin/support-tickets/manage/priority') ? 'menu-open' : '' }}">
                            <a href="javascript:void(0)"
                                class="nav-link 
                                    {{ request()->is('admin/support-tickets/manage/status') ? 'active' : '' }}{{ request()->is('admin/support-tickets/manage/status/*') ? 'active' : '' }}
                                    {{ request()->is('admin/support-tickets/manage/priority') ? 'active' : '' }}{{ request()->is('admin/support-tickets/manage/priority/*') ? 'active' : '' }}
                                ">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Status & Priority
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.status.index') }}"
                                        class="nav-link {{ request()->is('admin/support-tickets/manage/status') ? 'active' : '' }}{{ request()->is('admin/support-tickets/manage/status/*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Manage Ticket Status</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.priority.index') }}"
                                        class="nav-link {{ request()->is('admin/support-tickets/manage/priority') ? 'active' : '' }}{{ request()->is('admin/support-tickets/manage/priority/*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Manage Ticket Priority</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>

                {{-- Manage Users --}}
                <li
                    class="nav-item {{ request()->is('admin/manage-staff/*') || request()->is('admin/manage-staff') ? 'menu-open' : '' }}">
                    <a href="javascript:void(0)"
                        class="nav-link {{ request()->is('admin/manage-staff/*') || request()->is('admin/manage-staff') ? 'active' : '' }}">
                        <i class="fa fa-users-gear nav-icon"></i>
                        <p>Manage Staff
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ URL::to('admin/manage-staff/create') }}"
                                class="nav-link {{ request()->is('admin/manage-staff/create') ? 'active' : '' }}{{ request()->is('admin/manage-staff/create/*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Create New Staff</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ URL::to('admin/manage-staff/') }}"
                                class="nav-link {{ request()->is('admin/manage-staff') || request()->is('admin/manage-staff/*/edit') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>All Staff</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Manage Roles --}}
                <li
                    class="nav-item {{ request()->is('admin/manage-roles/*') || request()->is('admin/manage-roles') ? 'menu-open' : '' }}">
                    <a href="javascript:void(0)"
                        class="nav-link {{ request()->is('admin/manage-roles/*') || request()->is('admin/manage-roles') ? 'active' : '' }}">
                        <i class="fa fa-layer-group nav-icon"></i>
                        <p>Manage Roles
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ URL::to('admin/manage-roles/create') }}"
                                class="nav-link {{ request()->is('admin/manage-roles/create') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Create New Role</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ URL::to('admin/manage-roles/') }}"
                                class="nav-link {{ request()->is('admin/manage-roles') || request()->is('admin/manage-roles/*/edit') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>All User Roles</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- App Settings --}}
                <li class="nav-item {{ request()->is('admin/app-settings/*') ? 'menu-open' : '' }}">
                    <a href="javascript:void(0)"
                        class="nav-link {{ request()->is('admin/app-settings/*') ? 'active' : '' }}">
                        <i class="fa fa-gear nav-icon"></i>
                        <p>App Settings
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ URL::to('admin/app-settings/basic') }}"
                                class="nav-link {{ request()->is('admin/app-settings/basic') ? 'active' : '' }}{{ request()->is('admin/app-settings/basic/*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Basic Settings</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ URL::to('admin/app-settings/theme') }}"
                                class="nav-link {{ request()->is('admin/app-settings/theme') ? 'active' : '' }}{{ request()->is('admin/app-settings/theme/*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Theme Settings</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ URL::to('admin/app-settings/brand') }}"
                                class="nav-link {{ request()->is('admin/app-settings/brand') ? 'active' : '' }}{{ request()->is('admin/app-settings/brand/*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Brand Settings</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ URL::to('admin/app-settings/google-recaptcha') }}"
                                class="nav-link {{ request()->is('admin/app-settings/google-recaptcha') ? 'active' : '' }}{{ request()->is('admin/app-settings/google-recaptcha/*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Google reCaptcha</p>
                            </a>
                        </li>
                        @if (Auth::guard('admin')->user()->id == 1)
                        <li class="nav-item">
                            <a href="{{ URL::to('admin/app-settings/') }}"
                                class="nav-link {{ request()->is('admin/app-settings/') ? 'active' : '' }}{{ request()->is('admin/app-settings/*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Optimize Dashboard</p>
                            </a>
                        </li>
                        @endif
                    </ul>
                </li>

                {{-- Mail Settings --}}
                <li class="nav-item {{ request()->is('admin/mail-settings/*') ? 'menu-open' : '' }}">
                    <a href="javascript:void(0)"
                        class="nav-link {{ request()->is('admin/mail-settings/*') ? 'active' : '' }}">
                        <i class="fa fa-envelopes-bulk nav-icon"></i>
                        <p>Mail Settings
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ URL::to('admin/mail-settings/email-setup') }}"
                                class="nav-link {{ request()->is('admin/mail-settings/email-setup') ? 'active' : '' }}{{ request()->is('admin/mail-settings/email-setup/*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Email Setup</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ URL::to('admin/mail-settings/email-design') }}"
                                class="nav-link {{ request()->is('admin/mail-settings/email-design') ? 'active' : '' }}{{ request()->is('admin/mail-settings/email-design/*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Email Design</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Locations --}}
                
                <li class="nav-item {{ request()->is('admin/locations/*') ? 'menu-open' : '' }}">
                    <a href="javascript:void(0)"
                        class="nav-link {{ request()->is('admin/locations/*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-earth-asia"></i>
                        <p>Locations
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ URL::to('admin/locations/countries') }}"
                                class="nav-link {{ request()->is('admin/locations/countries') || request()->is('admin/locations/countries/*') ? 'active' : '' }}
                        {{ request()->is('admin/settiongs/locations/countries/*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Countries</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ URL::to('admin/locations/states') }}"
                                class="nav-link {{ request()->is('admin/locations/states') || request()->is('admin/locations/states/*') ? 'active' : '' }}
                            {{ request()->is('admin/settiongs/locations/states/*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>States</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ URL::to('admin/locations/cities') }}"
                                class="nav-link {{ request()->is('admin/locations/cities') || request()->is('admin/locations/cities/*') ? 'active' : '' }}
                            {{ request()->is('admin/settiongs/locations/cities/*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Cities</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Log Activity --}}
                <li class="nav-item {{ request()->is('admin/log-activity/*') ? 'menu-open' : '' }}">
                    <a href="javascript:void(0)"
                        class="nav-link {{ request()->is('admin/log-activity/*') || request()->is('admin/log-activity') ? 'active' : '' }}">
                        <i class="nav-icon fa-solid fa-file-lines"></i>
                        <p>Log Activity
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ URL::to('admin/log-activity/admin') }}"
                                class="nav-link {{ request()->is('admin/log-activity/admin') || request()->is('admin/log-activity/admin/*') ? 'active' : '' }}
                                {{ request()->is('admin/settiongs/locations/states/*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Admin Activity</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ URL::to('admin/log-activity/user') }}"
                                class="nav-link {{ request()->is('admin/log-activity/user') || request()->is('admin/log-activity/user/*') ? 'active' : '' }}
                                {{ request()->is('admin/log-activity/user/*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>User Activity</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ URL::to('admin/log-activity') }}"
                                class="nav-link {{ request()->is('admin/log-activity') || request()->is('admin/log-activity/*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>All Log Activity</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Permissions --}}
                @if (Auth::guard('admin')->user()->id == 1)
                    <li class="nav-item {{ request()->is('admin/app-permissions/*') || request()->is('admin/app-permissions') ? 'menu-open' : '' }}">
                        <a href="javascript:void(0)"
                            class="nav-link {{ request()->is('admin/app-permissions/*') || request()->is('admin/app-permissions') ? 'active' : '' }}">
                            <i class="nav-icon fa-solid fa-link"></i>
                            <p>Permissions
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ URL::to('admin/app-permissions') }}"
                                    class="nav-link {{ request()->is('admin/app-permissions') || request()->is('admin/app-permissions/*') ? 'active' : '' }}
                                    {{ request()->is('admin/settiongs/locations/states/*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Permissions</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ URL::to('admin/app-permissions/routes') }}"
                                    class="nav-link {{ request()->is('admin/app-permissions/routes') || request()->is('admin/app-permissions/routes/*') ? 'active' : '' }}
                                    {{ request()->is('admin/app-permissions/routes/*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Routes</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif

                {{-- Logout --}}
                <li class="nav-item">
                    <a href="javascript:void(0)" onclick="$('#logout-form').submit();" class="nav-link">
                        <i class="fa fa-right-from-bracket nav-icon"></i>
                        <p>Logout</p>
                    </a>
                    {{-- Logout --}}
                    <form action="{{ route('admin.logout') }}" id="logout-form" method="POST">
                        @csrf
                        @method('POST')
                    </form>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
