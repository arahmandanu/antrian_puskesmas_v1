@extends('admin.shared.main')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Poli Create</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        @include('flash::message')
                        <form role="form" method="POST" action="{{ route('admin.loket.update', $loket->id) }}">
                            @method('PUT')
                            @csrf
                            <div class="form-group">
                                <label>Nama Staff</label>
                                <input class="form-control" name="staff_name" placeholder="Masukkan nama staff" required
                                    value="{{ $loket->staff_name ?? '' }}">
                            </div>

                            <div class="form-group">
                                <label>Nomor Loket</label>
                                <select class="form-control" required name="locket_number">
                                    @forelse ($availableLokets as $code)
                                        <option value="{{ $code }}"
                                            {{ $loket->locket_number == $code ? 'selected' : '' }}>
                                            {{ $code }}</option>
                                    @empty
                                        <option value="">Sudah Habis (Silahkan hubungi developer anda)</option>
                                    @endforelse
                                </select>
                            </div>

                            <button type="submit" class="btn btn-success">Submit</button>

                            <button type="reset" class="btn btn-warning">Reset</button>
                        </form>
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
