@extends('layouts.other-app')

@section('styles')
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
                <p class="login-box-msg p-0 m-0">Reset Password</p>
                <p class="login-box-msg p-0 mt-2">
                    <font class="fas fa-lock"></font> End-to-end encypted
                </p>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('password.store') }}" id="submitForm">
                    <input type="hidden" name="email" value="{{ $request->route('email') }}">
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" placeholder="New Password" name="password"
                            value="{{ old('password') }}" {{-- required --}} />
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" placeholder="Confirm New Password"
                            name="password_confirmation" value="{{ old('password_confirmation') }}" {{-- required --}} />
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
                    <button type="submit" class="btn btn-primary btn-block mb-2 theme-btn">Change Password</button>
                </form>
                <small class="m-0 text-mode d-block"><a href="{{ route('login') }}" class="text-theme">Login</a></small>
            </div>
            <!-- /.form-box -->
        </div>
        <!-- /.card -->
    </div>
@endsection

@section('scripts')
    <script>
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
