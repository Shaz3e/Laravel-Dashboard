@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>App Theme Settings</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ DiligentCreators('dashboard_url') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">App Settings</a></li>
                        <li class="breadcrumb-item active">App Basic Settings</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>


    <!-- Theme Settings -->
    <section class="content" id="theme">
        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Theme Settings</h3>
            </div>
            <form action="{{ route('admin.app-settings-theme.update') }}#theme" method="POST" id="submitForm">
                @csrf
                <div class="card-body">

                    <div class="row">

                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="form-group">
                                <label for="theme_settings_is_active">Show Theme Setting</label>
                                <select name="theme_settings_is_active" class="form-control select2bs4" id="theme_settings_is_active" required="required">
                                    <option value="1" {{ old('theme_settings_is_active', $dataSet['theme_settings_is_active']) == 1 ? 'selected' : '' }}>Enable</option>
                                    <option value="0" {{ old('theme_settings_is_active', $dataSet['theme_settings_is_active']) == 0 ? 'selected' : '' }}>Disable</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="form-group">
                                <label for="dark_mode">Dark Mode</label>
                                <select name="dark_mode" class="form-control select2bs4" id="dark_mode" required="required">
                                    <option value="1" {{ old('dark_mode', $dataSet['dark_mode']) == 1 ? 'selected' : '' }}>Enable</option>
                                    <option value="0" {{ old('dark_mode', $dataSet['dark_mode']) == 0 ? 'selected' : '' }}>Disable</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="form-group">
                                <label for="theme_color">Theme Color</label>
                                    <select name="theme_color" class="form-control select2bs4" id="site_timezone" required="required">
                                    <option {{ old('', $dataSet['theme_color'] == 'danger' ? 'selected' : '' )}} value="danger">Danger</option>
                                    <option {{ old('', $dataSet['theme_color'] == 'fuchsia' ? 'selected' : '' )}} value="fuchsia">Fuchsia</option>
                                    <option {{ old('', $dataSet['theme_color'] == 'indigo' ? 'selected' : '' )}} value="indigo">Indigo</option>
                                    <option {{ old('', $dataSet['theme_color'] == 'info' ? 'selected' : '' )}} value="info">Info</option>
                                    <option {{ old('', $dataSet['theme_color'] == 'lightblue' ? 'selected' : '' )}} value="lightblue">Lightblue</option>
                                    <option {{ old('', $dataSet['theme_color'] == 'lime' ? 'selected' : '' )}} value="lime">Lime</option>
                                    <option {{ old('', $dataSet['theme_color'] == 'maroon' ? 'selected' : '' )}} value="maroon">Maroon</option>
                                    <option {{ old('', $dataSet['theme_color'] == 'navy' ? 'selected' : '' )}} value="navy">Navy</option>
                                    <option {{ old('', $dataSet['theme_color'] == 'orange' ? 'selected' : '' )}} value="orange">Orange</option>
                                    <option {{ old('', $dataSet['theme_color'] == 'olive' ? 'selected' : '' )}} value="olive">Olive</option>
                                    <option {{ old('', $dataSet['theme_color'] == 'pink' ? 'selected' : '' )}} value="pink">Pink</option>
                                    <option {{ old('', $dataSet['theme_color'] == 'primary' ? 'selected' : '' )}} value="primary">Primary</option>
                                    <option {{ old('', $dataSet['theme_color'] == 'purple' ? 'selected' : '' )}} value="purple">Purple</option>
                                    <option {{ old('', $dataSet['theme_color'] == 'success' ? 'selected' : '' )}} value="success">Success</option>
                                    <option {{ old('', $dataSet['theme_color'] == 'teal' ? 'selected' : '' )}} value="teal">Teal</option>
                                    <option {{ old('', $dataSet['theme_color'] == 'warning' ? 'selected' : '' )}} value="warning">Warning</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" name="themeSettings" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->

    <!-- App Notification Visibility Settings -->
    <section class="content" id="notifications">
        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">App Notification Visibility Settings</h3>
            </div>
            <form action="{{ route('admin.app-settings-theme.update') }}#notifications" method="POST" id="submitForm">
                @csrf
                <div class="card-body">

                    <div class="row">

                        <div class="col-lg-3 col-md-3 col-sm-12">
                            <div class="form-group">
                                <label for="toastr_notification_position_class">Select Position</label>
                                <select class="form-control select2bs4" name="toastr_notification_position_class">
                                    <option value="top-right" {{ old('toastr_notification_position_class', $dataSet['toastr_notification_position_class']) == 'top-right' ? 'selected' : '' }}>Top Right</option>
                                    <option value="bottom-right" {{ old('toastr_notification_position_class', $dataSet['toastr_notification_position_class']) == 'bottom-right' ? 'selected' : '' }}>Bottom Right</option>
                                    <option value="bottom-left" {{ old('toastr_notification_position_class', $dataSet['toastr_notification_position_class']) == 'bottom-left' ? 'selected' : '' }}>Bottom Left</option>
                                    <option value="top-left" {{ old('toastr_notification_position_class', $dataSet['toastr_notification_position_class']) == 'top-left' ? 'selected' : '' }}>Top Left</option>
                                    <option value="top-full-width" {{ old('toastr_notification_position_class', $dataSet['toastr_notification_position_class']) == 'top-full-width' ? 'selected' : '' }}>Top Full Width</option>
                                    <option value="bottom-full-width" {{ old('toastr_notification_position_class', $dataSet['toastr_notification_position_class']) == 'bottom-full-width' ? 'selected' : '' }}>Bottom Full Width</option>
                                    <option value="top-center" {{ old('toastr_notification_position_class', $dataSet['toastr_notification_position_class']) == 'top-center' ? 'selected' : '' }}>Top Center</option>
                                    <option value="bottom-center" {{ old('toastr_notification_position_class', $dataSet['toastr_notification_position_class']) == 'bottom-center' ? 'selected' : '' }}>Bottom Center</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-3 col-sm-12">
                            <div class="form-group">
                                <label for="toastr_notification_close_button">Show/Hide Close Button</label>
                                <select class="form-control select2bs4" name="toastr_notification_close_button">
                                    <option value="true" {{ old('toastr_notification_close_button', $dataSet['toastr_notification_close_button']) == 'true' ? 'selected' : '' }}>Show</option>
                                    <option value="false" {{ old('toastr_notification_close_button', $dataSet['toastr_notification_close_button']) == 'false' ? 'selected' : '' }}>Hide</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-3 col-sm-12">
                            <div class="form-group">
                                <label for="toastr_notification_progress_bar">Show/Hide Progress Bar</label>
                                <select class="form-control select2bs4" name="toastr_notification_progress_bar">
                                    <option value="true" {{ old('toastr_notification_progress_bar', $dataSet['toastr_notification_progress_bar']) == 'true' ? 'selected' : '' }}>Show</option>
                                    <option value="false" {{ old('toastr_notification_progress_bar', $dataSet['toastr_notification_progress_bar']) == 'false' ? 'selected' : '' }}>Hide</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-3 col-sm-12">
                            <div class="form-group">
                                <label for="toastr_notification_time_out">Timeout in Seconds or Infinite</label>
                                <input type="text" name="toastr_notification_time_out" class="form-control" value="{{ old('toastr_notification_time_out', $dataSet['toastr_notification_time_out']) }}">
                            </div>
                        </div>

                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" name="notificationSettings" class="btn btn-primary">Update</button>
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
</script>
@endsection