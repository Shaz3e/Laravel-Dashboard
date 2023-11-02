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
                <p class="login-box-msg p-0 m-0">Welcome</p>
                <p class="login-box-msg p-0 m-0">Login to Client Portal</p>
                <p class="login-box-msg p-0 mt-2">
                    <font class="fas fa-lock"></font> End-to-end encypted
                </p>
            </div>
            <div class="card-body">
                @if (Session::has('message'))
                    <div class="alert alert-success">
                        {{ session('message')['text'] }}
                    </div>
                @endif
                <form method="POST" action="{{ route('login') }}" id="submitForm">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" placeholder="Email" name="email"
                            value="{{ old('email') }}" {{-- email="true" required --}} />
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" placeholder="Password" name="password"
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
                                <div class="g-recaptcha" data-sitekey="{{ DiligentCreators('google_site_key') }}">
                                </div>
                            </div>
                        </div>
                    @endif
                    @if (
                        $dataSet['link_one'] != '' ||
                            $dataSet['link_two'] != '' ||
                            $dataSet['link_three'] != '' ||
                            $dataSet['link_four'] != '' ||
                            $dataSet['link_five'] != '' ||
                            $dataSet['link_six'] != '' ||
                            $dataSet['link_seven'] != '')
                        <div class="col-12">
                            <ul class="pl-0">
                                @if ($dataSet['link_one'] != '')
                                    <li class="m-0 text-mode text-justify d-block"><a href="{{ $dataSet['link_one'] }}"
                                            class="text-theme" target="_blank"><i class="fa-solid fa-arrow-right-long"></i>
                                            Anti-Money Laundering
                                            Policy</a></li>
                                @endif
                                @if ($dataSet['link_two'] != '')
                                    <li class="m-0 text-mode text-justify d-block"><a href="{{ $dataSet['link_two'] }}"
                                            class="text-theme" target="_blank"><i class="fa-solid fa-arrow-right-long"></i>
                                            Client Agreement</a></li>
                                @endif
                                @if ($dataSet['link_three'] != '')
                                    <li class="m-0 text-mode text-justify d-block"><a href="{{ $dataSet['link_three'] }}"
                                            class="text-theme" target="_blank"><i class="fa-solid fa-arrow-right-long"></i>
                                            Deposit
                                            Withdrawal
                                            Policy</a></li>
                                @endif
                                @if ($dataSet['link_four'] != '')
                                    <li class="m-0 text-mode text-justify d-block"><a href="{{ $dataSet['link_four'] }}"
                                            class="text-theme" target="_blank"><i class="fa-solid fa-arrow-right-long"></i>
                                            Privacy
                                            Policy</a></li>
                                @endif
                                @if ($dataSet['link_five'] != '')
                                    <li class="m-0 text-mode text-justify d-block"><a href="{{ $dataSet['link_five'] }}"
                                            class="text-theme" target="_blank"><i class="fa-solid fa-arrow-right-long"></i>
                                            Refund
                                            Policy</a></li>
                                @endif
                                @if ($dataSet['link_six'] != '')
                                    <li class="m-0 text-mode text-justify d-block"><a href="{{ $dataSet['link_six'] }}"
                                            class="text-theme" target="_blank"><i class="fa-solid fa-arrow-right-long"></i>
                                            Risk Warning Notice</a></li>
                                @endif
                                @if ($dataSet['link_seven'] != '')
                                    <li class="m-0 text-mode text-justify d-block"><a href="{{ $dataSet['link_seven'] }}"
                                            class="text-theme" target="_blank"><i class="fa-solid fa-arrow-right-long"></i>
                                            Terms and
                                            Conditions</a></li>
                                @endif
                            </ul>
                        </div>
                    @endif
                    <button type="submit" class="btn btn-primary btn-block mb-2 theme-btn">Login</button>
                </form>
                <div class="row">
                    <div class="col-7">
                        <small class="m-0 text-mode">don't have an account? <a href="{{ route('register') }}"
                                class="text-theme">Register</a></small>
                    </div>
                    <div class="col-5">
                        <p class="text-right">
                            <small class="m-0 text-mode"><a href="{{ route('password.request') }}"
                                    class="text-theme">Forgot
                                    Password?</a></small>
                        </p>
                    </div>
                </div>
            </div>
            {{-- /.card-body --}}
        </div>
        <!-- /.card -->
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
