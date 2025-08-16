@extends('admin.shared.main')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Poli Detail</h1>
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

                        <form role="form" method="POST" action="{{ route('admin.poli.update', $poli->id) }}">
                            @method('PUT')
                            @csrf
                            <div class="form-group">
                                <label>Nama Poli</label>
                                <input class="form-control" name="name" placeholder="Masukkan nama poli" required
                                    value="{{ $poli->name ?? '' }}">
                            </div>

                            <div class="form-group">
                                <label>Kode Poli</label>
                                <select class="form-control" required name="code">
                                    @forelse ($availableCodes as $code)
                                        <option value="{{ $code }}" {{ $code == $poli->code ? 'selected' : '' }}>
                                            {{ $code }}</option>
                                    @empty
                                        <option value="">Sudah Habis (Silahkan hubungi developer anda)</option>
                                    @endforelse
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Letak Poli (lantai)</label>
                                <select class="form-control" required name="lantai">
                                    @forelse ($lantaiOptions as $lantai)
                                        <option value="{{ $lantai }}"
                                            {{ $poli->lantai == $lantai ? 'selected' : '' }}>{{ $lantai }}</option>
                                    @empty
                                        <option value="">Silahkan hubungi developer anda</option>
                                    @endforelse
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Tampilkan</label>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="show" id="optionsRadios1" value="1"
                                            {{ $poli->show ? 'checked' : '' }}>
                                        ya
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="show" id="optionsRadios2" value="0"
                                            {{ $poli->show ? '' : 'checked' }}>
                                        tidak
                                    </label>
                                </div>
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
