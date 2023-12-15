@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>App Basic Settings</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ DiligentCreators('dashboard_url') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.app-settings') }}">App Settings</a></li>
                            <li class="breadcrumb-item active">App Basic Settings</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- App Basic Setting Main content -->
        <section class="content" id="basicSetting">
            <!-- Default box -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Update App Basic Setting</h3>
                </div>
                <div class="card-header">
                    <h3 class="card-title">App Settings</h3>
                </div>
                <form action="{{ route('admin.app-settings-basic.update') }}#basicSetting" method="POST" id="submitForm">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="site_name">Site Name</label>
                                    <input type="text" name="site_name" class="form-control" id="site_name"
                                        value="{{ old('site_name', $dataSet['site_name'] == null ? config('app.name') : $dataSet['site_name']) }}" maxlength="255" required />
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="site_timezone">Site Timezone</label>
                                    {{ getAllTimeZonesSelectBox(old('site_timezone', $dataSet['site_timezone'])) }}
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="site_url">Site URL</label>
                                    <input type="url" name="site_url" class="form-control" id="site_url"
                                        value="{{ old('site_url', $dataSet['site_url'] == null ? config('app.url') : $dataSet['site_url']) }}"
                                        url="true" maxlength="255" required />
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="dashboard_url">Dashboard URL</label>
                                    <input type="url" name="dashboard_url" class="form-control" id="dashboard_url"
                                        value="{{ old('dashboard_url', $dataSet['dashboard_url'] == null ? config('app.url') : $dataSet['dashboard_url']) }}"
                                        url="true" maxlength="255" required />
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" name="basicSettings" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
            <!-- /.card -->
        </section>
        <!-- /.content -->

        <!-- Registration Form Fields -->
        <section class="content" id="registerFormFields">
            <!-- Default box -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Update Registration Form Fields</h3>
                </div>
                <div class="card-header">
                    <h3 class="card-title">Registration Form Fields</h3>
                </div>
                <form action="{{ route('admin.app-settings-basic.update') }}#registerFormFields" method="POST"
                    id="RegistrationFields">
                    @csrf
                    <div class="card-body">

                        <div class="row">

                            <div class="col-lg-3 col-md-3 col-sm-12">
                                <div class="form-group">
                                    <label for="enable_country">Country</label>
                                    <select class="form-control" name="enable_country">
                                        <option value="1"
                                            {{ old('enable_country', $dataSet['enable_country']) == 1 ? 'selected' : '' }}>
                                            Enable</option>
                                        <option value="0"
                                            {{ old('enable_country', $dataSet['enable_country']) == 0 ? 'selected' : '' }}>
                                            Disable</option>
                                    </select>
                                    <small class="text-muted">Enable/Disable Country field on registration form</small>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-3 col-sm-12">
                                <div class="form-group">
                                    <label for="enable_state">State</label>
                                    <select class="form-control" name="enable_state">
                                        <option value="1"
                                            {{ old('enable_state', $dataSet['enable_state']) == 1 ? 'selected' : '' }}>
                                            Enable</option>
                                        <option value="0"
                                            {{ old('enable_state', $dataSet['enable_state']) == 0 ? 'selected' : '' }}>
                                            Disable</option>
                                    </select>
                                    <small class="text-muted">Enable/Disable State field on registration form</small>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-3 col-sm-12">
                                <div class="form-group">
                                    <label for="enable_city">City</label>
                                    <select class="form-control" name="enable_city">
                                        <option value="1"
                                            {{ old('enable_city', $dataSet['enable_city']) == 1 ? 'selected' : '' }}>Enable
                                        </option>
                                        <option value="0"
                                            {{ old('enable_city', $dataSet['enable_city']) == 0 ? 'selected' : '' }}>
                                            Disable</option>
                                    </select>
                                    <small class="text-muted">Enable/Disable City field on registration form</small>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-3 col-sm-12">
                                <div class="form-group">
                                    <label for="dob_is_active">Date of Birth</label>
                                    <select class="form-control" name="dob_is_active">
                                        <option value="1"
                                            {{ old('dob_is_active', $dataSet['dob_is_active']) == 1 ? 'selected' : '' }}>Enable
                                        </option>
                                        <option value="0"
                                            {{ old('dob_is_active', $dataSet['dob_is_active']) == 0 ? 'selected' : '' }}>
                                            Disable</option>
                                    </select>
                                    <small class="text-muted">Enable/Disable DOB field on registration form</small>
                                </div>
                            </div>

                            <div class="col-lg-2 col-md-2 col-sm-12">
                                <div class="form-group">
                                    <label for="enable_mobile">Mobile No.</label>
                                    <select class="form-control" name="enable_mobile">
                                        <option value="1"
                                            {{ old('enable_mobile', $dataSet['enable_mobile']) == 1 ? 'selected' : '' }}>Enable
                                        </option>
                                        <option value="0"
                                            {{ old('enable_mobile', $dataSet['enable_mobile']) == 0 ? 'selected' : '' }}>
                                            Disable</option>
                                    </select>
                                    <small class="text-muted">Enable/Disable Mobile No field on registration form</small>
                                </div>
                            </div>

                            <div class="col-lg-2 col-md-2 col-sm-12">
                                <div class="form-group">
                                    <label for="age_limit">Age Limit</label>
                                    <input type="number" required number="true" name="age_limit" class="form-control"
                                        value="{{ old('age_limit', $dataSet['age_limit']) }}" min="0">
                                    <small class="text-muted">To disable age limit insert 0</small>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-3 col-sm-12">
                                <div class="form-group">
                                    <label for="user_auto_login">Auto Login</label>
                                    <select class="form-control" name="user_auto_login">
                                        <option value="1"
                                            {{ old('user_auto_login', $dataSet['user_auto_login']) == 1 ? 'selected' : '' }}>Enable
                                        </option>
                                        <option value="0"
                                            {{ old('user_auto_login', $dataSet['user_auto_login']) == 0 ? 'selected' : '' }}>
                                            Disable</option>
                                    </select>
                                    <small class="text-muted">Enable/Disable Auto Login User will be logged in automaticaly after signup</small>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" name="registrationFormFields" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
            <!-- /.card -->
        </section>
        <!-- /.content -->

    </div>
    <!-- /.content-wrapper -->
@endsection

@section('scripts')
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>
    <script src="{{ asset('plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('plugins/jquery-validation/additional-methods.min.js') }}"></script>
    <script>
        // Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        });
        $('#submitForm').validate({
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
            }
        });
        $('#RegistrationFields').validate({
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
            }
        });
    </script>
@endsection
