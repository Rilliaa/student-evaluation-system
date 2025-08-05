@extends('adminlte::page')

@section('title', 'Edit Murid')

@section('content_header')
    <h1 class="m-0 text-dark">Edit Data Role</h1>
@stop

@section('content')
    <form action="{{ route('roles.update', $role) }}" method="post">
        @method('PUT')
        @csrf
        <div class="form-group">
            <label for="exampleInputSubject">Nama Role:</label>
            <input type="text" class="form-control @error('nama_roles') is-invalid @enderror" id="exampleInputSubject" placeholder="Nama Role" name="nama_roles" value="{{ old('nama_roles', $role->nama_roles) }}">
            @error('nama_roles')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('roles.index') }}" class="btn btn-default">Batal</a>
                 </div>
                </div>
            </div>
        </div>
    </form>
@stop
