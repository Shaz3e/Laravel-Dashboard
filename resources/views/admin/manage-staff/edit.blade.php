@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
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
                        <h1>Edit Staff</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ DiligentCreators('dashboard_url') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.manage-staff.index') }}">Manage Staff</a>
                            </li>
                            <li class="breadcrumb-item active">Edit</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-8 col-md-8 col-sm-12">
                        <div class="card" style="height: calc(100% - 15px)">
                            <div class="card-header">
                                <h3 class="card-title"></h3>
                                <div class="card-tools">
                                    <a href="{{ route('admin.manage-staff.index') }}"
                                        class="btn btn-flat btn-sm btn-theme"><i class="fa-regular fa-eye"></i> View
                                        All</a>
                                </div>
                            </div>
                            <form action="{{ route('admin.manage-staff.update', $data->id) }}" method="post"
                                id="submitForm">
                                @csrf
                                @method('put')
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label for="name">Name</label>
                                                <input type="text" name="name" class="form-control" id="name"
                                                    value="{{ old('name', $data->name) }}" maxlength="255" required />
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label for="username">Username</label>
                                                <input type="text" name="username" class="form-control" id="username"
                                                    value="{{ old('username', $data->username) }}" maxlength="255"
                                                    required />
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input type="email" name="email" class="form-control" id="email"
                                                    value="{{ old('email', $data->email) }}" email="true" maxlength="255"
                                                    required />
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label for="role_id">Role</label>
                                                <select name="role_id" class="form-control role_id" id="role_id" required>
                                                    <option value="">Select Role</option>
                                                    @foreach ($rolesDataSet as $rolesData)
                                                        @if ($rolesData->id != 1)
                                                            <option value="{{ $rolesData->id }}"
                                                                {{ in_array($rolesData->name, $data->getRoleNames()->toArray()) ? 'selected' : '' }}>
                                                                {{ $rolesData->name }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label for="is_active">Enable/Disable</label>
                                                <select name="is_active" id="is_active" class="form-control">
                                                    <option value="0"
                                                        {{ old('is_active', $data->is_active) == 0 ? 'selected' : '' }}>
                                                        Disable
                                                    </option>
                                                    <option value="1"
                                                        {{ old('is_active', $data->is_active) == 1 ? 'selected' : '' }}>
                                                        Enable
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-flat btn-primary">Update</button>
                                </div>
                            </form>
                        </div>
                        {{-- /.card --}}
                    </div>
                    {{-- /.col --}}

                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <div class="card card-primary" style="height: calc(100% - 15px)">
                            <div class="card-header">
                                <h3 class="card-title">Change Password</h3>
                            </div>
                            <form action="{{ route('admin.manage-staff.update', $data->id) }}" method="post"
                                id="passwordForm">
                                @csrf
                                @method('put')
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <div class="form-group">
                                                <label for="password">Password</label>
                                                <input type="text" name="password" class="form-control" id="password"
                                                    value="{{ old('password') }}" password="true"maxlength="255" />
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <button type="submit" class="btn btn-flat btn-primary">Change
                                                Password</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        {{-- /.col --}}
                    </div>
                </div>
                {{-- /.row --}}
            </div>
            {{-- /.container-fluid --}}
        </section>
        {{-- /.main content --}}

    </div>
    <!-- /.content-wrapper -->
@endsection


@section('scripts')
    <!-- DataTables  & Plugins -->
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script>
        $(function() {
            $("#dataList").DataTable({
                "order": [
                    [0, "asc"]
                ],
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            });
        });

        // Save Role Name
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

        document.getElementById('permissionsForm').addEventListener('submit', function(event) {
            event.preventDefault();

            // Get selected permission IDs
            const permissionIds = Array.from(document.querySelectorAll('input[type=checkbox]:checked'))
                .map(checkbox => checkbox.id.split('-')[2]);

            // Prepare form data including '_method' for PUT request
            const formData = new FormData(this);
            formData.append('_method', 'PUT');
            formData.append('permissions', JSON.stringify(permissionIds));

            // Submit the form using AJAX
            fetch(this.action, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    // Handle the response as needed
                    console.log(data);
                })
                .catch(error => console.error(error));
        });
    </script>
@endsection
