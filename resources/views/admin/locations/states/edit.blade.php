@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Edit State</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ DiligentCreators('dashboard_url') }}">Home</a></li>
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
                    <h3 class="card-title"></h3>
                    <div class="card-tools">
                        <a href="{{ URL::to('locations/states') }}" class="btn btn-flat btn-default">View
                            All</a>
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <form action="{{ route('admin.states.update', $data->id) }}" method="post" id="submitForm">
                    @csrf
                    @method('put')
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-3 col-md-3 col-sm-12">
                                <div class="form-group">
                                    <label for="country_id">Country Name</label>
                                    <select name="country_id" class="form-control country_id" id="country_id">
                                        <option value="">-- Select Country --</option>
                                        @foreach ($dataSet as $countrydata)
                                            <option value="{{ $countrydata->id }}"
                                                {{ $countrydata->id == $data->country_id ? 'selected' : '' }}>
                                                {{ $countrydata->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-12">
                                <div class="form-group">
                                    <label for="state_name">State Name</label>
                                    <input type="text" name="state_name" class="form-control" id="state_name"
                                        value="{{ $data->state_name }}" />
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-12">
                                <div class="form-group">
                                    <label for="is_active">Enable/Disable</label>
                                    <select name="is_active" id="is_active" class="form-control">
                                        <option value="0" {{ $data->is_active == 0 ? 'selected' : '' }}>Disable
                                        </option>
                                        <option value="1" {{ $data->is_active == 1 ? 'selected' : '' }}>Enable
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-flat btn-primary">Update</button>
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
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('plugins/jquery-validation/additional-methods.min.js') }}"></script>
    <script>
        // Initialize Select2 Elements
        $('.country_id').select2({
            theme: 'bootstrap4'
        });
        $('#submitForm').validate({
            rules: {
                country_id: {
                    required: true,
                },
                name: {
                    required: true,
                    maxLength: 255,
                },
            },
            messages: {
                country_id: {
                    required: 'Please select country',
                },
                name: {
                    required: 'State Name is required',
                    maxLength: 'State Name must be less then 255 characters',
                },
            },
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
