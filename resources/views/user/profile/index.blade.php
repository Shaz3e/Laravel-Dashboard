@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <!-- daterange picker -->
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection

@section('content')
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
                            <li class="breadcrumb-item active">User Profile</li>
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

                                <h3 class="profile-username text-center text-theme">{{ $data->first_name }}
                                    {{ $data->last_name }}
                                </h3>
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
                                    <li class="list-group-item text d-flex justify-content-between align-items-center">
                                        <b>Trading Accounts</b>
                                        <span
                                            class="px-2 py-1 rounded text-white bg-theme">{{ $totalTradingAccountdataSet }}</span>
                                    </li>
                                    <li class="list-group-item text d-flex justify-content-between align-items-center">
                                        <b>Wallet</b>
                                        <span
                                            class="px-2 py-1 rounded text-white bg-theme">${{ number_format(GetWalletAmount(auth()->user()->id), 2) }}</span>
                                    </li>
                                </ul>
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
                                        <a class="nav-link {{ isset($_GET['tab']) && $_GET['tab'] == 'profile' ? 'active' : '' }}"
                                            href="?tab=profile">Edit Profile</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ isset($_GET['tab']) && $_GET['tab'] == 'kyc' ? 'active' : '' }}"
                                            href="?tab=kyc">KYC
                                            @if (auth()->user()->kyc_status_id == 1)
                                                <span class="badge badge-warning">Pending</span>
                                            @elseif (auth()->user()->kyc_status_id == 2)
                                                <span class="badge badge-danger">Rejected</span>
                                            @elseif (auth()->user()->kyc_status_id == 4)
                                                <span class="badge badge-primary">Hold</span>
                                            @else
                                                <span class="badge badge-success">Approved</span>
                                            @endif
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ isset($_GET['tab']) && $_GET['tab'] == 'security' ? 'active' : '' }}"
                                            href="?tab=security">Change Password</a>
                                    </li>
                                </ul>
                            </div>
                            <!-- /.card-header -->

                            <div class="card-body">
                                <div class="tab-content">

                                    {{-- Profile --}}
                                    <div class="tab-pane {{ isset($_GET['tab']) && $_GET['tab'] == 'profile' ? 'active' : '' }}"
                                        id="profile">
                                        <form action="{{ route('profile.update') }}" method="POST" class="form-horizontal"
                                            id="submitForm">
                                            @csrf
                                            <div class="form-group row">
                                                <label for="email" class="col-sm-2 col-form-label">Email</label>
                                                <div class="col-sm-10  feedback">
                                                    <input type="email" name="email"
                                                        value="{{ old('email', $data->email) }}" class="form-control"
                                                        id="email" placeholder="Email" disabled />
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="first_name" class="col-sm-2 col-form-label">First Name</label>
                                                <div class="col-sm-10  feedback">
                                                    <input type="text" name="first_name" class="form-control"
                                                        id="first_name" value="{{ old('first_name', $data->first_name) }}"
                                                        placeholder="First Name" disabled />
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="last_name" class="col-sm-2 col-form-label">Last Name</label>
                                                <div class="col-sm-10  feedback">
                                                    <input type="text" name="last_name" class="form-control"
                                                        id="last_name" value="{{ old('last_name', $data->last_name) }}"
                                                        placeholder="Last Name" disabled />
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="username" class="col-sm-2 col-form-label">User Name
                                                    (Optional)</label>
                                                <div class="col-sm-10 feedback">
                                                    <input type="text" name="username" class="form-control"
                                                        id="username" value="{{ old('username', $data->username) }}"
                                                        placeholder="User Name" maxlength="50" />
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="mobile" class="col-sm-2 col-form-label">Mobile</label>
                                                <div class="col-sm-10 feedback">
                                                    <input type="text" name="mobile" class="form-control"
                                                        id="mobile" value="{{ old('mobile', $data->mobile) }}"
                                                        placeholder="Mobile" disabled />
                                                </div>
                                            </div>
                                            <!-- <div class="form-group row">                                                                                                                                                                                  </div>
                                                                                                                                                                                                                                                                            </div> -->
                                            <div class="form-group row">
                                                <label for="company" class="col-sm-2 col-form-label">Company</label>
                                                <div class="col-sm-10  feedback">
                                                    <input type="text" name="company" class="form-control"
                                                        id="company" value="{{ old('company', $data->company) }}"
                                                        placeholder="Company" />
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="house_number" class="col-sm-2 col-form-label">House / Flat
                                                    No.</label>
                                                <div class="col-sm-10 feedback">
                                                    <input type="text" name="house_number" class="form-control"
                                                        id="house_number"
                                                        value="{{ old('house_number', $data->house_number) }}"
                                                        placeholder="House / Flat No." required />
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="address1" class="col-sm-2 col-form-label">Address</label>
                                                <div class="col-sm-10 feedback">
                                                    <input type="text" name="address1" class="form-control"
                                                        id="address1" value="{{ old('address1', $data->address1) }}"
                                                        placeholder="Address" required />
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="address2" class="col-sm-2 col-form-label">Address
                                                    (Optional)</label>
                                                <div class="col-sm-10 feedback">
                                                    <input type="text" name="address2" class="form-control"
                                                        id="address2" value="{{ old('address2', $data->address2) }}"
                                                        placeholder="Address (Optional)" maxlength="255" />
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

                                    {{-- KYC Dcoument --}}
                                    <div class="tab-pane {{ isset($_GET['tab']) && $_GET['tab'] == 'kyc' ? 'active' : '' }}"
                                        id="kyc">
                                        <form action="{{ route('profile.kyc') }}" method="post" id="uploadKYC"
                                            enctype="multipart/form-data">
                                            @csrf
                                            {{-- KYC content Pending  --}}
                                            @if (auth()->user()->kyc_status_id == 1)
                                                <div class="row">

                                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                                        <div class="form-group">
                                                            <label for="id_card_number">Card Number</label>
                                                            <input type="text" name="id_card_number"
                                                                id="id_card_number" class="form-control" required />
                                                            <small class="form-text text-muted">National ID Card
                                                                number</small>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-8 col-md-8 col-sm-12">
                                                        <div class="form-group">
                                                            <label for="id_proof_address">Proof Address</label>
                                                            <input type="text" name="id_proof_address"
                                                                id="id_proof_address" class="form-control" required />
                                                            <small class="form-text text-muted">ID Proof Address</small>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                                        <div class="form-group">
                                                            <label for="id_side_a">Front Side</label>
                                                            <div class="input-group">
                                                                <div class="custom-file">
                                                                    <input type="file" class="custom-file-input"
                                                                        id="id_side_a" name="id_side_a"
                                                                        accept="image/jpeg, image/jpg, image/png"
                                                                        filesize="2048" required>
                                                                    <label class="custom-file-label" for="id_side_a">
                                                                        <span id="show_id_side_a">Choose
                                                                            File</span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <small class="form-text text-muted">Color copy of
                                                                identification (Front Side)</small>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                                        <div class="form-group">
                                                            <label for="id_side_b">Back Side</label>
                                                            <div class="input-group">
                                                                <div class="custom-file">
                                                                    <input type="file" class="custom-file-input"
                                                                        id="id_side_b" name="id_side_b"
                                                                        accept="image/jpeg, image/jpg, image/png"
                                                                        filesize="2048" required>
                                                                    <label class="custom-file-label" for="id_side_b">
                                                                        <span id="show_id_side_b">Choose
                                                                            File</span>
                                                                    </label>
                                                                </div>
                                                            </div>

                                                            <small class="form-text text-muted">Color copy of
                                                                identification (Back Side)</small>
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="muted">Attaching your proof of identification and address
                                                    documents will fast the process of opening your trading account. You
                                                    may also upload your proof of identification and address via
                                                    <strong>{{ DiligentCreators('site_name') }}</strong> at a later
                                                    stage.
                                                </p>
                                                <p>
                                                    Documents required must be in jpg, jpeg, png, and should
                                                    be 2MB file size.
                                                </p>
                                                <div class="form-group">
                                                    <label for="proof_address">
                                                        Proof of address
                                                    </label>
                                                    <div class="input-group">
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input"
                                                                id="proof_address" name="proof_address"
                                                                accept="image/jpeg, image/jpg, image/png"
                                                                filesize="2048" required>
                                                            <label class="custom-file-label" for="proof_address">
                                                                <span id="show_proof_address">
                                                                    Choose File
                                                                </span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="muted">
                                                    Passport, national identity or other document issued by an
                                                    independent and reliable source that carries your photo.
                                                    Photograph, signature, issue & expiry dates, personal
                                                    details including serial number must be clearly visible
                                                </p>
                                                <p>
                                                    Documents required must be in jpg, jpeg, png, and should
                                                    be 2MB file size.
                                                </p>
                                                <button type="submit" name="uploadKYC" class="btn btn-primary">
                                                    Upload Documents
                                                </button>
                                                {{-- KYC content Reject  --}}
                                            @elseif (auth()->user()->kyc_status_id == 2)
                                                <div class="alert alert-danger">
                                                    Your KYC documents was not approved kindly
                                                    contact us via email at
                                                    {{ DiligentCreators('to_email') == null ? env('MAIL_FROM_ADDRESS') : DiligentCreators('to_email') }}
                                                </div>
                                                <div class="row">

                                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                                        <div class="form-group">
                                                            <label for="id_side_a">Card Number</label>
                                                            <input type="text" name="id_card_number"
                                                                id="id_card_number" class="form-control" required />
                                                            <small class="form-text text-muted">National ID Card
                                                                number</small>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-8 col-md-8 col-sm-12">
                                                        <div class="form-group">
                                                            <label for="id_proof_address">Proof Address</label>
                                                            <input type="text" name="id_proof_address"
                                                                id="id_proof_address" class="form-control" required />
                                                            <small class="form-text text-muted">ID Proof Address</small>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                                        <div class="form-group">
                                                            <label for="id_side_a">Front Side</label>
                                                            <div class="input-group">
                                                                <div class="custom-file">
                                                                    <input type="file" class="custom-file-input"
                                                                        id="id_side_a" name="id_side_a"
                                                                        accept="image/jpeg, image/jpg, image/png"
                                                                        filesize="2048" required>
                                                                    <label class="custom-file-label" for="id_side_a">
                                                                        <span id="show_id_side_a">Choose
                                                                            File</span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <small class="form-text text-muted">Color copy of
                                                                identification (Front Side)</small>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                                        <div class="form-group">
                                                            <label for="id_side_b">Back Side</label>
                                                            <div class="input-group">
                                                                <div class="custom-file">
                                                                    <input type="file" class="custom-file-input"
                                                                        id="id_side_b" name="id_side_b"
                                                                        accept="image/jpeg, image/jpg, image/png"
                                                                        filesize="2048" required>
                                                                    <label class="custom-file-label" for="id_side_b">
                                                                        <span id="show_id_side_b">Choose
                                                                            File</span>
                                                                    </label>
                                                                </div>
                                                            </div>

                                                            <small class="form-text text-muted">Color copy of
                                                                identification (Back Side)</small>
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="muted">Attaching your proof of identification and address
                                                    documents will fast the process of opening your trading account. You
                                                    may also upload your proof of identification and address via
                                                    <strong>{{ DiligentCreators('site_name') }}</strong> at a later
                                                    stage.
                                                </p>
                                                <p>
                                                    Documents required must be in jpg, jpeg, png, and should
                                                    be 2MB file size.
                                                </p>
                                                <div class="form-group">
                                                    <label for="proof_address">
                                                        Proof of address
                                                    </label>
                                                    <div class="input-group">
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input"
                                                                id="proof_address" name="proof_address"
                                                                accept="image/jpeg, image/jpg, image/png"
                                                                filesize="2048" required>
                                                            <label class="custom-file-label" for="proof_address">
                                                                <span id="show_proof_address">
                                                                    Choose File
                                                                </span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="muted">
                                                    Passport, national identity or other document issued by an
                                                    independent and reliable source that carries your photo.
                                                    Photograph, signature, issue & expiry dates, personal
                                                    details including serial number must be clearly visible
                                                </p>
                                                <p>
                                                    Documents required must be in jpg, jpeg, png, and should
                                                    be 2MB file size.
                                                </p>
                                                <button type="submit" name="uploadKYC" class="btn btn-primary">
                                                    Upload Documents
                                                </button>
                                                {{-- KYC content On Success  --}}
                                            @elseif (auth()->user()->kyc_status_id == 3)
                                                <div class="alert alert-success">
                                                    Your KYC is approved successfully.
                                                </div>
                                                {{-- KYC content On Hold  --}}
                                            @elseif (auth()->user()->kyc_status_id == 4)
                                                <div class="alert bg-theme">
                                                    Your KYC request is pending for review.
                                                </div>
                                            @endif
                                        </form>
                                    </div>
                                    <!-- /.tab-pane -->

                                    {{-- Security --}}
                                    <div class="tab-pane {{ isset($_GET['tab']) && $_GET['tab'] == 'security' ? 'active' : '' }}"
                                        id="security">
                                        <form action="{{ route('profile.update') }}" method="POST"
                                            class="form-horizontal" id="securityForm">
                                            @csrf
                                            <div class="form-group row">
                                                <label for="password" class="col-sm-2 col-form-label">Current
                                                    Password</label>
                                                <div class="col-sm-10 feedback">
                                                    <input type="text" name="password" value="{{ old('password') }}"
                                                        class="form-control" id="password"
                                                        placeholder="Current Password" required />
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="new_password" class="col-sm-2 col-form-label">New
                                                    Password</label>
                                                <div class="col-sm-10 feedback">
                                                    <input type="text" name="new_password"
                                                        value="{{ old('new_password') }}" class="form-control"
                                                        id="new_password" placeholder="New Password" required />
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="confirm_new_password" class="col-sm-2 col-form-label">Confirm
                                                    New Password</label>
                                                <div class="col-sm-10 feedback">
                                                    <input type="text" name="confirm_new_password"
                                                        value="{{ old('confirm_new_password') }}" class="form-control"
                                                        id="confirm_new_password" placeholder="Confirm New Password"
                                                        required />
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


                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="card mt-2">
                            <div class="card-header">
                                <h3 class="card-title">Login History</h3>
                            </div>

                            <div class="card-body">
                                <table id="dataList2" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Browser</th>
                                            <th>OS</th>
                                            <th>Device</th>
                                            <th>IP</th>
                                            <th>Date</th>
                                            <th>Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($loginHistory as $login)
                                            <tr>
                                                <td>{{ $login->browser }}</td>
                                                <td>{{ $login->os }}</td>
                                                <td>{{ $login->device }}</td>
                                                <td>{{ $login->ip_address }}</td>
                                                <td>{{ DateFormat($login->date_time) }}</td>
                                                <td>{{ TimeFormat($login->date_time) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection

@section('scripts')
    <!-- DataTables  & Plugins -->
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    {{-- Select --}}
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    {{-- Validation --}}
    <script src="{{ asset('plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('plugins/jquery-validation/additional-methods.min.js') }}"></script>
    {{-- Date Picker --}}
    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('plugins/inputmask/jquery.inputmask.min.js') }}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <script>
        // Initialize Datatable
        $(function() {
            $("#dataList").DataTable({
                "order": [
                    [0, "desc"]
                ],
                "responsive": true,
                "lengthChange": true,
                "autoWidth": true,
            })
            $("#dataList2").DataTable({
                "order": [
                    [0, "desc"]
                ],
                "responsive": true,
                "lengthChange": true,
                "autoWidth": true,
            })
        });
        // Initialize Select2 Elements
        $('.account_type_id').select2({
            theme: 'bootstrap4'
        });
        //Date picker
        $('#reservationdate').datetimepicker({
            format: 'yyyy-MM-DD',
        });

        $.validator.addMethod("noSpace", function(value, element) {
            return /^[a-zA-Z0-9_.-]+$/.test(value);
        }, "No space please and don't leave it empty");

        jQuery.validator.addMethod("alphanumeric", function(value, element) {
            return this.optional(element) || /^[a-zA-Z0-9]*$/.test(value);
        }, "Please enter only letters and numbers.");

        $('#submitForm').validate({
            rules: {
                username: {
                    alphanumeric: true,
                },
            },
            messages: {
                username: {
                    alphanumeric: "Username must contain alphabet or number no special character or spaces are allowed.",
                }
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.feedback').append(error);
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
                element.closest('.feedback').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
        jQuery(function($) {
            $("#uploadKYC").validate({
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
                    $(element).addClass('is-valid');
                }
            });
        });
        $('#tradingAccountForm').validate({
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

        $("#id_side_a").change(function() {
            $("#show_id_side_a").text(this.files[0].name);
        });

        $("#id_side_b").change(function() {
            $("#show_id_side_b").text(this.files[0].name);
        });

        $("#proof_address").change(function() {
            $("#show_proof_address").text(this.files[0].name);
        });
    </script>
@endsection
