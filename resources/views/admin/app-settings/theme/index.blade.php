@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') }}">
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
                            <li class="breadcrumb-item"><a href="{{ route('admin.app-settings') }}">App Settings</a></li>
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
                                    <select name="theme_settings_is_active" class="form-control select2bs4"
                                        id="theme_settings_is_active" required="required">
                                        <option value="1"
                                            {{ old('theme_settings_is_active', $dataSet['theme_settings_is_active']) == 1 ? 'selected' : '' }}>
                                            Enable</option>
                                        <option value="0"
                                            {{ old('theme_settings_is_active', $dataSet['theme_settings_is_active']) == 0 ? 'selected' : '' }}>
                                            Disable</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="dark_mode">Dark Mode</label>
                                    <select name="dark_mode" class="form-control select2bs4" id="dark_mode"
                                        required="required">
                                        <option value="1"
                                            {{ old('dark_mode', $dataSet['dark_mode']) == 1 ? 'selected' : '' }}>Enable
                                        </option>
                                        <option value="0"
                                            {{ old('dark_mode', $dataSet['dark_mode']) == 0 ? 'selected' : '' }}>Disable
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="theme_color">Theme Color</label>
                                    <select name="theme_color" class="form-control select2bs4" id="site_timezone"
                                        required="required">
                                        <option {{ old('', $dataSet['theme_color'] == 'danger' ? 'selected' : '') }}
                                            value="danger">Danger</option>
                                        <option {{ old('', $dataSet['theme_color'] == 'fuchsia' ? 'selected' : '') }}
                                            value="fuchsia">Fuchsia</option>
                                        <option {{ old('', $dataSet['theme_color'] == 'indigo' ? 'selected' : '') }}
                                            value="indigo">Indigo</option>
                                        <option {{ old('', $dataSet['theme_color'] == 'info' ? 'selected' : '') }}
                                            value="info">Info</option>
                                        <option {{ old('', $dataSet['theme_color'] == 'lightblue' ? 'selected' : '') }}
                                            value="lightblue">Lightblue</option>
                                        <option {{ old('', $dataSet['theme_color'] == 'lime' ? 'selected' : '') }}
                                            value="lime">Lime</option>
                                        <option {{ old('', $dataSet['theme_color'] == 'maroon' ? 'selected' : '') }}
                                            value="maroon">Maroon</option>
                                        <option {{ old('', $dataSet['theme_color'] == 'navy' ? 'selected' : '') }}
                                            value="navy">Navy</option>
                                        <option {{ old('', $dataSet['theme_color'] == 'orange' ? 'selected' : '') }}
                                            value="orange">Orange</option>
                                        <option {{ old('', $dataSet['theme_color'] == 'olive' ? 'selected' : '') }}
                                            value="olive">Olive</option>
                                        <option {{ old('', $dataSet['theme_color'] == 'pink' ? 'selected' : '') }}
                                            value="pink">Pink</option>
                                        <option {{ old('', $dataSet['theme_color'] == 'primary' ? 'selected' : '') }}
                                            value="primary">Primary</option>
                                        <option {{ old('', $dataSet['theme_color'] == 'purple' ? 'selected' : '') }}
                                            value="purple">Purple</option>
                                        <option {{ old('', $dataSet['theme_color'] == 'success' ? 'selected' : '') }}
                                            value="success">Success</option>
                                        <option {{ old('', $dataSet['theme_color'] == 'teal' ? 'selected' : '') }}
                                            value="teal">Teal</option>
                                        <option {{ old('', $dataSet['theme_color'] == 'warning' ? 'selected' : '') }}
                                            value="warning">Warning</option>
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
                    <h3 class="card-title">
                        App Notification Visibility Settings
                    </h3>
                </div>
                <form action="{{ route('admin.app-settings-theme.update') }}#notifications" method="POST" id="submitForm">
                    @csrf
                    <div class="card-body">

                        <div class="row">
                            <div class="col-lg-3 col-md-3 col-sm-12">
                                <div class="form-group">
                                    <label>Select Notification Type</label>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" id="toastr"
                                            name="notification_type" value="toastr"
                                            {{ $dataSet['notification_type'] == 'toastr' ? 'checked' : '' }}>
                                        <label for="toastr" class="custom-control-label">Toastr</label>
                                    </div>

                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" id="sweetalerts"
                                            name="notification_type" value="sweetalerts"
                                            {{ $dataSet['notification_type'] == 'sweetalerts' ? 'checked' : '' }}>
                                        <label for="sweetalerts" class="custom-control-label">SweetAlerts</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Toastr Notifications --}}
                        <div class="row" id="toastrShow" style="display:none;">
                            <div class="col-12">
                                <h5>Toastr Settings</h5>
                                <hr>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-12">
                                <div class="form-group">
                                    <label for="toastr_notification_position_class">Select Position</label>
                                    <select class="form-control select2bs4" name="toastr_notification_position_class">
                                        <option value="top-right"
                                            {{ old('toastr_notification_position_class', $dataSet['toastr_notification_position_class']) == 'top-right' ? 'selected' : '' }}>
                                            Top Right</option>
                                        <option value="bottom-right"
                                            {{ old('toastr_notification_position_class', $dataSet['toastr_notification_position_class']) == 'bottom-right' ? 'selected' : '' }}>
                                            Bottom Right</option>
                                        <option value="bottom-left"
                                            {{ old('toastr_notification_position_class', $dataSet['toastr_notification_position_class']) == 'bottom-left' ? 'selected' : '' }}>
                                            Bottom Left</option>
                                        <option value="top-left"
                                            {{ old('toastr_notification_position_class', $dataSet['toastr_notification_position_class']) == 'top-left' ? 'selected' : '' }}>
                                            Top Left</option>
                                        <option value="top-full-width"
                                            {{ old('toastr_notification_position_class', $dataSet['toastr_notification_position_class']) == 'top-full-width' ? 'selected' : '' }}>
                                            Top Full Width</option>
                                        <option value="bottom-full-width"
                                            {{ old('toastr_notification_position_class', $dataSet['toastr_notification_position_class']) == 'bottom-full-width' ? 'selected' : '' }}>
                                            Bottom Full Width</option>
                                        <option value="top-center"
                                            {{ old('toastr_notification_position_class', $dataSet['toastr_notification_position_class']) == 'top-center' ? 'selected' : '' }}>
                                            Top Center</option>
                                        <option value="bottom-center"
                                            {{ old('toastr_notification_position_class', $dataSet['toastr_notification_position_class']) == 'bottom-center' ? 'selected' : '' }}>
                                            Bottom Center</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-3 col-sm-12">
                                <div class="form-group">
                                    <label for="toastr_notification_close_button">Show/Hide Close Button</label>
                                    <select class="form-control" name="toastr_notification_close_button">
                                        <option value="true"
                                            {{ old('toastr_notification_close_button', $dataSet['toastr_notification_close_button']) == 'true' ? 'selected' : '' }}>
                                            Show</option>
                                        <option value="false"
                                            {{ old('toastr_notification_close_button', $dataSet['toastr_notification_close_button']) == 'false' ? 'selected' : '' }}>
                                            Hide</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-3 col-sm-12">
                                <div class="form-group">
                                    <label for="toastr_notification_progress_bar">Show/Hide Progress Bar</label>
                                    <select class="form-control" name="toastr_notification_progress_bar">
                                        <option value="true"
                                            {{ old('toastr_notification_progress_bar', $dataSet['toastr_notification_progress_bar']) == 'true' ? 'selected' : '' }}>
                                            Show</option>
                                        <option value="false"
                                            {{ old('toastr_notification_progress_bar', $dataSet['toastr_notification_progress_bar']) == 'false' ? 'selected' : '' }}>
                                            Hide</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-3 col-sm-12">
                                <div class="form-group">
                                    <label for="toastr_notification_time_out">Timeout in Seconds or Infinite</label>
                                    <input type="text" name="toastr_notification_time_out" class="form-control"
                                        value="{{ old('toastr_notification_time_out', $dataSet['toastr_notification_time_out']) }}">
                                </div>
                            </div>

                        </div>
                        {{-- /.row Toastr Notifications --}}

                        {{-- Sweet Alert Notifications --}}
                        <div class="row" id="sweetalertsShow" style="display:none;">
                            <div class="col-12">
                                <h5>SweetAlerts Setting</h5>
                                <hr>
                            </div>

                            <div class="col-lg-3 col-md-3 col-sm-12">
                                <div class="form-group">
                                    <label for="sweet_alerts_position">Select Position</label>
                                    <select id="sweet_alerts_position" class="form-control select2bs4"
                                        name="sweet_alerts_position">
                                        <option value="top-end"
                                            {{ old('sweet_alerts_position', $dataSet['sweet_alerts_position']) == 'top-end' ? 'selected' : '' }}>
                                            Top Right</option>
                                        <option value="top-start"
                                            {{ old('sweet_alerts_position', $dataSet['sweet_alerts_position']) == 'top-start' ? 'selected' : '' }}>
                                            Top Left</option>
                                        <option value="top"
                                            {{ old('sweet_alerts_position', $dataSet['sweet_alerts_position']) == 'top' ? 'selected' : '' }}>
                                            Top Center</option>
                                        <option value="bottom-end"
                                            {{ old('sweet_alerts_position', $dataSet['sweet_alerts_position']) == 'bottom-end' ? 'selected' : '' }}>
                                            Bottom Right</option>
                                        <option value="bottom-start"
                                            {{ old('sweet_alerts_position', $dataSet['sweet_alerts_position']) == 'bottom-start' ? 'selected' : '' }}>
                                            Bottom Left</option>
                                        <option value="bottom"
                                            {{ old('sweet_alerts_position', $dataSet['sweet_alerts_position']) == 'bottom' ? 'selected' : '' }}>
                                            Bottom Center</option>
                                        <option value="center"
                                            {{ old('sweet_alerts_position', $dataSet['sweet_alerts_position']) == 'center' ? 'selected' : '' }}>
                                            Center</option>
                                        <option value="center-end"
                                            {{ old('sweet_alerts_position', $dataSet['sweet_alerts_position']) == 'center-end' ? 'selected' : '' }}>
                                            Center Right</option>
                                        <option value="center-start"
                                            {{ old('sweet_alerts_position', $dataSet['sweet_alerts_position']) == 'center-start' ? 'selected' : '' }}>
                                            Center Left</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-3 col-sm-12">
                                <div class="form-group">
                                    <label for="sweet_alerts_type">Select Type</label>
                                    <select name="sweet_alerts_type" id="sweet_alerts_type"
                                        class="form-control select2bs4">
                                        <option value="false"
                                            {{ old('sweet_alerts_type', $dataSet['sweet_alerts_type']) == 'false' ? 'selected' : '' }}>
                                            Show as Alert</option>
                                        <option value="true"
                                            {{ old('sweet_alerts_type', $dataSet['sweet_alerts_type']) == 'true' ? 'selected' : '' }}>
                                            Show as Notifcation</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-3 col-sm-12">
                                <div class="form-group">
                                    <label>Show/Hide Progress Bar</label>
                                    <select class="form-control" name="sweet_alerts_timer_progress_bar">
                                        <option value="true"
                                            {{ old('sweet_alerts_timer_progress_bar', $dataSet['sweet_alerts_timer_progress_bar']) == 'true' ? 'selected' : '' }}>
                                            Show</option>
                                        <option value="false"
                                            {{ old('sweet_alerts_timer_progress_bar', $dataSet['sweet_alerts_timer_progress_bar']) == 'false' ? 'selected' : '' }}>
                                            Hide</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-3 col-sm-12">
                                <div class="form-group">
                                    <label for="sweet_alerts_timer">Timeout in Seconds</label>
                                    <input type="text" name="sweet_alerts_timer" class="form-control"
                                        value="{{ old('sweet_alerts_timer', $dataSet['sweet_alerts_timer']) }}">
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-3 col-sm-12">
                                <div class="form-group">
                                    <label for="sweet_alerts_animation">Show/Hide Animation</label>
                                    <select class="form-control" name="sweet_alerts_animation">
                                        <option value="true"
                                            {{ old('sweet_alerts_animation', $dataSet['sweet_alerts_animation']) == 'true' ? 'selected' : '' }}>
                                            Show</option>
                                        <option value="false"
                                            {{ old('sweet_alerts_animation', $dataSet['sweet_alerts_animation']) == 'false' ? 'selected' : '' }}>
                                            Hide</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-3 col-sm-12">
                                <div class="form-group">
                                    <label for="sweet_alerts_icon_color">Icon Color</label>
                                    <div class="input-group sweet_alerts_icon_color">
                                        <input type="text" name="sweet_alerts_icon_color" class="form-control"
                                            value="{{ old('sweet_alerts_icon_color', $dataSet['sweet_alerts_icon_color']) }}">

                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="fas fa-square"
                                                    style="color: {{ $dataSet['sweet_alerts_icon_color'] }}"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-3 col-sm-12">
                                <div class="form-group">
                                    <label for="sweet_alerts_text_color">Text Color</label>
                                    <div class="input-group sweet_alerts_text_color">
                                        <input type="text" name="sweet_alerts_text_color" class="form-control"
                                            value="{{ old('sweet_alerts_text_color', $dataSet['sweet_alerts_text_color']) }}">

                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="fas fa-square"
                                                    style="color: {{ $dataSet['sweet_alerts_text_color'] }}"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-3 col-sm-12">
                                <div class="form-group">
                                    <label for="sweet_alerts_background_color">Background Color</label>
                                    <div class="input-group sweet_alerts_background_color">
                                        <input type="text" name="sweet_alerts_background_color" class="form-control"
                                            value="{{ old('sweet_alerts_background_color', $dataSet['sweet_alerts_background_color']) }}">

                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="fas fa-square"
                                                    style="color: {{ $dataSet['sweet_alerts_background_color'] }}"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-2 col-md-2 col-sm-12">
                                <div class="form-group">
                                    <label for="sweet_alerts_confirm_button">Confirm Button</label>
                                    <select id="sweet_alerts_confirm_button" name="sweet_alerts_confirm_button"
                                        class="form-control">
                                        <option value=""
                                            {{ old('sweet_alerts_confirm_button', $dataSet['sweet_alerts_confirm_button']) == '' ? 'selected' : '' }}>
                                            Default
                                        </option>
                                        <option value="primary"
                                            {{ old('sweet_alerts_confirm_button', $dataSet['sweet_alerts_confirm_button']) == 'primary' ? 'selected' : '' }}>
                                            Primary</option>
                                        <option value="info"
                                            {{ old('sweet_alerts_confirm_button', $dataSet['sweet_alerts_confirm_button']) == 'info' ? 'selected' : '' }}>
                                            Info
                                        </option>
                                        <option value="success"
                                            {{ old('sweet_alerts_confirm_button', $dataSet['sweet_alerts_confirm_button']) == 'success' ? 'selected' : '' }}>
                                            Success
                                        </option>
                                        <option value="warning"
                                            {{ old('sweet_alerts_confirm_button', $dataSet['sweet_alerts_confirm_button']) == 'warning' ? 'selected' : '' }}>
                                            Warning
                                        </option>
                                        <option value="danger"
                                            {{ old('sweet_alerts_confirm_button', $dataSet['sweet_alerts_confirm_button']) == 'danger' ? 'selected' : '' }}>
                                            Danger
                                        </option>
                                        <option value="dark"
                                            {{ old('sweet_alerts_confirm_button', $dataSet['sweet_alerts_confirm_button']) == 'dark' ? 'selected' : '' }}>
                                            Dark
                                        </option>
                                        <option value="light"
                                            {{ old('sweet_alerts_confirm_button', $dataSet['sweet_alerts_confirm_button']) == 'light' ? 'selected' : '' }}>
                                            Light
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-2 col-md-2 col-sm-12">
                                <div class="form-group">
                                    <label for="sweet_alerts_cancel_button">Cancel Button</label>
                                    <select id="sweet_alerts_cancel_button" name="sweet_alerts_cancel_button"
                                        class="form-control">
                                        <option value=""
                                            {{ old('sweet_alerts_cancel_button', $dataSet['sweet_alerts_cancel_button']) == '' ? 'selected' : '' }}>
                                            Default
                                        </option>
                                        <option value="primary"
                                            {{ old('sweet_alerts_cancel_button', $dataSet['sweet_alerts_cancel_button']) == 'primary' ? 'selected' : '' }}>
                                            Primary</option>
                                        <option value="info"
                                            {{ old('sweet_alerts_cancel_button', $dataSet['sweet_alerts_cancel_button']) == 'info' ? 'selected' : '' }}>
                                            Info
                                        </option>
                                        <option value="success"
                                            {{ old('sweet_alerts_cancel_button', $dataSet['sweet_alerts_cancel_button']) == 'success' ? 'selected' : '' }}>
                                            Success
                                        </option>
                                        <option value="warning"
                                            {{ old('sweet_alerts_cancel_button', $dataSet['sweet_alerts_cancel_button']) == 'warning' ? 'selected' : '' }}>
                                            Warning
                                        </option>
                                        <option value="danger"
                                            {{ old('sweet_alerts_cancel_button', $dataSet['sweet_alerts_cancel_button']) == 'danger' ? 'selected' : '' }}>
                                            Danger
                                        </option>
                                        <option value="dark"
                                            {{ old('sweet_alerts_cancel_button', $dataSet['sweet_alerts_cancel_button']) == 'dark' ? 'selected' : '' }}>
                                            Dark
                                        </option>
                                        <option value="light"
                                            {{ old('sweet_alerts_cancel_button', $dataSet['sweet_alerts_cancel_button']) == 'light' ? 'selected' : '' }}>
                                            Light
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-2 col-md-2 col-sm-12">
                                <div class="form-group">
                                    <label for="sweet_alerts_show_confirm_button">Confirm Buttons</label>
                                    <select class="form-control" name="sweet_alerts_show_confirm_button">
                                        <option value="true"
                                            {{ old('sweet_alerts_show_confirm_button', $dataSet['sweet_alerts_show_confirm_button']) == 'true' ? 'selected' : '' }}>
                                            Show</option>
                                        <option value="false"
                                            {{ old('sweet_alerts_show_confirm_button', $dataSet['sweet_alerts_show_confirm_button']) == 'false' ? 'selected' : '' }}>
                                            Hide</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                        {{-- /.row Sweet Alert Notifications --}}

                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" name="notificationSettings" class="btn btn-primary">Update</button>
                    </div>
                    {{-- /.card-footer --}}

                </form>
            </div>
            <!-- /.card -->
        </section>
        <!-- /.content -->

    </div>
    <!-- /.content-wrapper -->
