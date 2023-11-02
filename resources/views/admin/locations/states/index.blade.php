@extends('layouts.app')

@section('styles')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <style>
        #dataList_info{
            display:none;
        }
    </style>
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>State List</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ DiligentCreators('dashboard_url') }}">Home</a></li>
                            <li class="breadcrumb-item active">View All</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <!-- Main content -->
        <section class="content">
            <!-- Default box -->
            <div class="card">
                <div class="card-header">
                    <div class="card-tools">
                        <a href="{{ route('admin.states.create') }}" class="btn btn-flat btn-default">Create New</a>
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    
                    <table id="dataList" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>State</th>
                                <th>State Code</th>
                                <th>Country</th>
                                <th>Enable/Disable</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dataSet as $data)
                                <tr>
                                    <td>{{ $data->id }}</td>
                                    <td>{{ $data->state_name }}</td>
                                    <td>{{ $data->state_code }}</td>
                                    <td>
                                        {{ $data->countryName }}
                                    </td>
                                    <td>
                                        @if ($data->is_active == 1)
                                            <span class="badge badge-success">Active</span>
                                        @else
                                            <span class="badge badge-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{-- Update Status --}}
                                        @if ($data->is_active == 1)
                                            <a class="btn btn-flat btn-warning d-inlin-flex align-items-center"
                                                href="?status=0&id={{ $data->id }}" title="Edit">
                                                <i class="fa-regular fa-eye-slash"></i>
                                            </a>
                                        @else
                                            <a class="btn btn-flat btn-success d-inlin-flex align-items-center"
                                                href="?status=1&id={{ $data->id }}">
                                                <i class="fa-regular fa-eye"></i>
                                            </a>
                                        @endif
                                        {{-- Update Status ends --}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="dataTables_paginate">
                        {{ $dataSet->links('pagination::bootstrap-5') }}
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
    <!-- DataTables  & Plugins -->
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

    <script>
        $(function() {
            $("#dataList").DataTable({
                "responsive": true,
                "autoWidth": false,
                "pageLength": 10,
                "lengthChange": true,
                "paging": false,
                // "language": {
                //     "info": ""
                // }
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#dataList_wrapper .col-md-6:eq(0)');
        });
    </script>
@endsection
