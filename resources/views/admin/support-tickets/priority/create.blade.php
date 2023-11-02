@extends('layouts.app')

@section('styles')
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Create New Support Ticket Priority</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ DiligentCreators('dashboard_url') }}">Home</a></li>
                            <li class="breadcrumb-item"><a
                                    href="{{ route('admin.priority.index') }}">List Ticket Priority</a></li>
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
                    <h3 class="card-title">Create new ticket priority</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.priority.index') }}" class="btn btn-flat btn-sm btn-theme"><i class="fa-regular fa-eye"></i> View
                            All</a>
                    </div>
                </div>
                <form action="{{ route('admin.priority.store') }}" method="post" id="submitForm">
                    @csrf
                    <div class="card-body">

                        <div class="row">
                            <div class="col-lg-8 col-md-8 col-sm-12">
                                <div class="form-group">
                                    <label for="name">Priority Name</label>
                                    <input type="text" name="name" class="form-control" id="name"
                                        value="{{ old('name') }}" required>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="is_active">Enable/Disable</label>
                                    <select name="is_active" id="is_active" class="form-control" required>
                                        <option value="0">Disable</option>
                                        <option value="1">Enable</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Create New Ticket Priority</button>
                    </div>
            </div>
            <!-- /.card -->
            </form>

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection

@section('scripts')
    <script src="{{ asset('plugins/jquery-validation/jquery.validate.min.js') }}"></script>
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
