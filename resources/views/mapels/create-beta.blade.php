@extends('adminlte::page')
@section('title', 'Tambah Mapel')
@section('content_header')
<h1 class="m-0 text-dark">Tambah Mata Pelajaran</h1>
@stop
@section('content')
    <form action="{{route('mapels.store')}}" method="post">
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="exampleInputSubject">Kode Mata Pelajaran:</label>
                            <input type="text" class="form-control @error('kode_mapel') is-invalid @enderror" id="exampleInputSubject" placeholder="Kode Mata Pelajaran" name="kode_mapel" value="{{ old('kode_mapel') }}">
                            @error('kode_mapel')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        
                            <div class="form-group">
                                <label for="exampleInputName">Nama Mata Pelajaran:</label>
                                <input type="text" class="form-control @error('nama_mapel') is-invalid @enderror" id="exampleInputName" placeholder="Nama Mata Pelajaran" name="nama_mapel" value="{{ old('nama_mapel') }}">
                                @error('nama_mapel')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="id_guru">Pilih Guru Pengampu</label>
                                <select name="id_guru" id="id_guru" class="form-control">
                                    @foreach($gurus as $guru)
                                    <option value="{{ $guru->id_guru }}">{{ $guru->nama_guru }}</option>
                                    @endforeach
                                </select>
                                @error('id_mapel')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <a href="{{ route('mapels.index') }}" class="btn btn-secondary">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
