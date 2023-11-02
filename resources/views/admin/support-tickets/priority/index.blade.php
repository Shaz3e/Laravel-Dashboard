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
                        <h1>Support Ticket Priority List</h1>
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
                    <h3 class="card-title">View all ticket priority</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.priority.create') }}" class="btn btn-flat btn-sm btn-theme"><i
                                class="fa-regular fa-square-plus"></i> Create
                            New</a>
                    </div>
                </div>
                <div class="card-body">

                    <table id="dataList" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Priority Name</th>
                                <th>Active/Inactive</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dataSet as $data)
                                <tr>
                                    <td>{{ $data->id }}</td>
                                    <td>{{ $data->name }}</td>
                                    <td>
                                        @if ($data->is_active == 1)
                                            <span class="badge badge-success">Enable</span>
                                        @else
                                            <span class="badge badge-danger">Disable</span>
                                        @endif
                                    </td>

                                    <td>
                                        <a class="btn btn-flat btn-primary"
                                            href="{{ route('admin.priority.edit', $data->id) }}"><i
                                                class="fa-regular fa-pen-to-square"></i></a>
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
                                        {{-- @endif --}}
                                        <form action="{{ route('admin.priority.destroy', $data->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" onclick="DeleteFormSubmit(this)"
                                                class="btn btn-flat btn-danger">
                                                <i class="fa-solid fa-trash-can"></i>
                                                </a>
                                        </form>
                                    </td>
                                    {{-- @endif --}}
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
                "order": [
                    [0, "asc"]
                ],
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#dataList_wrapper .col-md-6:eq(0)');
        });
    </script>
    <script>
        function DeleteFormSubmit(element) {
            $(element).attr("type", "submit");
            $(element).click();
        }
    </script>
@endsection