@endsection

@section('scripts')
    <script src="{{ asset('plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') }}"></script>
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('plugins/jquery-validation/additional-methods.min.js') }}"></script>
    <script>
        $(function() {
            // icon color
            $('.sweet_alerts_icon_color').colorpicker()
            $('.sweet_alerts_icon_color').on('colorpickerChange', function(event) {
                $('.sweet_alerts_icon_color .fa-square').css('color', event.color.toString());
            })

            // text color
            $('.sweet_alerts_text_color').colorpicker()
            $('.sweet_alerts_text_color').on('colorpickerChange', function(event) {
                $('.sweet_alerts_text_color .fa-square').css('color', event.color.toString());
            })

            // background color
            $('.sweet_alerts_background_color').colorpicker()
            $('.sweet_alerts_background_color').on('colorpickerChange', function(event) {
                $('.sweet_alerts_background_color .fa-square').css('color', event.color.toString());
            })

            // confirm button color
            $('.sweet_alerts_confirm_button').colorpicker()
            $('.sweet_alerts_confirm_button').on('colorpickerChange', function(event) {
                $('.sweet_alerts_confirm_button .fa-square').css('color', event.color.toString());
            })

            // cancel button color
            $('.sweet_alerts_cancel_button').colorpicker()
            $('.sweet_alerts_cancel_button').on('colorpickerChange', function(event) {
                $('.sweet_alerts_cancel_button .fa-square').css('color', event.color.toString());
            })
        });
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

        $(document).ready(function() {
            $('#sweet_alerts_type').change(function() {
                if ($(this).val() == 'false') {
                    // Select sweet alert position as center
                    $('#sweet_alerts_position').val('center');
                    $('#sweet_alerts_text_color').val('');
                    $('#sweet_alerts_background_color').val('');
                }
            });

            // Show/hide divs based on radio button selection
            $('input[name="notification_type"]').change(function() {
                var selectedType = $(this).val();
                $('#toastrShow, #sweetalertsShow').hide();
                $('#' + selectedType + 'Show').show();
            });

            // Trigger the change event on page load to show the initially selected div
            $('input[name="notification_type"]:checked').trigger('change');
        });
    </script>
@endsection
