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
                        <h1>Edit Support Ticket Priority</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ DiligentCreators('dashboard_url') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.priority.index') }}">List Ticket Priority</a></li>
                            <li class="breadcrumb-item active">Edit</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Default box -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit ticket priority</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.priority.index') }}" class="btn btn-flat btn-sm btn-theme"><i
                                class="fa-regular fa-eye"></i> View All</a>
                    </div>
                </div>
                <form action="{{ route('admin.priority.update', $data->id) }}" method="post" id="submitForm">
                    @csrf
                    @method('put')
                    <div class="card-body">

                        <div class="row">
                            <div class="col-lg-8 col-md-8 col-sm-12">
                                <div class="form-group">
                                    <label for="name">Support Ticket Priority Name</label>
                                    <input type="text" name="name" class="form-control" id="name"
                                        value="{{ $data->name }}">
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="is_active">Enable/Disable</label>
                                    <select name="is_active" id="is_active" class="form-control">
                                        @if ($data->is_active == 0)
                                            <option value="0" selected="selected">Disable</option>
                                            <option value="1">Enable</option>
                                        @elseif($data->is_active == 1)
                                            <option value="0">Disable</option>
                                            <option value="1" selected="selected">Enable</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-flat btn-success">Update Ticket Priority</button>
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
