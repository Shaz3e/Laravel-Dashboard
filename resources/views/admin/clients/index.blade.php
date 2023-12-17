@extends('layouts.app')

@section('styles')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Clients List</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ DiligentCreators('dashboard_url') }}">Home</a></li>
                            <li class="breadcrumb-item active">View All</li>
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
                    <div class="card-title">
                        {{-- Search Client --}}
                        <form action="{{ route('admin.clients.index') }}" method="GET">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control float-right" placeholder="Search"
                                    value="{{ old('search') }}">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default"><i
                                            class="fa-solid fa-magnifying-glass"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-tools">
                        @can('clients.create')
                            <a href="{{ route('admin.clients.create') }}" class="btn btn-flat btn-sm btn-theme"><i
                                    class="fa-regular fa-square-plus"></i> Create New</a>
                        @endcan
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dataList" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Full Name</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>Country</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dataSet as $data)
                                    <tr>
                                        <td>{{ $data->id }}</td>
                                        <td>{{ $data->first_name . ' ' . $data->last_name }}</td>
                                        <td>{{ $data->email }}</td>
                                        <td>{{ $data->mobile }}</td>
                                        <td>
                                            @if ($data->country != null)
                                                <img src="{{ asset('/') . $data->countryFlag }}"
                                                    class="w-auto rounded mr-2" style="max-height: 25px;" loading="lazy"
                                                    decoding="async" />
                                                {{ $data->countryName }}
                                            @endif
                                        </td>
                                        <td>
                                            @if ($data->is_verified == 1)
                                                <span class="badge badge-success">Verified</span>
                                            @else
                                                <span class="badge badge-danger">Not Verified</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{-- Edit Request --}}
                                            <a class="btn btn-flat btn-primary"
                                                href="{{ route('admin.clients.edit', $data->id) }}" title="Edit">
                                                <i class="fa-regular fa-pen-to-square"></i>
                                            </a>
                                            <form action="{{ route('admin.clients.destroy', $data->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" onclick="DeleteFormSubmit(this)"
                                                    class="btn btn-flat btn-danger">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{-- Bootstrap Links --}}
                        <div class="dataTables_paginate">
                            {{ $dataSet->links('pagination::bootstrap-5') }}
                        </div>
                    </div>

                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection

@section('scripts')
    <script>
        function DeleteFormSubmit(element) {
            toastr["warning"](
                '<button type="button" id="yes-btn" class="btn btn-flat btn-sm btn-success mr-1">Yes</button> ' +
                ' <button type="button" id="no-btn" class="btn btn-flat btn-sm btn-danger ml-1">No</button>',
                "Are you sure you want to delete this?", {
                    closeButton: false,
                    progressBar: false,
                    tapToDismiss: false,
                    onShown: function(toast) {
                        // Handle "Yes" button click
                        $("#yes-btn").click(function() {
                            $(element).attr("type", "submit");
                            $(element).attr("onclick", "");
                            toastr.clear(toast);
                            $(element).click();
                        });

                        // Handle "No" button click
                        $("#no-btn").click(function() {
                            $(element).attr("type", "button");
                            toastr.clear(toast);
                        });
                    },
                    onCloseClick: function() {
                        $(element).attr("type", "button");
                    }
                }
            );
        }
    </script>
@endsection
