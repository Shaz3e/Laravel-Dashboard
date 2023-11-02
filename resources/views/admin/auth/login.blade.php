@extends('layouts.other-app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection

@section('body_class')
    login-page
@endsection

@section('content')
    <div class="register-box">        

        <div class="text-center mb-2">
            <a href="{{ DiligentCreators('site_url') }}">
                <img class="img-fluid" src="{{ asset('/') }}{{ DiligentCreators('site_logo') }}" alt="{{ DiligentCreators('site_name') == null ? config('app.name') : DiligentCreators('site_name') }}">
            </a>
        </div>

        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <p class="login-box-msg p-0 m-0">Login to Admin Portal</p>
                <p class="login-box-msg p-0 mt-2">
                    <font class="fas fa-lock"></font> End-to-end encypted
                </p>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.login') }}" method="POST" id="submitForm">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="email" id="email" class="form-control" placeholder="Email" name="email"
                            value="{{ old('email') }}" {{-- email="true" required --}} />
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" id="password" class="form-control" placeholder="Password" name="password"
                            value="{{ old('password') }}" {{-- required --}} />
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    @if (DiligentCreators('google_recaptcha') == 1)
                        <div class="col-12">
                            <div class="form-group">
                                <div class="g-recaptcha" data-sitekey="{{ DiligentCreators('google_site_key') }}"></div>
                            </div>
                        </div>
                    @endif
                    <button type="submit" id="loginDashboard"
                        class="btn btn-primary btn-block mb-2 theme-btn">Login</button>
                </form>
            </div>
            {{-- ./card-body --}}
        </div>
        {{-- /.card --}}
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script>
        // Initialize Select2 Elements
        $('.department_id').select2({
            theme: 'bootstrap4'
        });
        // Initialize Select2 Elements
        $('.user_role_id').select2({
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
