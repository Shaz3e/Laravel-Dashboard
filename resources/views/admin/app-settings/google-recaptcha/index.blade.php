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
                        <h1>Google reCaptcha Setting</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ DiligentCreators('dashboard_url') }}">Home</a></li>
                            <li class="breadcrumb-item"><a>App Settings</a></li>
                            <li class="breadcrumb-item active">Google reCaptcha Setting</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <!-- Default box -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Update Google reCaptcha</h3>
                </div>
                <form action="{{ route('admin.app-settings-google-recaptcha.update') }}" method="POST" id="submitForm">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="google_site_key">Site Key</label>
                                    <input type="text" name="google_site_key" class="form-control" id="google_site_key"
                                        value="{{ old('', $dataSet['google_site_key']) }}" maxlength="255" required />
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="google_secret_key">Secret Key</label>
                                    <input type="text" name="google_secret_key" class="form-control"
                                        id="google_secret_key" value="{{ old('', $dataSet['google_secret_key']) }}" maxlength="255" required />
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="google_recaptcha">Enable / Disable Google Recaptcha</label>
                                    <select name="google_recaptcha" id="google_recaptcha" class="form-control">
                                        <option value="0">Disable</option>
                                        <option value="1" {{ old('google_recaptcha', $dataSet['google_recaptcha']) ? 'selected' : '' }}>Enable
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
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
    <script src="{{ asset('plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script>
        $('#submitForm').validate({
            rules: {
                google_site_key: {
                    required: true,
                    maxLength: 255,
                },
                google_secret_key: {
                    required: true,
                    maxLength: 255,
                },
            },
            messages: {
                google_site_key: {
                    required: "Google site key is required",
                    maxLength: "Google site key is must be less then 255 characters",
                },
                google_secret_key: {
                    required: "Google secret key is required",
                    maxLength: "Google secret key is must be less then 255 characters",
                }
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
            }
        });
    </script>
@endsection
