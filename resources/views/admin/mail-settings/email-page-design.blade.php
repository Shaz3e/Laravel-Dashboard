@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') }}">
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Email Page Design</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ DiligentCreators('dashboard_url') }}">Home</a></li>
                            <li class="breadcrumb-item active">Email Page Design</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Update Email Header & Footer -->
        <section class="content">
            <!-- Default box -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Update Email Design</h3>
                </div>
                <form action="{{ route('admin.email-design.post.data') }}" method="POST" id="submitForm"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="header_image" class="d-flex align-items-center justify-content-between">
                                        <span>Email Header Image <small>(Best size 800px x 400px)</small></span>
                                    </label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="header_image"
                                                name="header_image" accept="image/*" extension="jpg,jpeg,png"
                                                filesize="2048" />
                                            <label for="header_image" class="custom-file-label">
                                                <span id="header_image_show">Choose Header Image</span>
                                            </label>
                                        </div>
                                    </div>
                                    @if ($dataSet['header_image'] != null)
                                        <img class="img-fluid" src="{{ asset('/') . $dataSet['header_image'] }}">
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="footer_text_color" class="d-flex align-items-center justify-content-between">
                                        <span>Footer Text Color</span>
                                    </label>
                                    <div class="input-group footer_text_color">
                                        <input type="text" name="footer_text_color" class="form-control" value="{{ old('footer_text_color', $dataSet['footer_text_color']) }}">

                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="fas fa-square" style="color: {{ $dataSet['footer_text_color'] }}"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="footer_background_color"
                                        class="d-flex align-items-center justify-content-between">
                                        <span>Footer Background Color</span>
                                    </label>

                                    <div class="input-group footer_background_color">
                                        <input type="text" name="footer_background_color" class="form-control" value="{{ old('footer_background_color', $dataSet['footer_background_color'] ) }}">

                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="fas fa-square" style="color: {{ $dataSet['footer_background_color'] }}"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label for="footer_text" class="d-flex align-items-center justify-content-between">
                                        <span>Footer Text <small>(Footer Text for email)</small></span>
                                    </label>
                                    <div class="input-group">
                                        <textarea class="form-control" name="footer_text" id="footer_text" required>
                                            {{ $dataSet['footer_text'] }}
                                        </textarea>
                                    </div>
                                </div>
                            </div>

                        </div>
                        {{-- /.row --}}
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" name="updateHeaderFooter" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
            <!-- /.card -->
        </section>
        <!-- /.Update Email Header & Footer -->

        

        <!-- Email Preview -->
        <section class="content">
            <!-- Default box -->
            <div class="card">
                
                <div class="card-header">
                    <h3 class="card-title">Email Preview</h3>
                </div>
                <img class="img-fluid" src="{{ asset('/') . $dataSet['header_image'] }}">

                <div class="mt-5 mb-5 text-center">
                    Email content will appear here...
                </div>

                <div style="background-color:{{ EmailPageDesign('footer_background_color') }};color:{{ EmailPageDesign('footer_text_color') }};padding-top:20px;padding-right:20px;padding-bottom:20px;padding-left:20px;">
                    {!! nl2br(EmailPageDesign('footer_text')) !!}
                </div>
            </div>
            <!-- /.card -->
        </section>
        <!-- /.Email Preview -->
    </div>
    <!-- /.content-wrapper -->
@endsection

@section('scripts')
    <script src="{{ asset('plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') }}"></script>
    <script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('plugins/jquery-validation/additional-methods.min.js') }}"></script>
    <script>
        $(function() { //Colorpicker
            $('.footer_text_color').colorpicker()
            $('.footer_text_color').on('colorpickerChange', function(event) {
                $('.footer_text_color .fa-square').css('color', event.color.toString());
            })
            //color picker with addon
            $('.footer_background_color').colorpicker()
            $('.footer_background_color').on('colorpickerChange', function(event) {
                $('.footer_background_color .fa-square').css('color', event.color.toString());
            })
            // Summernote
            $('#footer_text').summernote()
        })
        $.validator.addMethod('filesize', function(value, element, param) {
            let logo_small = element.files[0].size;
            logo_small = logo_small / 2000;
            logo_small = Math.round(flagSize);
            return this.optional(element) || (logo_small <= param)
        }, 'File size must be less than {0}');
        $("#header_image").change(function() {
            $("#header_image_show").text(this.files[0].name);
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
