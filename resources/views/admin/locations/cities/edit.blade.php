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
                        <h1>Edit City</h1>
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
                        <a href="{{ URL::to('locations/cities') }}" class="btn btn-flat btn-default">View All
                            Cities</a>
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <form action="{{ route('admin.cities.update', $data->id) }}" method="post" id="submitForm">
                    @csrf
                    @method('put')
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-3 col-md-3 col-sm-12">
                                <div class="form-group">
                                    <label for="state_id">State Name</label>
                                    <select name="state_id" class="form-control state_id" id="state_id">
                                        <option value="">-- Select State --</option>
                                        @foreach ($dataSet as $cityData)
                                            <option value="{{ $cityData->id }}"
                                                {{ $cityData->id == $data->state_id ? 'selected' : '' }}>
                                                {{ $cityData->state_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-12">
                                <div class="form-group">
                                    <label for="city_name">City Name</label>
                                    <input type="text" name="city_name" class="form-control" id="city_name"
                                        value="{{ $data->city_name }}" />
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
        $('.state_id').select2({
            theme: 'bootstrap4'
        });
        $('#submitForm').validate({
            rules: {
                state_id: {
                    required: true,
                },
                city_name: {
                    required: true,
                    maxLength: 255,
                },
            },
            messages: {
                state_id: {
                    required: 'Please select state',
                },
                city_name: {
                    required: 'City name is required',
                    maxLength: 'City name must be less then 255 characters',
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
