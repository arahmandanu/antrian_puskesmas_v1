@extends('admin.shared.main')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Detail Puskesmas</h1>
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

                        <form role="form" method="POST" action="{{ route('admin.company.update', $company->id) }}">
                            @method('PUT')
                            @csrf
                            <div class="form-group">
                                <label>Puskesmas</label>
                                <input class="form-control" disabled value="{{ $company->name ?? '-' }}"
                                    placeholder="Masukkan nama staff">
                            </div>

                            <div class="form-group">
                                <label>Alamat</label>
                                <input class="form-control" value="{{ $company->address ?? '-' }}" disabled>
                            </div>

                            <div class="form-group">
                                <label>Printer Loket</label>
                                <input class="form-control" name="printer" value="{{ $company->printer ?? '' }}">
                            </div>

                            <div class="form-group">
                                @if ($company->active ?? false)
                                    <span class="btn btn-success">Active</span>
                                @else
                                    <span class="btn btn-danger">Tidak Active</span>
                                @endif
                            </div>

                            <button type="submit">Save</button>
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
