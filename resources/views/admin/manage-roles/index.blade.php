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
                        <h1>Dashboard Role List</h1>
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
                    <h3 class="card-title">View all dashboard roles</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.manage-roles.create') }}" class="btn btn-flat btn-sm btn-theme">
                            <i class="fa-regular fa-square-plus"></i> Create New</a>
                    </div>
                </div>
                <div class="card-body">

                    <table id="dataList" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Role Name</th>
                                <th>Permissions</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dataSet as $data)
                                @if ($data->id != 1)
                                    <tr>
                                        <td>
                                            {{ $data->name }}
                                        </td>
                                        <td>
                                            <span
                                                class="badge badge-themebadge badge-primary bg-theme">{{ $data->permissions()->count() }}</span>
                                        </td>
                                        <td>
                                            <a class="btn btn-flat btn-primary"
                                                href="{{ route('admin.manage-roles.edit', $data->id) }}">
                                                <i class="fa-regular fa-pen-to-square"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endif
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
@endsection
