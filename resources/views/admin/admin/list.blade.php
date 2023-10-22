@extends('layouts.app')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Admin List (Total : {{ $getRecords->total() }})</h1>
                    </div>
                    <div class="col-sm-6" style="text-align: right;">
                        <a href="{{ url('admin/admin/add') }}" class="btn btn-primary">Add New Admin</a>
                    </div>

                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- /.col -->
                    <div class="col-md-12">

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Search Admin</h3>
                            </div>
                            <form method="get" action="">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-3">
                                            <label for="">Name</label>
                                            <input type="text" name="name" class="form-control" value="{{ Request::get('name')}}" placeholder="Enter name">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="">Email</label>
                                            <input type="text" name="email" class="form-control" value="{{ Request::get('email')}}" placeholder="Enter email"}}">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="">Date</label>
                                            <input type="date" name="date" class="form-control" value="{{ Request::get('date')}}" placeholder="Enter date"}}">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <button type="submit" class="btn btn-primary" style="margin-top: 30px;">Search</button>
                                            <a href="{{ url('admin/admin/list') }}" class="btn btn-success" style="margin-top: 30px;">Clear</a>
                                        </div>
                                    </div>
                                </div>
                            </form>


                        </div>

                        @include('_message')
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Admin list</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body p-0">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Create Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($getRecords as $record)
                                            <tr>
                                                <td>{{ $record->id }}</td>
                                                <td>{{ $record->name }}</td>
                                                <td>{{ $record->email }}</td>
                                                <td>{{ $record->created_at }}</td>
                                                <td>
                                                    <a href="{{ url('admin/admin/edit/' . $record->id) }}"
                                                        class="btn btn-primary">Edit</a>
                                                    <a href="{{ url('admin/admin/delete/' . $record->id) }}"
                                                        class="btn btn-danger">Delete</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div style="padding: 10px; float: right;">
                                    {!! $getRecords->appends(Illuminate\Support\Facades\Request::except('page'))->links() !!}

                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
