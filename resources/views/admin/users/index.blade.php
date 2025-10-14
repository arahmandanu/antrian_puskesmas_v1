@extends('admin.shared.main')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Users</h1>
            </div>
            <div class="col-lg-12">
                @include('flash::message')
            </div>
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        List <a href="{{ route('admin.users.create') }}" type="button" class="btn btn-primary btn-circle"><i
                                class="fa fa-user-plus"></i></a>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="user-table">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr class="odd gradeX">
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->getModifiedRoleName() }}</td>
                                            <td class="center">
                                                <button type="button" class="btn btn-success btn-circle">
                                                    <i class="fa fa-pencil"></i>
                                                </button>

                                                @if (Auth()->user()->hasRole('super admin') && $user->id !== auth()->user()->id)
                                                    <form action="{{ route('admin.users.destroy', $user->id) }}"
                                                        method="post" style="display:inline;">
                                                        @method('delete')
                                                        @csrf
                                                        <button type="submit" class="btn btn-danger btn-circle"
                                                            onclick="return confirm('Yakin ingin menghapus user ini?')">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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

    <script>
        $(document).ready(function() {
            $('#user-table').DataTable({
                responsive: true
            });
        });
    </script>
@endsection
