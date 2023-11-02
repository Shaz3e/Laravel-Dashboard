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

        @include('admin.support-tickets.support-dashboard')

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-3">
                        <a href="{{ route('admin.support-tickets.create') }}"
                            class="btn btn-primary btn-theme btn-block mb-3">Compose</a>
                        @include('admin.support-tickets.sidebar')
                    </div>
                    <!-- /.col -->
                    <div class="col-md-9">
                        <div class="card card-outline">
                            <div class="card-header">
                                <h3 class="card-title">Inbox</h3>
                                <div class="card-tools">
                                    <form class="input-group input-group-sm">
                                        <input type="text" class="form-control" name="search"
                                            value="{{ isset($_GET['search']) ? $_GET['search'] : '' }}"
                                            placeholder="Search Mail">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                <!-- /.card-tools -->
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body p-0">
                                <div class="mailbox-controls px-3">
                                    <div class="w-100 d-flex justify-content-end align-items-center">
                                        {{ $dataSet->links('admin.support-tickets.pagination') }}
                                    </div>
                                </div>
                                <div class="table-responsive mailbox-messages">
                                    <table class="table table-hover table-striped">
                                        <tbody>
                                            @foreach ($dataSet as $data)
                                                <tr onclick="location.href='{{ route('admin.support-tickets.show', $data->id) }}'"
                                                    role="button">
                                                    <td class="mailbox-name">
                                                        {{ shortTextWithOutHtml($data->title) }}
                                                        <br>
                                                        {{ shortTextWithOutHtml($data->message) }}
                                                    </td>
                                                    <td class="mailbox-subject">
                                                    </td>
                                                    <td class="mailbox-attachment">
                                                        @if ($data->attachments != null)
                                                            <i class="fas fa-paperclip"></i>
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                    <td class="mailbox-date">
                                                        <small>
                                                            {{ dateFormat($data->created_at) }}
                                                            <br>
                                                            {{ timeFormat($data->created_at) }}
                                                        </small>
                                                    </td>
                                                    <td class="mailbox-date">
                                                        <small>
                                                            {{ dateFormat($data->updated_at) }}
                                                            <br>
                                                            {{ timeFormat($data->updated_at) }}
                                                        </small>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <!-- /.table -->
                                </div>
                                <!-- /.mail-box-messages -->
                            </div>
                            <div class="card-body p-0">
                                <div class="mailbox-controls px-3">
                                    <div class="w-100 d-flex justify-content-end align-items-center">
                                        {{ $dataSet->links('admin.support-tickets.pagination') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            {{-- /.container-fluid --}}
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection

@section('scripts')
@endsection
