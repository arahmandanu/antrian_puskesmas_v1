@extends('admin.shared.main')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Users</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Form Tambah User
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="panel-body">
                            @include('flash::message')
                            <form role="form" method="POST" action="{{ route('admin.users.store') }}">
                                @csrf
                                <div class="form-group">
                                    <label>Nama User</label>
                                    <input class="form-control" type="text" name="name"
                                        placeholder="Masukkan nama user" required>
                                </div>

                                <div class="form-group">
                                    <label>Email User</label>
                                    <input class="form-control" type="email" name="email"
                                        placeholder="Masukkan email user" required>
                                </div>

                                <div class="form-group">
                                    <label>Password User</label>
                                    <input class="form-control" name="password" placeholder="Masukkan password user"
                                        required>
                                </div>

                                <button type="submit" class="btn btn-success">Submit</button>

                                <button type="reset" class="btn btn-warning">Reset</button>
                            </form>
                        </div>
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
            <!-- /.col-lg-12 -->
        </div>
    </div>
    <!-- /.container-fluid -->
@endsection
