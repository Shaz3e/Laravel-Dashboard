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
                        <h1>Permissions</h1>
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
                    <div class="card-tools">
                        <a href="{{ route('admin.app-permissions.create') }}" class="btn btn-flat btn-sm btn-theme"><i
                                class="fa-regular fa-square-plus"></i> Create New</a>
                    </div>
                </div>
                <div class="card-body">

                    <table id="dataList" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <td>Permission Name</td>
                                <td>Roles</td>
                                <td>Action</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dataSet as $data)
                                <tr>
                                    <td>{{ $data->name }} </td>
                                    <td>
                                        @foreach ($data->roles as $role)
                                            <span class="badge badge-primary bg-theme">{{ $role->name }}</span>
                                        @endforeach
                                    </td>
                                    <td>
                                        {{-- Edit Request --}}
                                        <a class="btn btn-flat btn-primary"
                                            href="{{ route('admin.app-permissions.edit', $data->id) }}" title="Edit">
                                            <i class="fa-regular fa-pen-to-square"></i>
                                        </a>
                                        <form action="{{ route('admin.app-permissions.destroy', $data->id) }}"
                                            method="POST" class="d-inline">
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
                // "paging" : false,
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#dataList_wrapper .col-md-6:eq(0)');
        });

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
