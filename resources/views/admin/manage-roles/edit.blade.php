@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
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
                                        <th>Access Area</th>
                                        <th class="text-center">Select All</th>
                                        <th class="text-center">List</th>
                                        <th class="text-center">Show</th>
                                        <th class="text-center">Create</th>
                                        <th class="text-center">Read</th>
                                        <th class="text-center">Update</th>
                                        <th class="text-center">Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $groupedPermissions = collect($permissions)->groupBy(function ($item) {
                                            return strtolower(substr($item->name, 0, strpos($item->name, '.')));
                                        });
                                    @endphp
                                    @foreach ($groupedPermissions as $accessArea => $areaPermissions)
                                        <tr>
                                            <td>{{ ucwords($accessArea) }}</td>
                                            <td class="text-center">
                                                <div class="icheck-success d-inline">
                                                    <input type="checkbox" class="selectAllRow"
                                                        data-area="{{ $accessArea }}" id="selectAll-{{ $accessArea }}">
                                                    <label for="selectAll-{{ $accessArea }}"></label>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                @php
                                                    $listPermissionExists = $areaPermissions->contains(function ($permission) {
                                                        return str_contains($permission->name, 'list');
                                                    });
                                                @endphp
                                                @if ($listPermissionExists)
                                                    <div class="icheck-success d-inline">
                                                        <input type="checkbox" class="select-permission"
                                                            name="permissions[]" value="{{ $accessArea }}.list"
                                                            data-permission-name="{{ $accessArea }}.list"
                                                            data-permission="list" data-area="{{ $accessArea }}"
                                                            id="listPermissionCheckBox-{{ $data->id }}-{{ $accessArea }}"
                                                            @if (
                                                                $data->permissions->contains(function ($permission) use ($accessArea) {
                                                                    return str_contains($permission->name, 'list') && str_contains($permission->name, $accessArea);
                                                                })) checked @endif>
                                                        <label
                                                            for="listPermissionCheckBox-{{ $data->id }}-{{ $accessArea }}"></label>
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @php
                                                    $showPermissionExists = $areaPermissions->contains(function ($permission) {
                                                        return str_contains($permission->name, 'show');
                                                    });
                                                @endphp
                                                @if ($showPermissionExists)
                                                    <div class="icheck-success d-inline">
                                                        <input type="checkbox" class="select-permission"
                                                            name="permissions[]" value="{{ $accessArea }}.show"
                                                            data-permission-name="{{ $accessArea }}.show"
                                                            data-permission="show" data-area="{{ $accessArea }}"
                                                            id="showPermissionCheckBox-{{ $data->id }}-{{ $accessArea }}"
                                                            @if (
                                                                $data->permissions->contains(function ($permission) use ($accessArea) {
                                                                    return str_contains($permission->name, 'show') && str_contains($permission->name, $accessArea);
                                                                })) checked @endif>
                                                        <label
                                                            for="showPermissionCheckBox-{{ $data->id }}-{{ $accessArea }}"></label>
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @php
                                                    $createPermissionExists = $areaPermissions->contains(function ($permission) {
                                                        return str_contains($permission->name, 'create');
                                                    });
                                                @endphp
                                                @if ($createPermissionExists)
                                                    <div class="icheck-success d-inline">
                                                        <input type="checkbox" class="select-permission"
                                                            name="permissions[]" value="{{ $accessArea }}.create"
                                                            data-permission-name="{{ $accessArea }}.create"
                                                            data-permission="create" data-area="{{ $accessArea }}"
                                                            id="createPermissionCheckBox-{{ $data->id }}-{{ $accessArea }}"
                                                            @if (
                                                                $data->permissions->contains(function ($permission) use ($accessArea) {
                                                                    return str_contains($permission->name, 'create') && str_contains($permission->name, $accessArea);
                                                                })) checked @endif>
                                                        <label
                                                            for="createPermissionCheckBox-{{ $data->id }}-{{ $accessArea }}"></label>
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @php
                                                    $readPermissionExists = $areaPermissions->contains(function ($permission) {
                                                        return str_contains($permission->name, 'read');
                                                    });
                                                @endphp
                                                @if ($readPermissionExists)
                                                    <div class="icheck-success d-inline">
                                                        <input type="checkbox" class="select-permission"
                                                            name="permissions[]" value="{{ $accessArea }}.read"
                                                            data-permission-name="{{ $accessArea }}.read"
                                                            data-permission="read" data-area="{{ $accessArea }}"
                                                            id="readPermissionCheckBox-{{ $data->id }}-{{ $accessArea }}"
                                                            @if (
                                                                $data->permissions->contains(function ($permission) use ($accessArea) {
                                                                    return str_contains($permission->name, 'read') && str_contains($permission->name, $accessArea);
                                                                })) checked @endif>
                                                        <label
                                                            for="readPermissionCheckBox-{{ $data->id }}-{{ $accessArea }}"></label>
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @php
                                                    $updatePermissionExists = $areaPermissions->contains(function ($permission) {
                                                        return str_contains($permission->name, 'update');
                                                    });
                                                @endphp
                                                @if ($updatePermissionExists)
                                                    <div class="icheck-success d-inline">
                                                        <input type="checkbox" class="select-permission"
                                                            name="permissions[]" value="{{ $accessArea }}.update"
                                                            data-permission-name="{{ $accessArea }}.update"
                                                            data-permission="update" data-area="{{ $accessArea }}"
                                                            id="updatePermissionCheckBox-{{ $data->id }}-{{ $accessArea }}"
                                                            @if (
                                                                $data->permissions->contains(function ($permission) use ($accessArea) {
                                                                    return str_contains($permission->name, 'update') && str_contains($permission->name, $accessArea);
                                                                })) checked @endif>
                                                        <label
                                                            for="updatePermissionCheckBox-{{ $data->id }}-{{ $accessArea }}"></label>
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @php
                                                    $deletePermissionExists = $areaPermissions->contains(function ($permission) {
                                                        return str_contains($permission->name, 'delete');
                                                    });
                                                @endphp
                                                @if ($deletePermissionExists)
                                                    <div class="icheck-success d-inline">
                                                        <input type="checkbox" class="select-permission"
                                                            name="permissions[]" value="{{ $accessArea }}.delete"
                                                            data-permission-name="{{ $accessArea }}.delete"
                                                            data-permission="delete" data-area="{{ $accessArea }}"
                                                            id="deletePermissionCheckBox-{{ $data->id }}-{{ $accessArea }}"
                                                            @if (
                                                                $data->permissions->contains(function ($permission) use ($accessArea) {
                                                                    return str_contains($permission->name, 'delete') && str_contains($permission->name, $accessArea);
                                                                })) checked @endif>
                                                        <label
                                                            for="deletePermissionCheckBox-{{ $data->id }}-{{ $accessArea }}"></label>
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{-- /.card-body --}}
                        <div class="card-footer">
                            <button type="submit" name="savePermissions" class="btn btn-primary">Save
                                Permissions</button>
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
    <script src="{{ asset('plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script>
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

        $(document).ready(function() {
            // "Select All" checkbox click event
            $('#selectAll').on('change', function() {
                var isChecked = $(this).prop('checked');
                $('.selectAllRow, .select-permission').prop('checked', isChecked);
                updatePermissionsInput();
            });

            // "Select All Row" checkbox click event
            $('.selectAllRow').on('change', function() {
                var isChecked = $(this).prop('checked');
                $(this).closest('tr').find('.select-permission').prop('checked', isChecked);
                updateSelectAllCheckbox();
                updatePermissionsInput();
            });

            // Individual permission checkbox click event
            $('.select-permission').on('change', function() {
                updateSelectAllCheckbox();
                updatePermissionsInput();
            });

            // Function to update "Select All" checkbox based on individual checkboxes
            function updateSelectAllCheckbox() {
                var allChecked = true;
                $('.select-permission').each(function() {
                    if (!$(this).prop('checked')) {
                        allChecked = false;
                        return false; // exit the loop if any checkbox is not checked
                    }
                });

                // Update "Select All" checkbox
                $('#selectAll').prop('checked', allChecked);
            }

            // Function to update hidden input field with selected permissions
            function updatePermissionsInput() {
                const selectedPermissions = [];
                $('.select-permission:checked').each(function() {
                    const permissionName = $(this).attr('data-permission-name');
                    selectedPermissions.push(permissionName);
                });

                // Update hidden input field with selected permissions
                $('#permissions').val(JSON.stringify(selectedPermissions));
            }

            // Check "Select All" initially
            updateSelectAllCheckbox();
        });
    </script>
@endsection
