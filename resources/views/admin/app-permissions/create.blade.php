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
                        <h1>Permissions</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ DiligentCreators('dashboard_url') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.app-permissions.index') }}">Permissions</a>
                            </li>
                            <li class="breadcrumb-item active">View All</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="contaier-fluid">
                <!-- Default box -->
                <form action="{{ route('admin.app-permissions.store') }}" method="POST" id="submitForm">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Create New Permission</h3>
                            <div class="card-tools">
                                <a href="{{ route('admin.app-permissions.index') }}"
                                    class="btn btn-flat btn-sm btn-theme"><i class="fa-regular fa-square-plus"></i> View
                                    All</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="name">Permission Name</label>
                                        <input type="text" name="name" value="{{ old('name') }}"
                                            class="form-control" required maxlength="255" />
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label>Assign Roles</label><br>
                                        @foreach ($roles as $role)
                                            <div class="form-group clearfix">
                                                <div class="icheck-success d-inline">
                                                    <input type="checkbox" name="role_ids[]" id="checkboxSuccess-{{$role->id}}"
                                                    value="{{ $role->id }}">
                                                    <label for="checkboxSuccess-{{$role->id}}">
                                                        {{ ucwords($role->name) }}
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary bg-theme">Create Permission</button>
                        </div>
                    </div>
                    <!-- /.card -->
                </form>
            </div>
            {{-- /.container-fluid --}}

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection

@section('scripts')
    <script src="{{ asset('plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('plugins/jquery-validation/additional-methods.min.js') }}"></script>
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
