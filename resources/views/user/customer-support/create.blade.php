@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.min.css') }}">
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Create New Ticket</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ DiligentCreators('dashboard_url') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('customer-support.index') }}">Customer Support</a>
                            </li>
                            <li class="breadcrumb-item active">Create New Ticket</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <form action="{{ route('customer-support.store') }}" method="post" id="submitForm"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="card-header">
                                    <h3 class="card-title">Submit New Ticket</h3>
                                </div>
                                <!-- /.card-header -->

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <div class="form-group">
                                                <input class="form-control" name="title" placeholder="Subject:"
                                                    value="{{ old('title') }}" required />
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <div class="form-group">
                                                <textarea id="compose-textarea" class="form-control" name="message" style="height: 300px; display: none;"></textarea>
                                            </div>
                                        </div>

                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <div class="form-group">
                                                <div class="btn btn-default btn-file attachment-group">
                                                    <div class="attachments">
                                                        <i class="fas fa-paperclip"></i> Attachment
                                                        <input type="file" name="attachments[]"
                                                            accept="application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document, application/pdf, image/jpeg, image/jpg, image/png"
                                                            id="attachment-input">
                                                    </div>
                                                </div>
                                                <p class="help-block">Max file size. 5MB. Allowed file types: .doc, .docx,
                                                    .pdf, .jpeg, .jpg, .png</p>
                                                <span id="error-message" style="color: red;"></span>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <button type="button" class="btn btn-theme btn-flat add-more">Add
                                                more...</button>
                                        </div>

                                    </div>
                                    {{-- /.row --}}
                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <div class="float-right">
                                        <button type="submit" class="btn btn-flat btn-primary"><i
                                                class="far fa-envelope"></i>
                                            Submit Ticket</button>
                                    </div>
                                    <a href="{{ route('customer-support.index') }}" class="btn btn-flat btn-default"><i
                                            class="fas fa-times"></i>
                                        Discard</a>
                                </div>
                                <!-- /.card-footer -->
                            </form>

                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection

@section('scripts')
    <script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('plugins/jquery-validation/additional-methods.min.js') }}"></script>
    <script>
        $(function() {
            //Add text editor
            let summernoteOptions = {
                height: 300
            }
            $('#compose-textarea').summernote(summernoteOptions)
        });

        // Attachments
        $(document).ready(function() {
            $('#attachment-input').on('change', function() {
                const allowedMimeTypes = [
                    'application/msword',
                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                    'application/pdf',
                    'image/jpeg',
                    'image/jpg',
                    'image/png'
                ];

                const maxFileSize = 5 * 1024 * 1024; // 5MB in bytes
                const files = $(this)[0].files;

                if (files.length > 0) {
                    const fileType = files[0].type;

                    if (fileSize > maxFileSize) {
                        alert('File size exceeds the allowed limit (5MB)');
                        $(this).val(''); // Clear the file input
                    }
                }
                if (!allowedMimeTypes.includes(fileType)) {
                    $('#error-message').text(
                        'Allowed file types: .doc, .docx, .pdf, .jpeg, .jpg, .png');
                    $(this).val(''); // Clear the file input
                } else {
                    $('#error-message').text(''); // Clear the error message if valid
                }
            });
        });
        document.querySelector('.add-more').addEventListener('click', function() {
            const attachmentGroup = document.querySelector('.attachment-group');
            const newInput = document.querySelector('.attachments').cloneNode(true);

            // Clear the cloned input's value to prevent duplicating the same file
            const inputElement = newInput.querySelector('input[type="file"]');
            inputElement.value = '';

            attachmentGroup.appendChild(newInput);
        });

        $('#submitForm ').validate({
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
