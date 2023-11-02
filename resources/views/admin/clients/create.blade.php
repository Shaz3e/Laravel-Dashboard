@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <!-- daterange picker -->
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
    <!-- Tempusdominus Bootstrap 4 -->
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
                        <h1>Create New Client</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ DiligentCreators('dashboard_url') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.clients.index') }}">Client List</a></li>
                            <li class="breadcrumb-item active">Create New</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <!-- Main content -->
        <section class="content">
            <!-- Default box -->
            <div class="card">
                <div class="card-header">
                    Fill the below form to create new clients
                </div>
                <form action="{{ route('admin.clients.store') }}" method="post" id="submitForm">
                    @csrf
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="username">Username</label>
                            <div class="col-sm-10">
                                <input type="text" name="username" class="form-control" value="{{ old('username') }}" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="email">Email</label>
                            <div class="col-sm-10">
                                <input type="email" name="email" class="form-control" value="{{ old('email') }}"
                                    required />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="password">Password</label>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="password" id="password"
                                        value="{{ old('password') }}" minlength="8" maxlength="64" required />
                                    <div class="input-group-append">
                                        <button type="button" name="security" id="generatePasswordBtn"
                                            class="btn btn-primary btn-theme input-group-text">Generate</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="first_name">First Name</label>
                            <div class="col-sm-10">
                                <input type="text" name="first_name" class="form-control"
                                    value="{{ old('first_name') }}" maxlength="64" required />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="last_name">Last Name</label>
                            <div class="col-sm-10">
                                <input type="text" name="last_name" class="form-control" value="{{ old('last_name') }}"
                                    maxlength="64" required />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="mobile">Mobile #</label>
                            <div class="col-sm-10">
                                <input type="text" name="mobile" class="form-control" value="{{ old('mobile') }}"
                                    required />
                            </div>
                        </div>
                        @if (DiligentCreators('dob_is_active') == 1)
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label" for="dob">Date Of Birth</label>
                                <div class="col-sm-10">
                                    <div class="input-group date" id="dob" data-target-input="nearest">
                                        <input type="text" name="dob" class="form-control datetimepicker-input"
                                            data-target="#dob" value="{{ old('dob') }}" id="dob" />
                                        <div class="input-group-append" data-target="#dob" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="country">Country</label>
                            <div class="col-sm-10">
                                <select name="country" id="country" class="form-control select2" required>
                                    <option>Select Country</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @if (DiligentCreators('enable_state') == 1)
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label" for="state">State</label>
                                <div class="col-sm-10">
                                    <select name="state" id="state" class="form-control select2">
                                        <option>Select State</option>
                                    </select>
                                </div>
                            </div>
                        @endif
                        @if (DiligentCreators('enable_city') == 1)
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label" for="city">City</label>
                                <div class="col-sm-10">
                                    <select name="city" id="city" class="form-control select2">
                                        <option>Select City</option>
                                    </select>
                                </div>
                            </div>
                        @endif
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="zip_code">Zip Code</label>
                            <div class="col-sm-10">
                                <input type="text" name="zip_code" class="form-control" number="true"
                                    value="{{ old('zip_code') }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="company">Company Name</label>
                            <div class="col-sm-10">
                                <input type="text" name="company" class="form-control" value="{{ old('company') }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="house_number">House Number</label>
                            <div class="col-sm-10">
                                <input type="text" name="house_number" class="form-control"
                                    value="{{ old('house_number') }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="address1">Address Line 1</label>
                            <div class="col-sm-10">
                                <input type="text" name="address1" class="form-control"
                                    value="{{ old('address1') }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="address2">Address Line 2</label>
                            <div class="col-sm-10">
                                <input type="text" name="address2" class="form-control"
                                    value="{{ old('address2') }}">
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
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
        $('.select2').select2({
            theme: 'bootstrap4'
        });

        $('#country').on('change', function() {
            let country = this.value;
            if (country) {
                $.ajax({
                    url: `/states/by-country/${country}`,
                    type: 'GET',
                    dataType: 'json',
                    success: function(dataSet) {
                        $('#state').empty();
                        let output = `<option value="">-- Select State --</option>`;
                        $.each(dataSet, function(key, data) {
                            output = output +
                                `<option value="${data.id}">${data.state_name}</option>`;
                        });
                        $('#state').append(output);
                    }
                });
            } else {
                $('#state').html('<option value="">-- Select Country --</option>');
            }
        });

        $('#state').on('change', function() {
            let state = this.value;
            if (state) {
                $.ajax({
                    url: `/cities/by-state/${state}`,
                    type: 'GET',
                    dataType: 'json',
                    success: function(dataSet) {
                        $('#city').empty();
                        let output = `<option value="">-- Select City --</option>`;
                        $.each(dataSet, function(key, data) {
                            output = output +
                                `<option value="${data.id}">${data.city_name}</option>`;
                        });
                        $('#city').append(output);
                    }
                });
            } else {
                $('#city').html('<option value="">-- Select City --</option>');
            }
        });

        $.validator.addMethod("noSpace", function(value, element) {
            return /^[a-zA-Z0-9_.-]+$/.test(value);
        }, "No space please and don't leave it empty");

        $('#submitForm').validate({
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group row').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });

        // Generate Button
        $('#generatePasswordBtn').click(function(e) {
            let characters = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
            let result = '';
            for (let i = 0; i < 16; i++) {
                result += characters.charAt(Math.floor(Math.random() * characters.length));
            }
            $("#password").val(result);
        });
    </script>
@endsection
