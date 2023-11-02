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
                        <h1>Dashboard</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/admin">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Total Counts Clients, IB Clients, MT5 Groups, Transactions -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-12">
                        <!-- small box -->
                        <div class="small-box card card-outline">
                            <div class="inner">
                                <h3 class="text-theme">{{ $users }}</h3>

                                <p>Clients</p>
                            </div>
                            <div class="icon">
                                <i class="fa-solid fa-users"></i>
                            </div>
                        </div>
                    </div>
                    <!-- ./col -->
                </div>
            </div>
        </section>
        <!-- /.content -->

        <!-- Total Counts -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">User Login History</h3>
                            </div>
                            <div class="card-body">
                                <table id="dataList" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Full Name</th>
                                            <th>Email</th>
                                            <!-- <th>Browser</th>
                                                                                                                    <th>OS</th>
                                                                                                                    <th>Device</th> -->
                                            <th>IP</th>
                                            <th>Last Accessed</th>
                                            <th>View User</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($userLoginHistory as $login)
                                            <tr>
                                                <td>{{ $login->firstName }} {{ $login->lastName }}</td>
                                                <td>{{ $login->email }}</td>
                                                <!-- <td>{{ $login->browser }}</td>
                                                                                                                    <td>{{ $login->os }}</td>
                                                                                                                    <td>{{ $login->device }}</td> -->
                                                <td>{{ $login->ip_address }}</td>
                                                <td>{{ TimeAgo($login->date_time) }}</td>
                                                <td>
                                                    <a href="/admin/clients/{{ $login->userId }}"
                                                        class="btn btn-success">View</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- ./col -->
                </div>
            </div>
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
                "lengthChange": false,
                "autoWidth": false,
                "buttons": [
                    "copy",
                    "csv",
                    "excel",
                    "pdf",
                    "print",
                    "colvis"
                ]
            }).buttons().container().appendTo('#dataList_wrapper .col-md-6:eq(0)');
        });
    </script>
@endsection
