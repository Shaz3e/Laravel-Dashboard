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
                        <h1>View Ticket: #{{ $data->ticket_number }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ DiligentCreators('dashboard_url') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('customer-support.index') }}">Customer Support</a>
                            </li>
                            <li class="breadcrumb-item active">Show Ticket</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main Support ticket content -->
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <small>Subject:</small><br>
                            {{ $data->title }}
                        </h3>
                        <div class="card-tools">
                            <i class="fa-solid fa-headset"></i>
                            {{ getAdminName($data->assigned_to) }}
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-3 col-md-3 col-sm-12">
                                <div class="form-group">
                                    <small>Created</small><br>
                                    <i class="fa-solid fa-calendar-days"></i> {{ DateFormat($data->created_at) }}
                                    <br>
                                    <i class="fa-solid fa-clock"></i> {{ TimeFormat($data->created_at) }}
                                </div>
                            </div>
                            <!-- /.col -->
                            <div class="col-lg-3 col-md-3 col-sm-12">
                                <div class="form-group">
                                    <small>Updated</small><br>
                                    <i class="fa-solid fa-calendar-days"></i> {{ DateFormat($data->updated_at) }}
                                    <br>
                                    <i class="fa-solid fa-clock"></i> {{ TimeFormat($data->updated_at) }}
                                </div>
                            </div>
                            <!-- /.col -->
                            <div class="col-lg-3 col-md-3 col-sm-12">
                                <div class="form-group">
                                    <small>Status</small><br>
                                    <select name="ticket_status_id" class="form-control changeStatusPriority">
                                        @foreach ($ticketStatusData as $status)
                                            <option value="{{ $status->id }}"
                                                {{ $status->id == $data->ticket_status_id ? 'selected' : '' }}>
                                                {{ $status->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <!-- /.col -->
                            <div class="col-lg-3 col-md-3 col-sm-12">
                                <div class="form-group">
                                    <small>Priority</small><br>
                                    <select name="support_ticket_priority_id" class="form-control changeStatusPriority">
                                        @foreach ($ticketPriorityData as $priority)
                                            <option value="{{ $priority->id }}"
                                                {{ $priority->id == $data->support_ticket_priority_id ? 'selected' : '' }}>
                                                {{ $priority->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="button" class="btn btn-flat btn-theme" id="replyTicket">
                            <i class="fas fa-reply"></i> Reply
                        </button>
                        <a href="?status=status&priority=priorit" class="btn btn-flat btn-theme float-right"
                            id="changeStatusPriority" style="display:none;">
                            <i class="fa-regular fa-floppy-disk"></i> Save Changes
                        </a>
                    </div>
                    <!-- /.card-footer -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.Main Support ticket content -->


        {{-- Main Support Ticket --}}
        <section class="content">
            <div class="container-fluid">

                <div class="row d-flex flex-row-reverse">
                    <div class="col-lg-10 col-10">
                        <div class="card card-outline-left">
                            <div class="card-header">
                                <h3 class="card-title">{{ getUserName($data->user_id) }}</h3>
                            </div>
                            <div class="card-body p-1">
                                <div class="mailbox-read-message">
                                    {!! $data->message !!}
                                </div>
                            </div>
                            <div class="card-footer p-1">
                                <p class="mailbox-read-time m-0 pl-2">
                                    <i class="fa-solid fa-calendar-days"></i> {{ DateFormat($data->updated_at) }}
                                    <br>
                                    <i class="fa-solid fa-clock"></i> {{ TimeFormat($data->updated_at) }}
                                </p>
                            </div>
                            @if ($data->attachments != null)
                                @foreach ($attachments as $attachment)
                                    <div class="card-footer">
                                        <ul class="mailbox-attachments d-flex align-items-stretch clearfix">
                                            <li>
                                                <div class="mailbox-attachment-info">
                                                    <a href="{{ asset('storage/' . $attachment->value) }}" target="_blank"
                                                        class="mailbox-attachment-name">
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
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>

            </div>
            <!-- /.container-fluid -->
        </section>
        {{-- Main Support Ticket Ends --}}

        {{-- All Support Ticket Replies --}}
        <section class="content">
            <div class="container-fluid">
                @foreach ($supportTicketReply as $reply)
                    <div class="row {{ $reply->reply_by != null ? '' : 'd-flex flex-row-reverse' }}">
                        <div class="col-lg-10 col-10">
                            <div class="card {{ $reply->reply_by != null ? 'card-outline-right' : 'card-outline-left' }}">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        {{ $reply->reply_by != null ? getAdminName($reply->reply_by) : getUserName($reply->user_id) }}
                                    </h3>
                                    <div class="card-tools">
                                        {{ $reply->reply_by != null ? 'Staff Reply' : 'My Reply' }}
                                    </div>
                                </div>
                                <div class="card-body p-1">
                                    <div class="mailbox-read-message pl-2">
                                        {!! nl2br($reply->message) !!}
                                    </div>
                                </div>
                                <div class="card-footer p-1">
                                    <p class="mailbox-read-time m-0 pl-2">
                                        <i class="fa-solid fa-calendar-days"></i> {{ DateFormat($reply->updated_at) }}
                                        <br>
                                        <i class="fa-solid fa-clock"></i> {{ TimeFormat($reply->updated_at) }}
                                    </p>
                                </div>
                                @if ($reply->attachments != null)
                                    @foreach (json_decode($reply->attachments) as $attachment)
                                        <div class="card-footer">
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
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <!-- /.container-fluid -->
        </section>
        {{-- All Support Ticket Replies Ends --}}

        {{-- Reply card --}}
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <form action="{{ route('customer-support.update', $data->id) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <input type="hidden" name="support_ticket_id" value="{{ $data->id }}">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <textarea id="compose-textarea" class="form-control" name="message" style="height: 300px"></textarea>
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
                                        <p class="help-block">Max file size. 5MB. Allowed file types: .doc, .docx, .pdf, .jpeg, .jpg, .png</p>
                                                <span id="error-message" style="color: red;"></span>
                                    </div>
                                </div>

                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <button type="button" class="btn btn-flat btn-theme add-more">Add more...</button>
                                </div>
                            </div>
                            {{-- /.row --}}

                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-flat btn-primary">
                                <i class="far fa-envelope"></i>
                                Reply Ticket
                            </button>
                        </div>
                    </form>
                </div>
                <!-- /.card -->
            </div>
            <!-- /.container-fluid -->
        </section>
        {{-- Reply card Ends --}}

    </div>
    {{-- /.content-wrapper --}}
@endsection

@section('scripts')
    <script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Listen for changes in select elements with class 'changeStatusPriority'
            $('.changeStatusPriority').change(function() {
                const selectedStatus = $('select[name="ticket_status_id"]').val();
                const selectedPriority = $('select[name="support_ticket_priority_id"]').val();
                const changeStatusPriority = `?status=${selectedStatus}&priority=${selectedPriority}`;

                if ($(this).val() !== '') {
                    $('#changeStatusPriority').attr('href', changeStatusPriority).show();
                } else {
                    $('#changeStatusPriority').hide();
                }
            });

            // Attachments
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

        // Show summernote
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
    </script>
@endsection
