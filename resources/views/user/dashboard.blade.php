@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Link Swiper's CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Dashboard</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <!-- Total Counts -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-12">
                        <!-- small box -->
                        <div class="small-box card card-outline">
                            <div class="inner">
                                <h3 class="text-theme">${{ simplifyNumber(GetDepositAmount(auth()->user()->id)) }}</h3>
                                <p>Total Deposit</p>
                            </div>
                            <div class="icon">
                                <i class="fa-solid fa-arrow-trend-down"></i>
                            </div>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-md-3 col-sm-12">
                        <!-- small box -->
                        <div class="small-box card card-outline">
                            <div class="inner">
                                <h3 class="text-theme">${{ simplifyNumber(GetWithdrawAmount(auth()->user()->id)) }}</h3>
                                <p>Total Withdraw</p>
                            </div>
                            <div class="icon">
                                <i class="fa-solid fa-arrow-trend-up"></i>
                            </div>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-md-3 col-sm-12">
                        <!-- small box -->
                        <div class="small-box card card-outline">
                            <div class="inner">
                                <h3 class="text-theme">${{ simplifyNumber(GetWalletAmount(auth()->user()->id)) }}</h3>
                                <p>Total Wallet Amount</p>
                            </div>
                            <div class="icon">
                                <i class="fa-solid fa-money-bill-transfer"></i>
                            </div>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-md-3 col-sm-12">
                        <!-- small box -->
                        <div class="small-box card card-outline">
                            <div class="inner">
                                <h3 class="text-theme">${{ simplifyNumber($mt5Wallet) }}</h3>
                                <p>MT5 Balance</p>
                            </div>
                            <div class="icon">
                                <i class="fa-solid fa-money-bill-trend-up"></i>
                            </div>
                        </div>
                    </div>
                    <!-- ./col -->
                </div>
            </div>
        </section>
        <!-- /.content -->

        <!-- Charts Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <!-- AREA CHART -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Deposits & Withdrawals</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="chart">
                                    @php
                                        // Deposit
                                        $i = 0;
                                        $depositChartData = '';
                                        foreach ($depositDataSet as $depositData) {
                                            $i = $i + 1;
                                            if ($i == 1) {
                                                $depositChartData = $depositData;
                                            } else {
                                                $depositChartData = $depositChartData . ',' . $depositData;
                                            }
                                        }
                                        // Withdraw
                                        $i = 0;
                                        $withdrawChartData = '';
                                        foreach ($withdrawDataSet as $withdrawData) {
                                            $i = $i + 1;
                                            if ($i == 1) {
                                                $withdrawChartData = $withdrawData;
                                            } else {
                                                $withdrawChartData = $withdrawChartData . ',' . $withdrawData;
                                            }
                                        }
                                    @endphp
                                    <canvas id="depositChart"
                                        style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>


                    <div class="col-md-6">
                        <!-- LINE CHART -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Internal Transfers IN/OUT</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="chart">
                                    @php
                                        // Deposit
                                        $i = 0;
                                        $internaldepositChartData = '';
                                        foreach ($internaldepositDataSet as $internaldepositData) {
                                            $i = $i + 1;
                                            if ($i == 1) {
                                                $internaldepositChartData = $internaldepositData;
                                            } else {
                                                $internaldepositChartData = $internaldepositChartData . ',' . $internaldepositData;
                                            }
                                        }
                                        // Withdraw
                                        $i = 0;
                                        $internalwithdrawChartData = '';
                                        foreach ($internalwithdrawDataSet as $internalwithdrawData) {
                                            $i = $i + 1;
                                            if ($i == 1) {
                                                $internalwithdrawChartData = $internalwithdrawData;
                                            } else {
                                                $internalwithdrawChartData = $internalwithdrawChartData . ',' . $internalwithdrawData;
                                            }
                                        }
                                    @endphp
                                    <canvas id="internalChart"
                                        style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->


        <!-- Trading Account Main content -->
        @if (auth()->user()->kyc_status_id == 3)
            <section class="content">
                <div class="container-fluid">
                    <div class="row mb-2">
                        @if ($tradingAccountdataSet->count() == 0)
                            <div class="col-md-12">
                                <div class="card card-primary mt-2" style="height: calc(100% - 15px)">
                                    <div class="card-header">
                                        <h5 class="card-title">Create New Trading Account</h5>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                                title="Collapse">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                            <button type="button" class="btn btn-tool" data-card-widget="remove"
                                                title="Remove">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <form action="{{ route('dashboard.create.trading.account') }}" method="POST"
                                            class="form-horizontal" id="tradingAccountForm">
                                            @csrf
                                            <div class="row justify-content-center">
                                                @if (DiligentCreators('mt5_account_type_is_active') == 1)
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="account_type_id">Group</label>
                                                            <select name="account_type_id"
                                                                class="form-control account_type_id" id="account_type_id"
                                                                required>
                                                                <option value="">Select Group</option>
                                                                @foreach ($tradingAccountTypeDataSet as $tradingAccountTypeData)
                                                                    <option value="{{ $tradingAccountTypeData->id }}"
                                                                        {{ $tradingAccountTypeData->id == old('account_type_id') ? 'selected' : '' }}>
                                                                        {{ $tradingAccountTypeData->account_type_name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                @else
                                                    <input type="hidden" name="account_type_id"
                                                        value="{{ DiligentCreators('mt5_account_type') }}" />
                                                @endif
                                                @if (DiligentCreators('mt5_account_leverage_is_active') == 1)
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="leverage_id">Leverage</label>
                                                            <select name="leverage_id" class="form-control leverage_id"
                                                                id="leverage_id" required>
                                                                <option value="">Select Leverage</option>
                                                                @foreach ($leverageDataSet as $leverageData)
                                                                    <option value="{{ $leverageData->name }}"
                                                                        {{ $leverageData->id == old('leverage_id') ? 'selected' : '' }}>
                                                                        {{ $leverageData->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                @else
                                                    <input type="hidden" name="leverage_id"
                                                        value="{{ DiligentCreators('mt5_account_leverage') }}" />
                                                @endif
                                            </div>
                                            <button type="submit"
                                                class="btn d-block mx-auto rounded-pill">Create</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="col-md-4">
                                <div class="card card-primary mt-2" style="height: calc(100% - 15px)">
                                    <div class="card-header">
                                        <h5 class="card-title">Create New Trading Account</h5>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                                title="Collapse">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                            <button type="button" class="btn btn-tool" data-card-widget="remove"
                                                title="Remove">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <form action="{{ route('dashboard.create.trading.account') }}" method="POST"
                                            class="form-horizontal" id="tradingAccountForm">
                                            @csrf
                                            @if (DiligentCreators('mt5_account_type_is_active') == 1)
                                                <div class="form-group">
                                                    <label for="account_type_id">Group</label>
                                                    <select name="account_type_id" class="form-control account_type_id"
                                                        id="account_type_id" required>
                                                        <option value="">Select Group</option>
                                                        @foreach ($tradingAccountTypeDataSet as $tradingAccountTypeData)
                                                            <option value="{{ $tradingAccountTypeData->id }}"
                                                                {{ $tradingAccountTypeData->id == old('account_type_id') ? 'selected' : '' }}>
                                                                {{ $tradingAccountTypeData->account_type_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            @else
                                                <input type="hidden" name="account_type_id"
                                                    value="{{ DiligentCreators('mt5_account_type') }}" />
                                            @endif
                                            @if (DiligentCreators('mt5_account_leverage_is_active') == 1)
                                                <div class="form-group">
                                                    <label for="leverage_id">Leverage</label>
                                                    <select name="leverage_id" class="form-control leverage"
                                                        id="leverage_id" required>
                                                        <option value="">Select Leverage</option>
                                                        @foreach ($leverageDataSet as $leverageData)
                                                            <option value="{{ $leverageData->name }}"
                                                                {{ $leverageData->id == old('leverage') ? 'selected' : '' }}>
                                                                {{ $leverageData->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            @else
                                                <input type="hidden" name="leverage_id"
                                                    value="{{ DiligentCreators('mt5_account_leverage') }}" />
                                            @endif
                                            <button type="submit" class="btn btn-danger w-100">Create</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <!-- /.col -->

                        @if ($tradingAccountdataSet->count() > 0)
                            <div class="col-md-8">
                                <!-- Swiper -->
                                @if ($tradingAccountdataSet->count() > 2)
                                    <div class="swiper tradingAccountsSlider mt-2" style="height: calc(100% - 15px)">
                                        <div class="swiper-wrapper">
                                            @foreach ($tradingAccountdataSet as $tradingAccountdata)
                                                <div class="swiper-slide">
                                                    <div class="card card-outline small-box m-0"
                                                        style="height: 100%">
                                                        <div class="inner">
                                                            <h3 class="text-theme"
                                                                title="Balance: ${{ simplifyNumber($tradingAccountdata->balance) }}">
                                                                ${{ simplifyNumber($tradingAccountdata->balance) }}</h3>
                                                            <p title="Account Number: #{{ $tradingAccountdata->trading_account_number }}"
                                                                class="m-0 my-1">
                                                                #{{ $tradingAccountdata->trading_account_number }}
                                                            </p>
                                                            <p title="Account Type: @foreach ($tradingAccountTypeDataSet as $accountType) {{ $accountType->account_type_name }} @endforeach"
                                                                class="m-0 my-1">
                                                                @foreach ($tradingAccountTypeDataSet as $accountType)
                                                                    {{ $accountType->account_type_name }}
                                                                @endforeach
                                                            </p>
                                                            <p title="Leverage: {{ $tradingAccountdata->leverage }}"
                                                                class="m-0 my-1">
                                                                {{ $tradingAccountdata->leverage }}</p>
                                                        </div>
                                                        <div class="icon">
                                                            <i class="ion ion-stats-bars"></i>
                                                        </div>
                                                        <a href="?account={{ $tradingAccountdata->trading_account_number }}"
                                                            class="small-box-footer py-2">
                                                            <span class="mr-1">Sync</span>
                                                            <i class="fa fa-arrows-rotate"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="autoplay-progress">
                                            <svg viewBox="0 0 48 48">
                                                <circle cx="24" cy="24" r="20"></circle>
                                            </svg>
                                            <span></span>
                                        </div>
                                    </div>
                                @elseif ($tradingAccountdataSet->count() == 2)
                                    <div class="row" style="height: 100%">
                                        @foreach ($tradingAccountdataSet as $tradingAccountdata)
                                            <div class="col-md-6 col-12">
                                                <div class="card card-outline small-box m-0 mt-2"
                                                    style="height: calc(100% - 15px)">
                                                    <div class="inner">
                                                        <h3 class="text-theme"
                                                            title="Balance: ${{ simplifyNumber($tradingAccountdata->balance) }}">
                                                            ${{ simplifyNumber($tradingAccountdata->balance) }}</h3>
                                                        <p title="Account Number: #{{ $tradingAccountdata->trading_account_number }}"
                                                            class="m-0 my-1">
                                                            #{{ $tradingAccountdata->trading_account_number }}
                                                        </p>
                                                        <p title="Account Type: @foreach ($tradingAccountTypeDataSet as $accountType) {{ $accountType->account_type_name }} @endforeach"
                                                            class="m-0 my-1">
                                                            @foreach ($tradingAccountTypeDataSet as $accountType)
                                                                {{ $accountType->account_type_name }}
                                                            @endforeach
                                                        </p>
                                                        <p title="Leverage: {{ $tradingAccountdata->leverage }}"
                                                            class="m-0 my-1">
                                                            {{ $tradingAccountdata->leverage }}</p>
                                                    </div>
                                                    <div class="icon">
                                                        <i class="ion ion-stats-bars"></i>
                                                    </div>
                                                    <a href="?account={{ $tradingAccountdata->trading_account_number }}"
                                                        class="small-box-footer py-2">
                                                        <span class="mr-1">Sync</span>
                                                        <i class="fa fa-arrows-rotate"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @elseif ($tradingAccountdataSet->count() == 1)
                                    @foreach ($tradingAccountdataSet as $tradingAccountdata)
                                        <div class="card card-outline small-box m-0 mt-2"
                                            style="height: calc(100% - 15px)">
                                            <div class="inner">
                                                <h3 class="text-theme"
                                                    title="Balance: ${{ simplifyNumber($tradingAccountdata->balance) }}">
                                                    ${{ simplifyNumber($tradingAccountdata->balance) }}</h3>
                                                <p title="Account Number: #{{ $tradingAccountdata->trading_account_number }}"
                                                    class="m-0 my-1">#{{ $tradingAccountdata->trading_account_number }}
                                                </p>
                                                <p title="Account Type: @foreach ($tradingAccountTypeDataSet as $accountType) {{ $accountType->account_type_name }} @endforeach"
                                                    class="m-0 my-1">
                                                    @foreach ($tradingAccountTypeDataSet as $accountType)
                                                        {{ $accountType->account_type_name }}
                                                    @endforeach
                                                </p>
                                                <p title="Leverage: {{ $tradingAccountdata->leverage }}"
                                                    class="m-0 my-1">
                                                    {{ $tradingAccountdata->leverage }}</p>
                                            </div>
                                            <div class="icon">
                                                <i class="ion ion-stats-bars"></i>
                                            </div>
                                            <a href="?account={{ $tradingAccountdata->trading_account_number }}"
                                                class="small-box-footer py-2">
                                                <span class="mr-1">Sync</span>
                                                <i class="fa fa-arrows-rotate"></i>
                                            </a>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <!-- /.col -->
                        @endif
                    </div>
                    <!-- /.row -->
            </section>
        @else
            <section class="content">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-md-12">
                            <div class="card card-primary mt-2" style="height: calc(100% - 15px)">
                                <div class="card-header">
                                    <h5 class="card-title">Create New Trading Account</h5>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                            title="Collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" data-card-widget="remove"
                                            title="Remove">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <p class="">Please complete your <a href="{{ URL::to('profile?tab=kyc') }}"
                                            class="text-theme text-underline">KYC</a> first.</p>
                                </div>
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
            </section>
        @endif

        <section class="content">
            <div class="container-fluid">
                <div class="card card-outline">
                    <div class="card-body">
                        <div class="copySuccess" style="display:none;">
                            <div class="alert alert-primary bg-theme">
                                Referral link is copied to clipboard
                            </div>
                        </div>
                        <div class="input-group input-group-lg">
                            <input class="form-control"
                                value="{{ DiligentCreators('dashboard_url') == null ? env('APP_URL') : DiligentCreators('dashboard_url') }}/register?ref={{ Auth::user()->id }}"
                                id="copyIBCode" disabled>
                            <span class="input-group-append">
                                <button type="button" onclick="copyToClipboard()"
                                    class="btn btn-theme btn-flat">Copy</button>
                            </span>
                        </div>
                        <div>
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ DiligentCreators('dashboard_url') == null ? env('APP_URL') : DiligentCreators('dashboard_url') . '/register?ref=' . Auth::user()->id }}"
                                class="btn btn-primary d-inline-flex justify-content-center align-items-center mt-2"
                                target="_blank">
                                <i class="fab fa-facebook-f mr-2"></i>
                                <span>Facebook</span>
                            </a>
                            <a href="https://api.whatsapp.com/send?text={{ DiligentCreators('dashboard_url') == null ? env('APP_URL') : DiligentCreators('dashboard_url') . '/register?ref=' . Auth::user()->id }}"
                                class="btn btn-success d-inline-flex justify-content-center align-items-center mt-2 ml-3"
                                target="_blank">
                                <i class="fab fa-whatsapp mr-2"></i>
                                <span>Whatsapp</span>
                            </a>
                            <a href="https://twitter.com/intent/tweet?text={{ DiligentCreators('dashboard_url') == null ? env('APP_URL') : DiligentCreators('dashboard_url') . '/register?ref=' . Auth::user()->id }}"
                                class="btn btn-info d-inline-flex justify-content-center align-items-center mt-2 ml-3"
                                target="_blank">
                                <i class="fab fa-twitter mr-2"></i>
                                <span>Twitter</span>
                            </a>
                            <a href="mailto:recipient@example.com?subject=&body={{ DiligentCreators('dashboard_url') == null ? env('APP_URL') : DiligentCreators('dashboard_url') . '/register?ref=' . Auth::user()->id }}"
                                class="btn btn-warning d-inline-flex justify-content-center align-items-center mt-2 ml-3"
                                target="_blank">
                                <i class="fa-solid fa-envelope mr-2"></i>
                                <span>Mail</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        @if (DiligentCreators('mt5_ib_account_is_active') == 1)
            @if ($ib_id == '')
                <!-- IB Client content -->
                <section class="content" id="introducing-broker">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-outline">
                                    <div class="card-body box-profile">
                                        <h3 class="profile-username text-center m-0">Introducing Broker</h3>
                                        <h2 class="text-center my-3">Become an IB & Earn Comission</h2>
                                        <form action="{{ route('becomeIbClient') }}" method="POST">
                                            @csrf
                                            <button type="submit" name="becomeIB"
                                                class="btn btn-primary d-block mx-auto rounded-pill">Become an IB</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- /.content -->
            @endif

            @if ($ib_status == 1)
                <!-- IB Client Status Pending -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-outline">
                                    <div class="card-body">
                                        Your IB request has been submitted and awaiting for approval.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- /.content -->
            @endif

            @if ($ib_status == 3)
                <!-- IB Client Status Approved -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-outline">
                                    <div class="card-body">
                                        @if ($commission > 0)
                                            <div class="info-box bg-theme">
                                                <span class="info-box-icon"><i class="far fa-thumbs-up"></i></span>

                                                <div class="info-box-content">
                                                    <span class="info-box-text">IB Comission</span>
                                                    <span class="info-box-number">
                                                        ${{ $commission }}
                                                    </span>
                                                </div>
                                            </div>
                                        @else
                                            <div class="info-box bg-danger">
                                                <span class="info-box-icon"><i class="far fa-thumbs-down"></i></span>

                                                <div class="info-box-content">
                                                    <span class="info-box-text">IB Comission</span>
                                                    <span class="info-box-number">
                                                        ${{ $commission }}
                                                    </span>
                                                </div>
                                            </div>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        </div>
                </section>
                <!-- /.content -->
            @endif
        @endif


    </div>
    <!-- /.content-wrapper -->
@endsection


@section('scripts')
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('plugins/jquery-validation/additional-methods.min.js') }}"></script>
    <script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script>
        // Initialize Select2 Elements
        $('#account_type_id').select2({
            theme: 'bootstrap4'
        });


        $(function() {
            // Initialize Swiper
            let progressCircle = document.querySelector(".autoplay-progress svg");
            let progressContent = document.querySelector(".autoplay-progress span");
            let swiper = new Swiper(".tradingAccountsSlider", {
                freeMode: true,
                speed: 2000,
                autoplay: {
                    delay: 3000,
                    disableOnInteraction: false
                },
                slidesPerView: 1,
                spaceBetween: 10,
                breakpoints: {
                    640: {
                        slidesPerView: 2,
                        spaceBetween: 20,
                    },
                },
                on: {
                    autoplayTimeLeft(s, time, progress) {
                        progressCircle.style.setProperty("--progress", 1 - progress);
                        progressContent.textContent = `${Math.ceil(time / 1000)}s`;
                    }
                }
            });

            // Chart Color
            let chartColor;
            if (localStorage.getItem('Theme-Color') != null) {
                chartColor = $(':root').css('--' + localStorage.getItem('Theme-Color'));
            } else {
                chartColor = $(':root').css('--{{ DiligentCreators('theme_color') }}');
            }

            // Deposit Chart
            let depositChartCanvas = $('#depositChart').get(0).getContext('2d')
            let depositChartData = {
                labels: [
                    'January',
                    'February',
                    'March',
                    'April',
                    'May',
                    'June',
                    'July',
                    'August',
                    'September',
                    'October',
                    'November',
                    'December'
                ],
                datasets: [{
                        label: 'Deposit',
                        backgroundColor: chartColor,
                        borderColor: chartColor,
                        pointRadius: false,
                        pointColor: '#3b8bba',
                        pointStrokeColor: 'rgba(60,141,188,1)',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(60,141,188,1)',
                        data: [{{ $depositChartData }}]
                    },
                    {
                        label: 'Withdraw',
                        backgroundColor: '#f4f6f9',
                        borderColor: 'rgba(210, 214, 222, 1)',
                        pointRadius: false,
                        pointColor: 'rgba(210, 214, 222, 1)',
                        pointStrokeColor: '#c1c7d1',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(220,220,220,1)',
                        data: [{{ $withdrawChartData }}]
                    },
                ]
            }
            let depositChartOptions = {
                maintainAspectRatio: false,
                responsive: true,
                legend: {
                    display: true
                },
                scales: {
                    xAxes: [{
                        gridLines: {
                            display: false,
                        }
                    }],
                    yAxes: [{
                        gridLines: {
                            display: false,
                        }
                    }]
                }
            }
            new Chart(depositChartCanvas, {
                type: 'bar',
                data: depositChartData,
                options: depositChartOptions
            })


            // Withdraw Chart
            let internalChartCanvas = $('#internalChart').get(0).getContext('2d')
            let internalChartOptions = $.extend(true, {}, depositChartOptions)
            let internalChartDataSet = {
                labels: [
                    'January',
                    'February',
                    'March',
                    'April',
                    'May',
                    'June',
                    'July',
                    'August',
                    'September',
                    'October',
                    'November',
                    'December'
                ],
                datasets: [{
                        label: 'Deposit',
                        backgroundColor: chartColor,
                        borderColor: chartColor,
                        pointRadius: false,
                        pointColor: '#3b8bba',
                        pointStrokeColor: 'rgba(60,141,188,1)',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(60,141,188,1)',
                        data: [{{ $internaldepositChartData }}]
                    },
                    {
                        label: 'Withdraw',
                        backgroundColor: '#f4f6f9',
                        borderColor: 'rgba(210, 214, 222, 1)',
                        pointRadius: false,
                        pointColor: 'rgba(210, 214, 222, 1)',
                        pointStrokeColor: '#c1c7d1',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(220,220,220,1)',
                        data: [{{ $internalwithdrawChartData }}]
                    },
                ]
            }
            let internalChartData = $.extend(true, {}, internalChartDataSet)
            internalChartData.datasets[0].fill = false;
            internalChartData.datasets[1].fill = false;
            internalChartOptions.datasetFill = false
            let internalChart = new Chart(internalChartCanvas, {
                type: 'bar',
                data: internalChartData,
                options: internalChartOptions
            })
        });

        // Size in kb
        $.validator.addMethod('filesize', function(value, element, param) {

            var size = element.files[0].size;

            size = size / 2000;
            size = Math.round(size);
            return this.optional(element) || size <= param;

        }, 'File size must be less than {0}');
        jQuery(function($) {
            $("#tradingAccountForm").validate({
                rules: {
                    id_side_a: {
                        required: true,
                        extension: "jpg,jpeg,png,pdf",
                        filesize: 2000,
                    },
                    id_side_b: {
                        required: true,
                        extension: "jpg,jpeg,png,pdf",
                        filesize: 2000,
                    },
                    proof_address: {
                        required: true,
                        extension: "jpg,jpeg,png,pdf",
                        filesize: 2000,
                    },
                },
                messages: {
                    id_side_a: {
                        required: "Please upload front side of your ID card.",
                        extension: "Supported file extensions are jpg, jpeg, png, pdf.",
                        filesize: "File size should be less than 2 MB",
                    },
                    id_side_b: {
                        required: "Please upload back side of your ID card.",
                        extension: "Supported file extensions are jpg, jpeg, png, pdf.",
                        filesize: "File size should be less than 2 MB",
                    },
                    proof_address: {
                        required: "Please uplaod address proof document.",
                        extension: "Supported file extensions are jpg, jpeg, png, pdf.",
                        filesize: "File size should be less than 2 MB",
                    },
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                    $(element).addClass('is-valid');
                }
            });
        });

        // Copy to Clipboard
        function copyToClipboard() {
            /* Get the text field */
            var copyText = document.getElementById("copyIBCode");

            /* Select the text field */
            copyText.select();
            copyText.setSelectionRange(0, 99999); /* For mobile devices */

            /* Copy the text inside the text field */
            navigator.clipboard.writeText(copyText.value);

            /* Alert the copied text */
            $(".copySuccess").show();
            //alert("Copied the text: " + copyText.value);
        }
    </script>
@endsection
