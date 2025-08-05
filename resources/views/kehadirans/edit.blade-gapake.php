 @extends('adminlte::page')

@section('title', 'Edit Kehadiran')

@section('content_header')
    <h1 class="m-0 text-dark">Edit Data Kehadiran Siswa</h1>
@stop

@section('content')
<form action="{{ route('kehadirans.update', $kehadiran->id) }}" method="post">

        @method('PUT')
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="id_murid">Pilih Murid</label>
                                <!-- Options for students -->
                                <select name="id_murid" id="id_murid" class="form-control">
                                    @foreach($murids as $murid)
                                        <option value="{{ $murid->id_murid }}">{{ $murid->nama_murid }}</option>
                                    @endforeach
                                </select>
                    
                        </div>
                       <div class="form-group">
                            <label for="tanggal">Tanggal:</label>
                            <input type="date" name="tanggal" id="tanggal" class="form-control">
                        </div>
                        
                        <div class="form-group">
                            <label for="keterangan">Keterangan:</label>
                            <textarea name="keterangan" id="keterangan" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="status">Status Kehadiran:</label>
                            <select name="status" id="status" class="form-control">
                                <option value="Hadir">Hadir</option>
                                <option value="Tidak Hadir">Tidak Hadir</option>
                                <option value="Izin">Izin</option>
                            </select>
                        </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('kehadirans.index') }}" class="btn btn-default">Batal</a>
                    </div>
                </div>
            </div>
        </div>
    </form>
@stop
