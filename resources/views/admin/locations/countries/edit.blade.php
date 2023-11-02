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
                        <h1>Edit Country</h1>
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
                        <a href="{{ URL::to('locations/countries') }}" class="btn btn-flat btn-default">View
                            All</a>
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <form action="{{ route('admin.countries.update', $data->id) }}" method="post" id="submitForm"
                    enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-3 col-md-3 col-sm-12">
                                <div class="form-group">
                                    <label for="name">Country</label>
                                    <input type="text" name="name" class="form-control" id="name"
                                        value="{{ $data->name }}" maxlength="255" required />
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-12">
                                <div class="form-group">
                                    <label for="alpha2">Alpha 2 Code</label>
                                    <input type="text" name="alpha2" class="form-control" id="alpha2"
                                        value="{{ $data->alpha2 }}" minlength="1" maxlength="2" required />
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-12">
                                <div class="form-group">
                                    <label for="alpha3">Alpha 3 Code</label>
                                    <input type="text" name="alpha3" class="form-control" id="alpha3"
                                        value="{{ $data->alpha3 }}" minlength="2" maxlength="3" required />
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-12">
                                <div class="form-group">
                                    <label for="flag" class="d-flex justify-content-between">
                                        Flag
                                        <img src="{{ asset('/') . $data->flag }}" class="w-100 rounded"
                                            style="max-width: 40px" loading="lazy" decoding="async" />
                                    </label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="flag" name="flag">
                                            <label class="custom-file-label">
                                                <span id="flag_show">Choose File</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-12">
                                <div class="form-group">
                                    <label for="currency">Currency</label>
                                    <input type="text" name="currency" class="form-control" id="currency"
                                        value="{{ $data->currency }}" required />
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-12">
                                <div class="form-group">
                                    <label for="currency_code">Currency Code</label>
                                    <input type="text" name="currency_code" class="form-control" id="currency_code"
                                        value="{{ $data->currency_code }}" required />
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-3 col-sm-12">
                                <div class="form-group">
                                    <label for="calling_code">Calling Code</label>
                                    <input type="text" name="calling_code" class="form-control" id="calling_code"
                                        value="{{ $data->calling_code }}" required />
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
                        <button type="submit" class="btn btn-primary">Submit</button>
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
        $.validator.addMethod('filesize', function(value, element, param) {
            let flagSize = element.files[0].size;
            flagSize = flagSize / 2000;
            flagSize = Math.round(flagSize);
            return this.optional(element) || (flagSize <= param)
        }, 'File size must be less than {0}');
        $("#flag").change(function() {
            $("#flag_show").text(this.files[0].name);
        });
        $('#submitForm').validate({
            rules: {
                name: {
                    required: true,
                    maxlength: 255,
                },
                alpha2: {
                    required: true,
                    minlength: 1,
                    maxlength: 2,
                },
                alpha3: {
                    required: true,
                    minlength: 1,
                    maxlength: 3,
                },
                flag: {
                    extension: "jpg,jpeg,png,gif",
                    filesize: 2000,
                },
                currency: {
                    required: true,
                    maxlength: 255,
                },
                currency_code: {
                    required: true,
                    maxlength: 11,
                },
                calling_code: {
                    required: true,
                    maxlength: 11,
                },
                currency: {
                    required: true,
                    maxlength: 255,
                },
            },
            messages: {
                name: {
                    required: 'Country name is required',
                    maxlength: 'Country name must be less then 255 characters',
                },
                alpha2: {
                    required: 'Alpha2 is required',
                    minlength: 'Alpha2 must be at least 1 characters',
                    maxlength: 'Alpha2 must be less then 2 characters',
                },
                alpha3: {
                    required: 'Alpha3 is required',
                    minlength: 'Alpha3 must be at least 1 characters',
                    maxlength: 'Alpha3 must be less then 3 characters',
                },
                flag: {
                    required: "Please upload flag.",
                    extension: "Supported file extensions are jpg, jpeg and png",
                    filesize: "File size should be less than 2 MB",
                },
                currency: {
                    required: 'Currency is required',
                    maxlength: 'Currency must be at least less then 3 characters',
                },
                currency_code: {
                    required: 'Currency Code is required',
                    maxlength: 'Currency Code must be equal or less less then 11 digits',
                },
                calling_code: {
                    required: 'Calling Code is required',
                    maxlength: 'Calling Code must be equal or less less then 11 digits',
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
