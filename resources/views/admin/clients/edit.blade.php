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
                        <h1>Edit Clients</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ DiligentCreators('dashboard_url') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.clients.index') }}">Client List</a></li>
                            <li class="breadcrumb-item active">Edit Client</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main content -->
        <section class="content">

            <div class="row">

                <div class="col-md-3">
                    <!-- Profile Image -->
                    <div class="card card-primary card-outline" style="height: calc(100% - 15px)">
                        <div class="card-body box-profile">
                            <a href="{{ route('admin.clients.show', $data->id) }}">
                                <div class="text-center">
                                    <img class="profile-user-img img-fluid img-circle"
                                        src="{{ asset('avatars/avatar.jpg') }}" alt="User profile picture">
                                </div>
                                <h3 class="profile-username text-center text-theme">{{ $data->first_name }}
                                    {{ $data->last_name }}
                                </h3>
                            </a>
                            @if ($data->username != '')
                                <p class="text-muted text-center">{{ '@' . $data->username }}</p>
                            @endif

                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item text d-flex justify-content-between align-items-center">
                                    <b>Age</b>
                                    <span class="px-2 py-1 rounded text-white bg-theme">{{ $age }}</span>
                                </li>
                                <li class="list-group-item text d-flex justify-content-between align-items-center">
                                    <b>Country</b>
                                    <span
                                        class="px-2 py-1 rounded text-white bg-theme">{{ GetCountry($data->country) }}</span>
                                </li>
                                @if ($data->state != null)
                                    <li class="list-group-item text d-flex justify-content-between align-items-center">
                                        <b>State</b>
                                        <span
                                            class="px-2 py-1 rounded text-white bg-theme">{{ GetState($data->state) }}</span>
                                    </li>
                                @endif
                                @if ($data->city != null)
                                    <li class="list-group-item text d-flex justify-content-between align-items-center">
                                        <b>City</b>
                                        <span
                                            class="px-2 py-1 rounded text-white bg-theme">{{ GetCity($data->city) }}</span>
                                    </li>
                                @endif
                                <li class="list-group-item border-0 text d-flex justify-content-between align-items-center">
                                    <div class="button-group w-100">
                                        <a href="{{ URL::to('admin/clients/' . $data->id) }}/loginAs"
                                            class="btn btn-sm w-100 mb-2 btn-white btn-success">Login as
                                            {{ $data->first_name }}</a>
                                        @if ($data->is_verified == 0)
                                            <a href="{{ URL::to('admin/clients/' . $data->id) }}/edit?status=1&id={{ $data->id }}"
                                                class="btn btn-sm w-100 mb-2 btn-white btn-danger">Email Not Verified</a>
                                        @endif
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>

                <div class="col-md-9">
                    <!-- Personal Information -->
                    <div class="card" id="information">
                        <div class="card-header">
                            <h3 class="card-title my-2">Personal Information</h3>
                        </div>
                        <form action="{{ route('admin.clients.update', $data->id) }}#information" method="post"
                            id="submitForm">
                            @csrf
                            @method('put')
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label for="first_name">First Name</label>
                                            <input type="text" name="first_name" class="form-control" id="first_name"
                                                value="{{ old('first_name', $data->first_name) }}" maxlength="255"
                                                required />
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label for="last_name">Last Name</label>
                                            <input type="text" name="last_name" class="form-control" id="last_name"
                                                value="{{ old('last_name', $data->last_name) }}" maxlength="255"
                                                required />
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label for="dob">Date Of Birth</label>
                                            <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                                <input type="text" name="dob"
                                                    class="form-control datetimepicker-input" data-target="#reservationdate"
                                                    value="{{ old('dob', $data->dob) }}" required id="dob" />
                                                <div class="input-group-append" data-target="#reservationdate"
                                                    data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-header">
                                <h3 class="card-title my-2">Contact Information</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" name="email" class="form-control" id="email"
                                                value="{{ old('email', $data->email) }}" email="true"
                                                maxlength="255" required />
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="mobile">Phone Number</label>
                                            <input type="text" name="mobile" class="form-control" id="mobile"
                                                value="{{ old('mobile', $data->mobile) }}" number="true"
                                                maxlength="255" required />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-header">
                                <h3 class="card-title my-2">Location Information</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-3 col-md-3 col-sm-12">
                                        <div class="form-group">
                                            <label for="zip_code">Zip / Postal Code</label>
                                            <input type="text" class="form-control" value="{{ $data->zip_code }}"
                                                disabled />
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-12">
                                        <div class="form-group">
                                            <label for="country">Country</label>
                                            <input type="text" class="form-control"
                                                value="{{ GetCountry($data->country) }}" disabled />
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-12">
                                        <div class="form-group">
                                            <label for="state">State</label>
                                            <input type="text" class="form-control"
                                                value="{{ GetState($data->state) }}" disabled />
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-12">
                                        <div class="form-group">
                                            <label for="city">City</label>
                                            <input type="text" class="form-control"
                                                value="{{ GetCity($data->city) }}" disabled />
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-12">
                                        <div class="form-group">
                                            <label for="company">Company</label>
                                            <input type="text" name="company" class="form-control" id="company"
                                                value="{{ old('company', $data->company) }}" maxlength="255" />
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-12">
                                        <div class="form-group">
                                            <label for="house_number">House / Flat No.</label>
                                            <input type="text" name="house_number" class="form-control"
                                                id="house_number"
                                                value="{{ old('house_number', $data->house_number) }}"
                                                maxlength="255" required />
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-12">
                                        <div class="form-group">
                                            <label for="address1">Address</label>
                                            <input type="text" name="address1" class="form-control" id="address1"
                                                value="{{ old('address1', $data->address1) }}" maxlength="255"
                                                required />
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-12">
                                        <div class="form-group">
                                            <label for="address2">Address Optional</label>
                                            <input type="text" name="address2" class="form-control" id="address2"
                                                value="{{ old('address2', $data->address2) }}" maxlength="255" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- location -->
                    <div class="card mt-4" id="location">
                        <div class="card-header">
                            <h3 class="card-title my-2">Location Information</h3>
                        </div>
                        <form action="{{ route('admin.clients.update', $data->id) }}#location" method="post"
                            id="locationSubmitForm">
                            @csrf
                            @method('put')
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-3 col-md-3 col-sm-12">
                                        <div class="form-group">
                                            <label for="zip_code">Zip / Postal Code</label>
                                            <input type="text" class="form-control" name="zip_code"
                                                value="{{ old('zip_code', $data->zip_code) }}" number="true"
                                                maxlength="255" required />
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-12">
                                        <div class="form-group">
                                            <label for="country">Country</label>
                                            <select name="country" class="form-control country" id="country" required>
                                                <option value="">-- Select Country --</option>
                                                @foreach ($countries as $country)
                                                    <option value="{{ $country->id }}">
                                                        {{ $country->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-12">
                                        <div class="form-group">
                                            <label for="state">State</label>
                                            <select name="state" class="form-control state" id="state" required>
                                                <option value="">-- Select State --</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-12">
                                        <div class="form-group">
                                            <label for="city">Select City</label>
                                            <select name="city" class="form-control city" id="city" required>
                                                <option value="">-- Select City --</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" name="location" class="btn btn-flat btn-success">Update</button>
                                <p class="m-0 mt-2 text text-muted">Last Updated: {{ TimeAgo($data->updated_at) }} on
                                    {{ DateFormat($data->updated_at) . ' ' . TimeFormat($data->updated_at) }}
                                </p>
                            </div>
                        </form>
                    </div>

                    <!-- Change Password -->
                    <div class="card mt-4" id="security">
                        <div class="card-header">
                            <h3 class="card-title my-2">Change Password</h3>
                        </div>
                        <form action="{{ route('admin.clients.update', $data->id) }}#security" method="post"
                            id="securitySubmitForm">
                            @csrf
                            @method('put')
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <label for="password">New Password</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="password"
                                                    id="password" value="{{ old('password') }}" minlength="8"
                                                    maxlength="64" required />
                                                <div class="input-group-append">
                                                    <button type="button" name="security" id="generatePasswordBtn"
                                                        class="btn btn-primary btn-theme input-group-text">Generate</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" name="security" class="btn btn-flat btn-success">Update</button>
                                <p class="m-0 mt-2 text text-muted">Last Updated: {{ TimeAgo($data->updated_at) }} on
                                    {{ DateFormat($data->updated_at) . ' ' . TimeFormat($data->updated_at) }}
                                </p>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
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
        $('#reservationdate').datetimepicker({
            format: 'yyyy-MM-DD',
        });

        // Initialize Select2 Elements
        $('.country').select2({
            theme: 'bootstrap4'
        });
        $('.state').select2({
            theme: 'bootstrap4'
        });
        $('.city').select2({
            theme: 'bootstrap4'
        });
        $('.account_type_id').select2({
            theme: 'bootstrap4'
        });
        $('.account_status_id').select2({
            theme: 'bootstrap4'
        });
        $('.kyc_status_id').select2({
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

        $('#generatePasswordBtn').click(function(e) {
            let characters = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
            let result = '';
            for (let i = 0; i < 8; i++) {
                result += characters.charAt(Math.floor(Math.random() * characters.length));
            }
            $("#password").val(result);
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

        $('#locationSubmitForm').validate({
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

        $('#securitySubmitForm').validate({
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

        $('#bacnkAccountSubmitForm').validate({
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
