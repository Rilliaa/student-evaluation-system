@extends('adminlte::page')
@section('title', 'Tambah Admin')
@section('content_header')
    <h1 class="m-0 text-dark">Tambah Admin</h1>
@stop
@section('content')
    <form action="{{route('users.store')}}" method="post">
        @csrf
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label for="exampleInputName">Nama</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" required id="exampleInputName" placeholder="Nama lengkap" name="name">
                        @error('name') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputName">Nomor Hp</label>
                        <input type="number" class="form-control @error('no_hp') is-invalid @enderror" required id="exampleInputName" placeholder="Nomor Hp" name="no_hp">
                        @error('no_hp') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail">Email address</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" required id="exampleInputEmail" placeholder="Masukkan Email" name="email">
                        @error('email') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" required id="exampleInputPassword" placeholder="Password" name="password">
                        @error('password') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword">Konfirmasi Password</label>
                        <input type="password" class="form-control" id="exampleInputPassword" required placeholder="Konfirmasi Password" name="password_confirmation">
                    </div>
                    <div class="form-group">
                        <label for="role">Pilih Role:</label>
                        <select name="id_role" id="id_role" class="form-control" required>
                            <option value="" selected disabled> -- Pilih Role -- </option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id_roles }}">{{ $role->nama_roles }}</option>
                            @endforeach
                        </select>
                        @error('id_role')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{route('users.index')}}" class="btn btn-default">
                        Batal
                    </a>
                </div>
            </div>
        </div>
    </div>
    </form>
@stop

