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
                        <h1>Edit Dashboard Role</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ DiligentCreators('dashboard_url') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.manage-roles.index') }}">Manage Roles</a>
                            <li class="breadcrumb-item active">Edit</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Default box -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Edit Role</h3>
                        <div class="card-tools">
                            <a href="{{ route('admin.manage-roles.index') }}" class="btn btn-flat btn-sm btn-theme"><i
                                    class="fa-regular fa-eye"></i> View
                                All</a>
                        </div>
                    </div>
                    <form action="{{ route('admin.manage-roles.update', $data->id) }}" method="POST" id="submitForm">
                        @csrf
                        @method('put')
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label for="name">Role Name</label>
                                        <input type="text" name="name" class="form-control" id="name"
                                            value="{{ old('name', $data->name) }}" maxlength="255" required />
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-flat btn-success">Update</button>
                        </div>
                        {{-- /.card-footer --}}
                    </form>
                </div>
                <!-- /.card -->
            </div>
            {{-- /.container-fluid --}}
        </section>
        <!-- /.content -->

        <!-- Permission content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Default box -->
                <form action="{{ route('admin.manage-roles.update-permissions', $data->id) }}" method="POST"
                    id="permissionsForm">
                    @csrf
                    @method('POST')
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Assign Permissions To This Role</h3>
                        </div>
                        <div class="card-body">
                            <table id="dataList" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th style="width: 5%" class="text-center">
                                            <div class="icheck-success d-inline">
                                                <input type="checkbox" id="selectAll">
                                                <label for="selectAll"></label>
                                            </div>
                                        </th>
                                        <th>Permission Name</th>
                                        <th style="width: 10%" class="text-center">Authentication</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($permissions as $permission)
                                        <tr>
                                            <td class="text-center">
                                                <div class="icheck-success d-inline">
                                                    <input type="checkbox"
                                                        id="permissionCheckBox-{{ $data->id }}-{{ $permission->name }}"
                                                        @if ($data->permissions->contains('name', $permission->name)) checked @endif>
                                                    <label
                                                        for="permissionCheckBox-{{ $data->id }}-{{ $permission->name }}"></label>
                                                </div>
                                            </td>
                                            <td>{{ $permission->name }}</td>
                                            <td class="text-center">{{ ucwords($permission->guard_name) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{-- /.card-body --}}
                        <div class="card-footer">
                            <button type="submit" name="savePermissions" class="btn btn-primary">Save Permissions</button>
                        </div>
                        {{-- /.card-footer --}}
                    </div>
                    <!-- /.card -->
                </form>
            </div>
            {{-- /.container-fluid --}}
        </section>
        <!-- /.Permission content -->

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
        // JavaScript to handle "Select All" functionality
        const selectAllCheckbox = document.getElementById('selectAll');
        const permissionCheckboxes = document.querySelectorAll('input[type="checkbox"][id^="permissionCheckBox"]');

        selectAllCheckbox.addEventListener('change', () => {
            const isChecked = selectAllCheckbox.checked;

            permissionCheckboxes.forEach(checkbox => {
                checkbox.checked = isChecked;
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

        // JavaScript to handle form submission
        const form = document.getElementById('permissionsForm');

        form.addEventListener('submit', (event) => {
            event.preventDefault();

            const selectedPermissions = [];

            permissionCheckboxes.forEach(checkbox => {
                if (checkbox.checked) {
                    const permissionName = checkbox.id.split('-').slice(2).join(
                        '-'); // Extract permission name
                    selectedPermissions.push(permissionName);
                }
            });

            // Add selected permissions to a hidden input field for submission
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'permissions';
            hiddenInput.value = JSON.stringify(selectedPermissions);
            form.appendChild(hiddenInput);

            // Submit the form
            form.submit();
        });
    </script>
@endsection
