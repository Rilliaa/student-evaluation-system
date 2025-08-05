@extends('adminlte::page')

@section('title', 'Edit Guru')

@section('content_header')
    <h1 class="m-0 text-dark">Edit Data Guru</h1>
@stop

@section('content')

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

    <form action="{{ route('gurus.update', $guru) }}" method="post">
        @method('PUT')
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="exampleInputSubject">NIP:</label>
                            <input type="text" class="form-control @error('nip') is-invalid @enderror" id="exampleInputSubject" placeholder="NIP Guru" name="nip" value="{{ old('nip', $guru->nip) }}">
                            @error('nip')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="exampleInputName">Nama Guru:</label>
                            <input type="text" class="form-control @error('nama_guru') is-invalid @enderror" id="exampleInputName" placeholder="Nama lengkap" name="nama_guru" value="{{ old('nama_guru', $guru->nama_guru) }}">
                            @error('nama_guru')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
    
                        {{-- <div class="form-group">
                            <label for="exampleInputSubject">Mata Pelajaran:</label>
                            <input type="text" class="form-control @error('id_mapel') is-invalid @enderror" id="exampleInputSubject" placeholder="Mata pelajaran yang diajarkan" name="id_mapel" value="{{ old('id_mapel', $guru->id_mapel) }}">
                            @error('id_mapel')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>  --}}
                        {{-- <div class="form-group">
                            <label for="id_mapel">Pilih Mapel Yang Di Ampu</label>
                            <select name="id_mapel" id="id_mapel" class="form-control">
                                @foreach($mapels as $mapel)
                                <option value="{{ $mapel->id_mapel }}">{{ $mapel->nama_mapel }}</option>
                                @endforeach
                            </select>
                            @error('id_mapel')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div> --}}
                        <div class="form-group">
                            <label for="exampleInputSubject">Alamat:</label>
                            <input type="text" class="form-control @error('alamat') is-invalid @enderror" id="exampleInputSubject" placeholder="Alamat" name="alamat" value="{{ old('alamat', $guru->alamat) }}">
                            @error('alamat')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div> 
                        <div class="form-group">
                            <label for="exampleInputSubject">E-mail:</label>
                            <input type="text" class="form-control @error('email') is-invalid @enderror" id="exampleInputSubject" placeholder="Mata pelajaran yang diajarkan" name="email" value="{{ old('email', $guru->email) }}">
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div> 
                        {{-- <div class="form-group">
                            <label for="exampleInputSubject">Role:</label>
                            <input type="text" class="form-control @error('role') is-invalid @enderror" id="exampleInputSubject" placeholder="Mata pelajaran yang diajarkan" name="role" value="{{ old('role', $guru->role) }}">
                            @error('role')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div> --}}
                        <div class="form-group">
                            <label for="role">Pilih Role</label>
                            <select name="role" id="role" class="form-control">
                                @foreach($roles as $role)
                                <option value="{{ $role->id_roles    }}">{{ $role->nama_roles }}</option>
                                @endforeach
                            </select>
                        </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('gurus.index') }}" class="btn btn-default">Batal</a>
                    </div>
                </div>
            </div>
        </div>
    </form>
@stop
