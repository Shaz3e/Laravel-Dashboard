@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <!-- daterange picker -->
    <link rel="stylesheet" href="../../plugins/daterangepicker/daterangepicker.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="../../plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
@endsection

@section('content')
@foreach ($dataSet as $data)
@endforeach

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Profile</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Profile</li>
                        </ol>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-3">
                        <!-- Profile Image -->
                        <div class="card card-primary card-outline" style="height: calc(100% - 15px)">
                            <div class="card-body box-profile">
                                <div class="text-center">
                                    <img class="profile-user-img img-fluid img-circle"
                                        src="{{ asset('avatars/avatar.jpg') }}" alt="User profile picture">
                                </div>

                                <h3 class="profile-username text-center text-theme">{{ $data->name }}</h3>
                                <p class="text-muted text-center">{{ '@' . $data->username }}</p>

                                {{-- <ul class="list-group list-group-unbordered mb-3">
                                    <li class="list-group-item text d-flex justify-content-between align-items-center">
                                        <b>Trading Accounts</b>
                                        <span class="px-2 py-1 rounded text-white bg-theme">5</span>
                                    </li>
                                    <li class="list-group-item text d-flex justify-content-between align-items-center">
                                        <b>Wallet</b>
                                        <span class="px-2 py-1 rounded text-white bg-theme">$1,200</span>
                                    </li>
                                    <li class="list-group-item text d-flex justify-content-between align-items-center">
                                        <b>Friends</b>
                                        <span class="px-2 py-1 rounded text-white bg-theme">13,287</span>
                                    </li>
                                </ul>

                                <a href="#" class="btn btn-primary btn-theme btn-block"><b>Follow</b></a> --}}
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->

                    </div>
                    <!-- /.col -->

                    <div class="col-md-9">
                        <div class="card" style="height: calc(100% - 15px)">
                            <div class="card-header p-2">
                                <ul class="nav nav-pills">
                                    <li class="nav-item">
                                        <a class="nav-link active" href="#profile" data-toggle="tab">Profile</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#security" data-toggle="tab">Security</a>
                                    </li>
                                </ul>
                            </div>
                            <!-- /.card-header -->

                            <div class="card-body">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="profile">
                                        <form action="{{ route('admin.profile.store') }}" method="POST" class="form-horizontal">
                                            @csrf
                                            <div class="form-group row">
                                                <label for="email" class="col-sm-2 col-form-label">Email</label>
                                                <div class="col-sm-10">
                                                    <input type="email" name="email" value="{{ old('email', $data->email) }}"
                                                        class="form-control" id="email" placeholder="Email" {{--required--}} />
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="name" class="col-sm-2 col-form-label">Name</label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="name" class="form-control"
                                                        id="name" value="{{ old('name', $data->name) }}"
                                                        placeholder="First Name" {{--required--}} />
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="username" class="col-sm-2 col-form-label">User Name</label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="username" class="form-control"
                                                        id="username" value="{{ old('username', $data->username) }}"
                                                        placeholder="username" {{--required--}} />
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="offset-sm-2 col-sm-10">
                                                    <button type="submit" class="btn btn-danger">Save Changes</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- /.tab-pane -->

                                    <div class="tab-pane" id="security">
                                        <form action="{{ route('admin.profile.store') }}" method="POST" class="form-horizontal">
                                            @csrf
                                            <div class="form-group row">
                                                <label for="password" class="col-sm-2 col-form-label">Current Password</label>
                                                <div class="col-sm-10">
                                                    <input type="password" name="password" value="{{ old('password') }}"
                                                        class="form-control" id="password" placeholder="Current Password" {{--required--}} />
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="new_password" class="col-sm-2 col-form-label">New Password</label>
                                                <div class="col-sm-10">
                                                    <input type="password" name="new_password" value="{{ old('new_password') }}"
                                                        class="form-control" id="new_password" placeholder="New Password" {{--required--}} />
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="confirm_new_password" class="col-sm-2 col-form-label">Confirm New Password</label>
                                                <div class="col-sm-10">
                                                    <input type="password" name="confirm_new_password" value="{{ old('confirm_new_password') }}"
                                                        class="form-control" id="confirm_new_password" placeholder="Confirm New Password" {{--required--}} />
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="offset-sm-2 col-sm-10">
                                                    <button type="submit" class="btn btn-danger">Save Changes</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- /.tab-pane -->
                                </div>
                                <!-- /.tab-content -->
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection

@section('scripts')
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

        $.validator.addMethod("noSpace", function(value, element) {
            return /^[a-zA-Z0-9_.-]+$/.test(value);
        }, "No space please and don't leave it empty");

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
        $('#securityForm').validate({
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
