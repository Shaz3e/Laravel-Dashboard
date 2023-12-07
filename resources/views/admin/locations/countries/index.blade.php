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
                        <h1>Country List</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ DiligentCreators('dashboard_url') }}">Home</a></li>
                            <li class="breadcrumb-item active">All Countries</li>
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
                        <a href="{{ route('admin.countries.create') }}" class="btn btn-flat btn-default">Create New</a>
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-tool">
                            <i class="fas fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table id="dataList" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                {{-- <th>#</th> --}}
                                <th>Country</th>
                                <th>Alpha 2</th>
                                <th>Alpha 3</th>
                                <th>Currency</th>
                                <th>Currency Code</th>
                                <th>Calling Code</th>
                                <th>Enable/Disable</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($countries as $data)
                                <tr>
                                    {{-- <td>{{ $data->id }}</td> --}}
                                    <td>
                                        {{ $data->name }}
                                        <img class="img-fluid" width="25px" src="/{{ $data->flag }}">
                                    </td>
                                    <td>{{ $data->alpha2 }}</td>
                                    <td>{{ $data->alpha3 }}</td>
                                    <td>{{ $data->currency }}</td>
                                    <td>{{ $data->currency_code }}</td>
                                    <td>{{ $data->calling_code }}</td>
                                    <td>
                                        @if ($data->is_active == 1)
                                            <span class="badge badge-success">Active</span>
                                        @else
                                            <span class="badge badge-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($data->is_active == 1)
                                            <a class="btn btn-sm btn-flat btn-warning d-inlin-flex align-items-center"
                                                href="?status=0&id={{ $data->id }}" title="Edit">
                                                <i class="fa-regular fa-eye-slash fa-sm"></i>
                                            </a>
                                        @else
                                            <a class="btn btn-sm btn-flat btn-success d-inlin-flex align-items-center"
                                                href="?status=1&id={{ $data->id }}">
                                                <i class="fa-regular fa-eye fa-sm"></i>
                                            </a>
                                        @endif
                                        <a class="btn btn-sm btn-flat btn-primary"
                                            href="{{ route('admin.countries.edit', $data->id) }}" title="Edit">
                                            <i class="fa-regular fa-pen-to-square fa-sm"></i>
                                        </a>
                                        <form action="{{ route('admin.countries.destroy', $data->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" onclick="DeleteFormSubmit(this)"
                                                class="btn btn-sm btn-flat btn-danger">
                                                <i class="fa-solid fa-trash-can fa-sm"></i>
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

    <script>
        $(function() {
            $("#dataList").DataTable({
                "order": [
                    [0, "desc"]
                ],
                "responsive": true,
                "lengthChange": false,
                "autoWidth": true,
                "pageLength": 10,
                "lengthChange": true,
            }).buttons().container().appendTo('#dataList_wrapper .col-md-6:eq(0)');
        });
    </script>
@endsection
