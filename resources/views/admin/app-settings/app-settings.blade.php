@extends('layouts.app')

@section('styles')
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>App Settings</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ DiligentCreators('dashboard_url') }}">Home</a></li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">

            <div class="container">
                <div class="row">

                    <div class="col-lg-2 col-md-2 col-sm-12">
                        <form method="post" action="{{ route('admin.app-settings.post') }}">
                            @csrf
                            <input type="hidden" name="settings" value="optimize_clear">
                            <button type="submit" class="btn btn-flat btn-block">Optimize:Clear</button>
                        </form>
                    </div>
                    {{-- /.col --}}

                    <div class="col-lg-2 col-md-2 col-sm-12">
                        <form method="post" action="{{ route('admin.app-settings.post') }}">
                            @csrf
                            <input type="hidden" name="settings" value="optimize">
                            <button type="submit" class="btn btn-flat btn-block">Optimize Dashbaord</button>
                        </form>
                    </div>
                    {{-- /.col --}}

                    <div class="col-lg-2 col-md-2 col-sm-12">
                        <form method="post" action="{{ route('admin.app-settings.post') }}">
                            @csrf
                            <input type="hidden" name="settings" value="system-route-cache">
                            <button type="submit" class="btn btn-flat btn-block">Clear Route Cache</button>
                        </form>
                    </div>
                    {{-- /.col --}}

                    <div class="col-lg-2 col-md-2 col-sm-12">
                        <form method="post" action="{{ route('admin.app-settings.post') }}">
                            @csrf
                            <input type="hidden" name="settings" value="system-config-cache">
                            <button type="submit" class="btn btn-flat btn-block">Clear Config Cache</button>
                        </form>
                    </div>
                    {{-- /.col --}}

                    <div class="col-lg-2 col-md-2 col-sm-12">
                        <form method="post" action="{{ route('admin.app-settings.post') }}">
                            @csrf
                            <input type="hidden" name="settings" value="system-clear-cache">
                            <button type="submit" class="btn btn-flat btn-block">Clear System Cache</button>
                        </form>
                    </div>
                    {{-- /.col --}}

                    <div class="col-lg-2 col-md-2 col-sm-12">
                        <form method="post" action="{{ route('admin.app-settings.post') }}">
                            @csrf
                            <input type="hidden" name="settings" value="system-view-clear">
                            <button type="submit" class="btn btn-flat btn-block">Clear View Cache</button>
                        </form>
                    </div>
                    {{-- /.col --}}

                </div>
                {{-- /.row --}}
            </div>
            {{-- /.container --}}

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection

@section('scripts')
@endsection
