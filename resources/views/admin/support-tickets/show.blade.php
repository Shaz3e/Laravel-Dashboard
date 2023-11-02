@extends('layouts.app')

@section('styles')
    {{-- Select2 --}}
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    {{-- Summer Note --}}
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
                        <h1>Support Dashboard</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ DiligentCreators('dashboard_url') }}">Home</a></li>
                            <li class="breadcrumb-item active">Support Dashboard</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-3">
                        <a href="{{ route('admin.support-tickets.index') }}"
                            class="btn btn-primary btn-theme btn-block mb-3">Back To Dashboard</a>
                        @include('admin.support-tickets.sidebar')
                    </div>
                    <!-- /.col -->
                    <div class="col-md-9">

                        {{-- Assign card --}}
                        <div class="card card-outline">
                            <div class="card-header p-3">
                                <h3 class="card-title d-block w-100">#{{ $data->ticket_number }}</h3>
                            </div>
                            <div class="card-body p-3">
                                <p class="mb-1">
                                    <a href="{{ route('admin.clients.edit', $data->user_id) }}" class="text">
                                        {{ $data->first_name . ' ' . $data->last_name }} ({{ $data->email }})
                                    </a>
                                </p>
                                <p class="m-0 mb-1">{{ $data->title }}</p>
                                <p class="m-0 mb-2"><small>{{ dateFormat($data->created_at) }}
                                        {{ timeFormat($data->created_at) }}</small></p>
                            </div>
                            <form action="{{ route('admin.support-tickets.update', $data->id) }}" method="POST">
                                @csrf
                                @method('put')
                                <div class="card-footer">

                                    <div class="row">
                                        <div class="col-lg-4 col-md-4 col-sm-12">
                                            <div class="form-group m-0">
                                                <label for="assigned_to">Assign Ticket to Staff</label>
                                                <select name="assigned_to" id="assigned_to" class="form-control select2">
                                                    <option value="">Assign To</option>
                                                    @foreach ($adminData as $admin)
                                                        <option value="{{ $admin->id }}"
                                                            {{ $admin->id == $data->assigned_to ? 'selected' : '' }}>
                                                            {{ $admin->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-12">
                                            <div class="form-group m-0">
                                                <label for="ticket_status_id">Chagne Ticket Status</label>
                                                <select name="ticket_status_id" id="ticket_status_id"
                                                    class="form-control select2">
                                                    <option value="">Change Status</option>
                                                    @foreach ($ticketStatus as $status)
                                                        <option value="{{ $status->id }}"
                                                            {{ $status->id == $data->ticket_status_id ? 'selected' : '' }}>
                                                            {{ $status->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-12">
                                            <div class="form-group m-0">
                                                <label for="support_ticket_priority_id">Chagne Ticket Priority</label>
                                                <select name="support_ticket_priority_id" class="form-control">
                                                    @foreach ($ticketPriority as $status)
                                                        <option value="{{ $status->id }}"
                                                            {{ $status->id == $data->support_ticket_priority_id ? 'selected' : '' }}>
                                                            {{ $status->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- /.row --}}

                                    <div class="row mt-2">
                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                            <button type="button" id="replyTicket" class="btn btn-default">
                                                <i class="fas fa-reply"></i>
                                                Reply
                                            </button>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                            <button type="submit" name="assign_form" value="assign_form"
                                                class="btn btn-primary float-right">Update Ticket</button>
                                        </div>
                                    </div>

                                </div>
                                {{-- /.card-footer --}}
                            </form>

                        </div>
                        {{-- /.card --}}

                        {{-- Main Support Ticket --}}
                        <div class="row ">
                            <div class="col-10">
                                <div class="card card-outline-left">
                                    <div class="card-header">
                                        <h3 class="card-title">
                                            {{ getUserName($data->user_id) }}
                                        </h3>
                                        <div class="card-tools">
                                            Support Ticket
                                        </div>
                                    </div>
                                    <div class="card-body p-1">
                                        <div class="mailbox-read-message">
                                            {!! $data->message !!}
                                        </div>
                                    </div>
                                    <div class="card-footer">

                                        <p class="mailbox-read-time mb-2">
                                            <i class="fa-solid fa-calendar-days"></i> {{ DateFormat($data->updated_at) }}
                                            <br>
                                            <i class="fa-solid fa-clock"></i> {{ TimeFormat($data->updated_at) }}
                                        </p>
                                        @if ($data->attachments != null)
                                            @foreach ($attachments as $attachment)
                                                <ul class="mailbox-attachments d-flex align-items-stretch clearfix">
                                                    <li>
                                                        <div class="mailbox-attachment-info">
                                                            <a href="{{ asset('storage/' . $attachment->value) }}"
                                                                target="_blank" class="mailbox-attachment-name">
                                                                <i class="fas fa-paperclip"></i>
                                                                {{ $attachment->name }}
                                                            </a>
                                                            <span class="mailbox-attachment-size clearfix mt-1">
                                                                {{-- <span>{{ getFileSize(asset('storage/app/public/' . $attachment->value)) }}</span> --}}
                                                                <a href="{{ asset('storage/' . $attachment->value) }}"
                                                                    download="{{ $attachment->name }}"
                                                                    class="btn btn-default btn-sm float-right">
                                                                    <i class="fas fa-cloud-download-alt"></i>
                                                                </a>
                                                            </span>
                                                        </div>
                                                    </li>
                                                </ul>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- All Support Ticket Replies --}}
                        @foreach ($supportTicketReply as $reply)
                            <div class="row {{ $reply->reply_by != null ? 'd-flex flex-row-reverse' : '' }}">
                                <div class="col-10">
                                    <div
                                        class="card {{ $reply->reply_by != null ? 'card-outline-right' : 'card-outline-left' }}">
                                        <div class="card-header">
                                            <h3 class="card-title">
                                                {{ $reply->reply_by != null ? getAdminName($reply->reply_by) : getUserName($reply->user_id) }}
                                            </h3>
                                            <div class="card-tools">
                                                {{ $reply->reply_by != null ? 'Staff Reply' : 'Customer Reply' }}
                                            </div>
                                        </div>
                                        {{-- /.card-header --}}
                                        <div class="card-body p-1">
                                            <div class="mailbox-read-message pl-2">
                                                {!! nl2br($reply->message) !!}
                                            </div>
                                        </div>
                                        {{-- /.card-body --}}
                                        <div class="card-footer">

                                            <p class="mailbox-read-time mb-2">
                                                <i class="fa-solid fa-calendar-days"></i>
                                                {{ DateFormat($reply->updated_at) }}
                                                <i class="fa-solid fa-clock"></i> {{ TimeFormat($reply->updated_at) }}
                                            </p>

                                            @if ($reply->attachments != null)
                                                @foreach (json_decode($reply->attachments) as $attachment)
                                                    <ul class="mailbox-attachments d-flex align-items-stretch clearfix">
                                                        <li>
                                                            <div class="mailbox-attachment-info">
                                                                <a href="{{ asset('storage/' . $attachment->value) }}"
                                                                    target="_blank" class="mailbox-attachment-name">
                                                                    <i class="fas fa-paperclip"></i>
                                                                    {{ $attachment->name }}
                                                                </a>
                                                                <span class="mailbox-attachment-size clearfix mt-1">
                                                                    {{-- <span>{{ getFileSize(asset('storage/app/public/' . $attachment->value)) }}</span> --}}
                                                                    <a href="{{ asset('storage/' . $attachment->value) }}"
                                                                        download="{{ $attachment->name }}"
                                                                        class="btn btn-default btn-sm float-right">
                                                                        <i class="fas fa-cloud-download-alt"></i>
                                                                    </a>
                                                                </span>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                @endforeach
                                            @endif
                                        </div>
                                        {{-- /.card-footer --}}
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
                <!-- /.row -->
            </div>
            {{-- /.container-fluid --}}
        </section>
        <!-- /.content -->

        {{-- Reply card --}}
        <section class="content">
            <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <form action="{{ route('admin.support-tickets.update', $data->id) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <input type="hidden" name="support_ticket_id" value="{{ $data->id }}">
                            <div class="card-body">
                                <div class="form-group">
                                    <textarea id="compose-textarea" class="form-control" name="message" style="height: 300px"></textarea>
                                </div>
                            </div>
                            {{-- /.card-body --}}
                            <div class="card-footer">
                                <div class="row mb-5">

                                    <div class="col-lg-8 col-md-8 col-sm-12">
                                        <label for="attachments">Upload Attachments</label>
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

                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label for="ticket_status_id">Change Ticket Status</label>
                                            <select name="ticket_status_id" class="form-control select2" required>
                                                @foreach ($ticketStatus as $status)
                                                    <option value="{{ $status->id }}"
                                                        {{ $status->id == $data->ticket_status_id ? 'selected' : '' }}>
                                                        {{ $status->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <button type="button" class="btn btn-flat btn-theme add-more">Add
                                            more...</button>
                                    </div>
                                </div>
                                {{-- /.row --}}

                                <button type="submit" class="btn btn-flat btn-primary">
                                    <i class="far fa-envelope"></i>
                                    Reply Ticket
                                </button>
                            </div>
                            <!-- /.card-footer -->

                        </form>
                    </div>
                    <!-- /.card-body -->
                </div>
                {{-- /.col --}}
            </div>
            {{-- /.row --}}
            </div>
            {{-- /.container-fluid --}}
        </section>
        {{-- /.reply card --}}

    </div>
    <!-- /.content-wrapper -->
@endsection

@section('scripts')
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('plugins/jquery-validation/additional-methods.min.js') }}"></script>
    <script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script>
        $('.select2').select2({
            theme: 'bootstrap4'
        });
        $(function() {
            //Add text editor
            let summernoteOptions = {
                height: 300
            }
            $('#compose-textarea').summernote(summernoteOptions)
        });
        $("#replyTicket").click(function(e) {
            e.preventDefault();
            $('html, body').animate({
                scrollTop: $(document).height()
            }, 'slow');
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
