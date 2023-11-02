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
                    <h1>CRM Logo Settings</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ DiligentCreators('dashboard_url') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">App Settings</a></li>
                        <li class="breadcrumb-item active">CRM Logo Settings</li>
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
                <h3 class="card-title">Update Brand Setting</h3>
            </div>
            <form action="{{ route('admin.app-settings-brand.update') }}" method="POST" id="submitForm" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="logo_small" class="d-flex align-items-center justify-content-between">
                                    <span>Logo <small>(58px x 58px)</small></span>
                                    <img src="{{ asset('/') . $dataSet['logo_small'] }}" class="w-auto rounded" style="max-height: 30px" loading="lazy" decoding="async" />
                                </label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="logo_small" name="logo_small" accept="image/*" extension="jpg,jpeg,png" filesize="1024" required />
                                        <label for="logo_small" class="custom-file-label">
                                            <span id="logo_small_show">Choose Small Logo</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="site_logo" class="d-flex align-items-center justify-content-between">
                                    <span>Logo <small>(Horizontal Logo)</small></span>
                                    <img src="{{ asset('/') . $dataSet['site_logo'] }}" class="w-auto rounded" style="max-height: 30px" loading="lazy" decoding="async" />
                                </label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="site_logo" name="site_logo" accept="image/*" extension="jpg,jpeg,png" filesize="2048" required />
                                        <label for="site_logo" class="custom-file-label">
                                            <span id="site_logo_show">Choose Logo</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection

@section('scripts')
<script src="{{ asset('plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script>
    $.validator.addMethod('filesize', function(value, element, param) {
        let logo_small = element.files[0].size;
        logo_small = logo_small / 2000;
        logo_small = Math.round(flagSize);
        return this.optional(element) || (logo_small <= param)
    }, 'File size must be less than {0}');
    $("#logo_small").change(function() {
        $("#logo_small_show").text(this.files[0].name);
    });

    $.validator.addMethod('filesize', function(value, element, param) {
        let site_logo = element.files[0].size;
        site_logo = site_logo / 2000;
        site_logo = Math.round(flagSize);
        return this.optional(element) || (site_logo <= param)
    }, 'File size must be less than {0}');
    $("#site_logo").change(function() {
        $("#site_logo_show").text(this.files[0].name);
    });
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