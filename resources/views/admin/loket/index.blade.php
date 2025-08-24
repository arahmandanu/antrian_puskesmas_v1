@extends('admin.shared.main')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Loket</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading d-flex align-items-center">
                        <span class="fw-bold me-auto">List</span>
                        <a type="button" href="{{ route('admin.loket.create') }}" class="btn btn-success">
                            Tambah Loket <i class="fa fa-plus"></i>
                        </a>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        @include('flash::message')
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="loket-table">
                                <thead>
                                    <tr>
                                        <th>Nomor Loket</th>
                                        <th>Nama Staff</th>
                                        <th>Letak</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($lokets as $loket)
                                        <tr class="odd gradeX">
                                            <td>{{ $loket->locket_number }}</td>
                                            <td>{{ $loket->staff_name }}</td>
                                            <td>Lantai {{ $loket->lantai }}</td>
                                            <td class="center">
                                                <a type="button" href="{{ route('admin.loket.edit', $loket->id) }}"
                                                    class="btn btn-success btn-circle"><i class="fa fa-pencil"></i>
                                                </a>

                                                {{-- @if (Auth()->user()->hasRole('admin'))
                                                    <button type="button" class="btn btn-danger btn-circle"><i
                                                            class="fa fa-trash"></i></button>
                                                @endif --}}
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
            $('#loket-table').DataTable({
                responsive: true,
                columnDefs: [],
                autoWidth: false,
                language: {
                    emptyTable: "No Loket found"
                }
            });
        });
    </script>
@endsection
