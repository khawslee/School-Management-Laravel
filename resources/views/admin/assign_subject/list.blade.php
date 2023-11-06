@extends('layouts.app')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Assign Subject List</h1>
                    </div>
                    <div class="col-sm-6" style="text-align: right;">
                        <a href="{{ url('admin/assign_subject/add') }}" class="btn btn-primary">Assign New Subject</a>
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
                                <h3 class="card-title">Search Subject</h3>
                            </div>
                            <form method="get" action="">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-3">
                                            <label for="">Class Name</label>
                                            <input type="text" name="class_name" class="form-control"
                                                value="{{ Request::get('class_name') }}" placeholder="Enter class name">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="">Subject Name</label>
                                            <input type="text" name="subject_name" class="form-control"
                                                value="{{ Request::get('subject_name') }}" placeholder="Enter subject name">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="">Date</label>
                                            <input type="date" name="date" class="form-control"
                                                value="{{ Request::get('date') }}" placeholder="Enter date"}}">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <button type="submit" class="btn btn-primary"
                                                style="margin-top: 30px;">Search</button>
                                            <a href="{{ url('admin/assign_subject/list') }}" class="btn btn-success"
                                                style="margin-top: 30px;">Clear</a>
                                        </div>
                                    </div>
                                </div>
                            </form>


                        </div>

                        @include('_message')
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Class Subject list</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body p-0">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Class</th>
                                            <th>Subject</th>
                                            <th>Status</th>
                                            <th>Create By</th>
                                            <th>Create Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($getRecords as $record)
                                            <tr>
                                                <td>{{ $record->id }}</td>
                                                <td>{{ $record->class_name }}</td>
                                                <td>{{ $record->subject_name }}</td>
                                                <td>
                                                    @if ($record->status == 1)
                                                        Active
                                                    @else
                                                        Inactive
                                                    @endif
                                                </td>
                                                <td>{{ $record->created_by_name }}</td>
                                                <td>{{ $record->created_at }}</td>
                                                <td>
                                                    <a href="{{ url('admin/assign_subject/edit/' . $record->id) }}"
                                                        class="btn btn-primary">Edit</a>
                                                    <a href="{{ url('admin/assign_subject/edit_single/' . $record->id) }}"
                                                        class="btn btn-success">Single Edit</a>
                                                    <a href="{{ url('admin/assign_subject/delete/' . $record->id) }}"
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
