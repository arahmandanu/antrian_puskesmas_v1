@extends('admin.shared.main')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Poli</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading d-flex align-items-center">
                        <span class="fw-bold me-auto">List</span>
                        <a type="button" href="{{ route('admin.poli.create') }}" class="btn btn-success">
                            Tambah Poli <i class="fa fa-plus"></i>
                        </a>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="poli-table">
                                <thead>
                                    <tr>
                                        <th>Kode</th>
                                        <th>Nama</th>
                                        <th>Tampilkan</th>
                                        <th>Lantai</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($rooms as $room)
                                        <tr class="odd gradeX">
                                            <td>{{ $room->code }}</td>
                                            <td>{{ $room->name }}</td>
                                            <td>
                                                {!! $room->show ? '<i class="fa fa-check">' : '<i class="fa  fa-close">' !!}
                                            </td>
                                            <td>{{ $room->lantai }}</td>
                                            <td class="center">
                                                <a type="button" href="{{ route('admin.poli.edit', $room->id) }}"
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
            $('#poli-table').DataTable({
                responsive: true,
                columnDefs: [],
                autoWidth: false,
                language: {
                    emptyTable: "No Poli found"
                }
            });
        });
    </script>
@endsection
