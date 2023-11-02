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
                    <tbody></tbody>
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
        var buttons = [
            "copy", "csv", "excel", "pdf", "print", "colvis"
        ];

        var table = $('#dataList').DataTable({
                "order": [
                    [0, "desc"]
                ],
            "responsive": true,
            "lengthChange": true,
            "autoWidth": true,
            "dom": 'Bfrtip',
            "buttons": buttons,
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('admin.countries.index') }}",
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'name',
                    name: 'name',
                    render: function(data, type, row) {
                        var flagImg = '<img src="' + '{{ asset("/") }}' + row.flag + '" class="w-auto rounded mr-2" style="max-height: 25px;" loading="lazy" decoding="async" />';
                        return flagImg + data;
                    }
                },
                {
                    data: 'alpha2',
                    name: 'alpha2'
                },
                {
                    data: 'alpha3',
                    name: 'alpha3'
                },
                {
                    data: 'currency',
                    name: 'currency'
                },
                {
                    data: 'currency_code',
                    name: 'currency_code'
                },
                {
                    data: 'calling_code',
                    name: 'calling_code'
                },
                {
                    data: 'is_active',
                    name: 'is_active',
                    render: function(data) {
                        var statusClass = data === 1 ? 'success' : 'danger';
                        return '<span class="badge badge-' + statusClass + '">' + (data === 1 ? 'Enable' : 'Disable') + '</span>';
                    }
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: true,
                    searchable: true
                },
            ]
        });

        table.buttons().container().appendTo('#dataList_wrapper .col-md-6:eq(0)');
    });
</script>
@endsection