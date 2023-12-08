@extends('layouts.other-app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <!-- daterange picker -->
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
@endsection

@section('body_class')
    register-page
@endsection

@section('content')
    <div class="register-box">

        <div class="text-center mb-2">
            <a href="{{ DiligentCreators('site_url') }}">
                <img class="img-fluid" src="{{ asset('/') }}{{ DiligentCreators('site_logo') }}" alt="{{ DiligentCreators('site_name') == null ? config('app.name') : DiligentCreators('site_name') }}">
            </a>
        </div>

        <div class="card card-outline my-4 card-primary">
            <div class="card-header text-center">
                <p class="login-box-msg p-0 m-0">Register a new account</p>
                <p class="login-box-msg p-0 mt-2">
                    <font class="fas fa-lock"></font> End-to-end encypted
                </p>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('register') }}" id="submitForm">
                    @csrf
                    <div class="form-group mb-3">
                        <div class="input-group">
                            <input type="text" class="form-control" name="first_name" value="{{ old('first_name') }}"
                                placeholder="Full name" required />
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-user"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <div class="input-group">
                            <input type="text" class="form-control" name="last_name" value="{{ old('last_name') }}"
                                placeholder="Last name" noSpace="true" required />
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-user"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <div class="input-group">
                            <input type="email" class="form-control" name="email" value="{{ old('email') }}"
                                placeholder="Email" email="true" required />
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <div class="input-group">
                            <input type="password" class="form-control" name="password"
                                placeholder="Password" id="password" required />
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fa-solid fa-key"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <div class="input-group">
                            <input type="password" class="form-control" name="confirm_password"
                                placeholder="Confirm Password" id="confirm_password" required />
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fa-solid fa-key"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if (DiligentCreators('enable_country') == 1)
                    <div class="form-group mb-3">
                        <div class="input-group">
                            <select name="country" class="form-control select2b4" id="country" required>
                                <option value="">Country</option>
                                @foreach ($countries as $country)
                                    <option value="{{ $country->id }}">
                                        {{ $country->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-earth-asia"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    @if (DiligentCreators('enable_state') == 1)
                        <div class="form-group mb-3">
                            <div class="input-group">
                                <select name="state" class="form-control select2b4" id="state" required>
                                    <option value="">State</option>
                                </select>
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-earth-asia"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if (DiligentCreators('enable_state') == 1 && DiligentCreators('enable_city') == 1)
                        <div class="form-group mb-3">
                            <div class="input-group">
                                <select name="city" class="form-control select2b4" id="city" required>
                                    <option value="">City</option>
                                </select>
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-earth-asia"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if(DiligentCreators('enable_mobile') == 1)
                    <div class="form-group mb-3">
                        <div class="input-group">
                            <input type="text" class="form-control" name="mobile" id="mobile"
                                value="{{ old('mobile') }}" placeholder="Phone Number" required />
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-phone"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    @if (DiligentCreators('dob_is_active') == 1)
                        <div class="form-group mb-3">
                            <div class="input-group mb-3 date" id="dob" data-target-input="nearest">
                                <input type="text" name="dob" placeholder="Date Of Birth (YYYY-MM-DD)"
                                    class="form-control datetimepicker-input" data-target="#dob"
                                    value="{{ old('dob') }}" required id="dob" />
                                <div class="input-group-append" data-target="#dob" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if (DiligentCreators('google_recaptcha') == 1)
                        <div class="col-12">
                            <div class="form-group">
                                <div class="g-recaptcha" data-sitekey="{{ DiligentCreators('google_site_key') }}">
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="form-group mb-3">
                        <div class="icheck-primary">
                            <input type="checkbox" id="agreeTerms" name="terms" value="agree"
                                {{ old('terms') ? 'checked' : '' }} required>
                            <label for="agreeTerms" class="text-mode">
                                I agree to the terms above.
                            </label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block mb-2 theme-btn">Register</button>
                </form>
                <small class="m-0 text-mode">already have an account? <a href="{{ route('login') }}"
                        class="text-theme">Login</a></small>
            </div>
            <!-- /.form-box -->
        </div>
        <!-- /.card -->
    </div>
@endsection



@section('scripts')
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('plugins/jquery-validation/additional-methods.min.js') }}"></script>
    {{-- Date Picker --}}
    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('plugins/inputmask/jquery.inputmask.min.js') }}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <script>
        //Date picker
        $('#dob').datetimepicker({
            format: 'yyyy-MM-DD',
        });

        // Initialize Select2 Elements
        $('.select2b4').select2({
            theme: 'bootstrap4'
        });


        @if(DiligentCreators('enable_country'))
        // On Country Change Actions
        $('#country').on('change', function() {
            let country = this.value;
            if (country) {
                // Get States
                $.ajax({
                    url: `/states/by-country/${country}`,
                    type: 'GET',
                    dataType: 'json',
                    success: function(dataSet) {
                        $('#state').empty();
                        let output = `<option value="">State</option>`;
                        $.each(dataSet, function(key, data) {
                            output = output +
                                `<option value="${data.id}">${data.state_name}</option>`;
                        });
                        $('#state').append(output);
                    }
                });
                // Get Phone Code
                $.ajax({
                    url: `/get-country-code/${country}`, // Correct URL endpoint
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        console.log("Data from server:", data);
                        if (data.internalCode) {
                            $('input[name="mobile"]').val(data.internalCode); // Update mobile input
                        } else {
                            $('input[name="mobile"]').val(''); // Clear mobile input
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Error:", error);
                    }
                });
            } else {
                $('#state').html('<option value="">Country</option>');
                $('input[name="mobile"]').val(''); // Clear mobile input if no country selected
            }
        });
        @endif

        @if(DiligentCreators('enable_state'))
        // On State Change Actions
        $('#state').on('change', function() {
            let state = this.value;
            if (state) {
                $.ajax({
                    url: `/cities/by-state/${state}`,
                    type: 'GET',
                    dataType: 'json',
                    success: function(dataSet) {
                        $('#city').empty();
                        let output = `<option value="">City</option>`;
                        $.each(dataSet, function(key, data) {
                            output = output +
                                `<option value="${data.id}">${data.city_name}</option>`;
                        });
                        $('#city').append(output);
                    }
                });
            } else {
                $('#city').html('<option value="">Select City</option>');
            }
        });
        @endif

        $.validator.addMethod("noSpace", function(value, element) {
            return /^[a-zA-Z0-9_.-]+$/.test(value);
        }, "No space please and don't leave it empty");

        $('#submitForm').validate({
            // rules: {
            //     password: {
            //         required: true,
            //         minlength: 8,
            //         maxlength: 32,
            //     },
            //     confirm_password: {
            //         required: true,
            //         equalTo: '#password',
            //     }
            // },
            // messages: {
            //     password: {
            //         required: 'Please enter a password',
            //         minlength: 'Password must be at least {0} characters long',
            //         maxlength: 'Password must be at most {0} characters long'
            //     },
            //     confirm_password: {
            //         required: 'Please enter the same password again',
            //         equalTo: 'Passwords do not match',
            //     }
            // },
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
