@extends('adminlte::page')
@section('title', 'Tambah Data Roles')
@section('content_header')
<h1 class="m-0 text-dark">Tambah Data Role | Peran</h1>
@stop
@section('content')
    <form action="{{route('roles.store')}}" method="post">
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                            <div class="form-group">
                                <a class="form-group">
                                <label for="nama_roles">Nama Roles:</label>
                                <select name="nama_roles" id="nama_roles" class="form-control">
                                   <option value="Admin">Admin</option>
                                   <option value="Guru">Guru</option>
                                   <option value="Wali Murid">Wali Murid</option>
                                   <option value="Murid">Murid</option>
                                   <option value="Alumni">Alumni</option>
                                </select>
                            @error('nama_roles')
                            <span class="text-danger">{{ $message }}</span>
                             @enderror
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <a href="{{ route('roles.index') }}" class="btn btn-secondary">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
