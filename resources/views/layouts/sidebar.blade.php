<!-- Main Sidebar Container -->
<aside class="main-sidebar elevation-4">

    <!-- Brand Logo -->
    <a href="{{ DiligentCreators('dashboard_url') == null ? config('app.url') : DiligentCreators('dashboard_url') }}"
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
                <a href="{{ URL::to('profile?tab=profile') }}"
                    class="d-block text-theme">{{ auth()->user()->first_name }}
                    {{ auth()->user()->last_name }}</a>
            </div>
        </div>

        @if (Auth::guard('admin')->user())
            <div class="user-panel mt-0 pb-2 mb-2">
                <div class="info  py-0 px-1">
                    <a href="{{ URL::to('admin/login-back') }}" class="d-block btn btn-primary btn-theme">
                        Login as {{ Auth::guard('admin')->user()->name }}
                    </a>
                </div>
            </div>
        @endif

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul id="sidebarNav" class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">

                {{-- Dashboard --}}
                <li class="nav-item">
                    <a href="{{ URL::to('/') }}"
                        class="nav-link {{ request()->is('/*') || request()->is('/') ? 'active' : '' }}">
                        <i class="nav-icon fa-solid fa-gauge-high"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                {{-- Profile --}}
                <li class="nav-item {{ request()->is('profile') || request()->is('profile/*') ? 'menu-open' : '' }}">
                    <a href="javascript:void(0)" class="nav-link {{ request()->is('profile') || request()->is('profile/*') ? 'active' : '' }}">
                        <i class="nav-icon fa fa-user"></i>
                        <p>Profile
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ URL::to('profile?tab=profile') }}"
                                class="nav-link {{ request()->is('profile') && $_GET['tab'] == 'profile' ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Edit Profile</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ URL::to('profile?tab=security') }}"
                                class="nav-link {{ request()->is('profile') && $_GET['tab'] == 'security' ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Change Password</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Customer Support Ticket --}}
                <li
                    class="nav-item {{ request()->is('customer-support/*') || request()->is('customer-support') ? 'menu-open' : '' }}">
                    <a href="javascript:void(0)"
                        class="nav-link {{ request()->is('customer-support/*') || request()->is('customer-support') ? 'active' : '' }}">
                        <i class="nav-icon fa-regular fa-life-ring"></i>
                        <p>
                            Customer Support
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ URL::to('customer-support/create') }}"
                                class="nav-link {{ request()->is('customer-support/create') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Submit a Ticket</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ URL::to('customer-support') }}"
                                class="nav-link {{ request()->is('customer-support') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>My Tickets</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Logout --}}
                <li class="nav-item">
                    <a href="javascript:void(0)" onclick="$('#logout-form').submit();"
                        class="nav-link {{ request()->is('logout') ? 'active' : '' }}">
                        <i class="fa fa-right-from-bracket nav-icon"></i>
                        <p>Logout</p>
                    </a>
                    {{-- Logout --}}
                    <form action="{{ route('logout') }}" id="logout-form" method="POST">
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
