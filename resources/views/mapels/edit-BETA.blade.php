@extends('adminlte::page')

@section('title', 'Edit Mata Pelajaran')

@section('content_header')
    <h1 class="m-0 text-dark">Edit Data Mata Pelajaran</h1>
@stop

@section('content')
    <form action="{{ route('mapels.update', $mapel) }}" method="post">
        @method('PUT')
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="exampleInputSubject">Kode Mata Pelajaran:</label>
                            <input type="text" class="form-control @error('kode_mapel') is-invalid @enderror" id="exampleInputSubject" placeholder="Kode Mata Pelajaran" name="kode_mapel" value="{{ old('kode_mapel',$mapel->kode_mapel) }}">
                            @error('kode_mapel')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                                                                                                                                                                                
                        <div class="form-group">
                            <label for="exampleInputName">Nama Mata Pelajaran:</label>
                            <input type="text" class="form-control @error('nama_mapel') is-invalid @enderror" id="exampleInputName" placeholder="Nama Mata Pelajaran" name="nama_mapel" value="{{ old('nama_mapel',$mapel->nama_mapel) }}">
                            @error('nama_mapel')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="id_guru">Pilih Guru Pengampu</label>
                            <select name="id_guru" id="id_guru" class="form-control">
                                @foreach($gurus as $guru)
                                    <option value="{{ $guru->id_guru }}" {{ $guru->id_guru == $mapel->id_guru ? 'selected' : '' }}>
                                        {{ $guru->nama_guru }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_guru')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('mapels.index') }}" class="btn btn-default">Batal</a>
                    </div>
                </div>
            </div>
        </div>
    </form>
@stop
