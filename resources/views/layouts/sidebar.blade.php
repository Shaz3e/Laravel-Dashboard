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
                            <a href="{{ URL::to('profile?tab=kyc') }}"
                                class="nav-link {{ request()->is('profile') && $_GET['tab'] == 'kyc' ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>KYC</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ URL::to('profile?tab=security') }}"
                                class="nav-link {{ request()->is('profile') && $_GET['tab'] == 'security' ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Change Password</p>
                            </a>
                        </li>
                        {{-- Agent Account --}}
                        <li class="nav-item">
                            <a href="{{ route('profile.agent.account') }}"
                                class="nav-link {{ request()->is('profile/agent-account/*') || request()->is('profile/agent-account') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Agent Account Password</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Wallet --}}
                <li class="nav-item">
                    <a href="{{ URL::to('wallet') }}"
                        class="nav-link {{ request()->is('wallet/*') || request()->is('wallet') ? 'active' : '' }}">
                        <i class="nav-icon fa fa-wallet"></i>
                        <p>Wallet</p>
                    </a>
                </li>

                {{-- Deposit / Withdraw --}}
                <li class="nav-item {{ request()->is('deposit-withdraw/*') ? 'menu-open' : '' }}">
                    <a href="javascript:void(0)"
                        class="nav-link {{ request()->is('deposit-withdraw/*') ? 'active' : '' }}">
                        <i class="nav-icon fa-solid fa-piggy-bank"></i>
                        <p>Deposit / Withdraw
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        {{-- <li class="nav-item">
                            <a href="{{ URL::to('deposit-withdraw/wallet-ledger') }}"
                                class="nav-link {{ request()->is('deposit-withdraw/wallet-ledger') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Wallet Ledger</p>
                            </a>
                        </li> --}}
                        <li class="nav-item">
                            <a href="{{ URL::to('deposit-withdraw/deposit-fund') }}"
                                class="nav-link {{ request()->is('deposit-withdraw/deposit-fund') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Deposit Fund</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ URL::to('deposit-withdraw/withdraw-fund') }}"
                                class="nav-link {{ request()->is('deposit-withdraw/withdraw-fund') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Withdraw Fund</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Internal Transfers --}}
                <li class="nav-item {{ request()->is('internal-transfer/*') ? 'menu-open' : '' }}">
                    <a href="javascript:void(0)" class="nav-link">
                        <i class="nav-icon fa-solid fa-money-bill-transfer"></i>
                        <p>Internal Transfers
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        {{-- <li class="nav-item">
                            <a href="{{ URL::to('internal-transfer/transfer-history') }}"
                                class="nav-link {{ request()->is('internal-transfer/transfer-history') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Transfer History</p>
                            </a>
                        </li> --}}
                        <li class="nav-item">
                            <a href="{{ URL::to('internal-transfer/wallet-to-mt5') }}"
                                class="nav-link {{ request()->is('internal-transfer/wallet-to-mt5') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Wallet to MT5 Account</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ URL::to('internal-transfer/mt5-to-wallet') }}"
                                class="nav-link {{ request()->is('internal-transfer/mt5-to-wallet') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>MT5 Account to Wallet</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Operational History --}}
                <li class="nav-item {{ request()->is('operational-history/*') ? 'menu-open' : '' }}">
                    <a href="javascript:void(0)" class="nav-link">
                        <i class="nav-icon fa-solid fa-list-check"></i>
                        <p>Operational History
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ URL::to('operational-history/deposit-history') }}"
                                class="nav-link {{ request()->is('operational-history/deposit-history') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Deposit History</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ URL::to('operational-history/withdraw-history') }}"
                                class="nav-link {{ request()->is('operational-history/withdraw-history') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Withdrawal History</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ URL::to('operational-history/wallet-history') }}"
                                class="nav-link {{ request()->is('operational-history/wallet-history') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Wallet History</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ URL::to('operational-history/transfer-history') }}"
                                class="nav-link {{ request()->is('operational-history/transfer-history') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Transfer History</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Trading Accounts --}}
                <li
                    class="nav-item {{ request()->is('trading-accounts/*') || request()->is('trading-accounts') ? 'menu-open' : '' }}">
                    <a href="javascript:void(0)"
                        class="nav-link {{ request()->is('trading-accounts') ? 'active' : '' }}">
                        <i class="nav-icon fa-solid fa-money-bill-transfer"></i>
                        <p>Trading Accounts
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ URL::to('trading-accounts/') }}"
                                class="nav-link {{ request()->is('trading-accounts') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Account List</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ URL::to('trading-accounts/create') }}"
                                class="nav-link {{ request()->is('trading-accounts/create') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Open New MT5 Account</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Referrals --}}
                <li
                    class="nav-item {{ request()->is('referrals/*') || request()->is('referrals') ? 'menu-open' : '' }}">
                    <a href="javascript:void(0)"
                        class="nav-link {{ request()->is('referrals/*') || request()->is('referrals') ? 'active' : '' }}">
                        <i class="fa fa-tree nav-icon"></i>
                        <p>
                            Referrals
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ URL::to('referrals/commission-details') }}"
                                class="nav-link {{ request()->is('referrals/commission-details/*') || request()->is('referrals/commission-details') ? 'active' : '' }}">
                                {{-- <i class="nav-icon fa fa-share"></i> --}}
                                <i class="far fa-circle nav-icon"></i>
                                <p>Commission Details</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ URL::to('referrals/tree') }}"
                                class="nav-link {{ request()->is('referrals/tree') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Tree</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ URL::to('referrals/comission') }}"
                                class="nav-link {{ request()->is('referrals/comission') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Comission</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ URL::to('referrals/commission-ledger') }}"
                                class="nav-link {{ request()->is('referrals/commission-ledger/*') || request()->is('referrals/commission-ledger') ? 'active' : '' }}">
                                {{-- <i class="nav-icon fa fa-share"></i> --}}
                                <i class="far fa-circle nav-icon"></i>
                                <p>Commission Ledger</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Refer Friend --}}
                <li class="nav-item">
                    <a href="{{ URL::to('refer-friend') }}"
                        class="nav-link {{ request()->is('refer-friend/*') || request()->is('refer-friend') ? 'active' : '' }}">
                        {{-- <i class="nav-icon fa fa-share"></i> --}}
                        <i class="nav-icon fa fa-user-group"></i>
                        <p>Refer A Friend</p>
                    </a>
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

                {{-- Online Chat --}}
                {{-- <li class="nav-item">
                    <a href="javascript:void(0)" class="nav-link">
                        <i class="nav-icon fa-solid fa-headset"></i>
                        <p>Online Chat
                        </p>
                    </a>
                </li> --}}

                {{-- Web Trader --}}
                <li class="nav-item">
                    <a href="{{ URL::to('web-trader') }}"
                        class="nav-link {{ request()->is('web-trader/*') || request()->is('web-trader') ? 'active' : '' }}">
                        <i class="nav-icon fa-solid fa-window-restore"></i>
                        <p>Web Trader
                        </p>
                    </a>
                </li>

                {{-- Downloads --}}
                <li class="nav-item">
                    <a href="{{ URL::to('downloads') }}"
                        class="nav-link {{ request()->is('downloads/*') || request()->is('downloads') ? 'active' : '' }}">
                        <i class="nav-icon fa-solid fa-window-restore"></i>
                        <p>Downloads
                        </p>
                    </a>
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
