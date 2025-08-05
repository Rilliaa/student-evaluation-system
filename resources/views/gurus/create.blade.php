@extends('adminlte::page')
@section('title', 'Tambah Guru')
@section('content_header')
<h1 class="m-0 text-dark">Tambah Data Guru</h1>
@stop
@section('content')
    <form action="{{route('gurus.store')}}" method="post">
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                            <div class="form-group">
                                <label for="exampleInputSubject">NIP:</label>
                                <input type="text" class="form-control @error('nip') is-invalid @enderror" id="exampleInputSubject" placeholder="NIP Guru" name="nip" value="{{ old('nip') }}">
                                @error('nip')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputName">Nama Guru:</label>
                                <input type="text" class="form-control @error('nama_guru') is-invalid @enderror" id="exampleInputName" placeholder="Nama lengkap" name="nama_guru" value="{{ old('nama_guru') }}">
                                @error('nama_guru')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
        
                            {{-- <div class="form-group">
                                <label for="exampleInputSubject">Mata Pelajaran:</label>
                                <input type="text" class="form-control @error('id_mapel') is-invalid @enderror" id="exampleInputSubject" placeholder="Mata pelajaran yang diajarkan" name="id_mapel" value="{{ old('id_mapel') }}">
                                @error('id_mapel')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>  --}}
                            {{-- <div class="form-group">
                                <label for="id_mapel">Pilih Mapel Yang Di Ampu</label>
                                <select name="id_mapel" id="id_mapel" class="form-control">
                                    <option value="">Tidak Ada</option>
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
                                <input type="text" class="form-control @error('alamat') is-invalid @enderror" id="exampleInputSubject" placeholder="Alamat" name="alamat" value="{{ old('alamt') }}">
                                @error('alamt')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div> 
                            <div class="form-group">
                                <label for="exampleInputSubject">E-mail:</label>
                                <input type="text" class="form-control @error('email') is-invalid @enderror" id="exampleInputSubject" placeholder="Email Guru" name="email" value="{{ old('email') }}">
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div> 
                            {{-- <div class="form-group">
                                <label for="exampleInputSubject">Role:</label>
                                <input type="text" class="form-control @error('role') is-invalid @enderror" id="exampleInputSubject" placeholder="Role" name="role" value="{{ old('role') }}">
                                @error('role')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div> --}}
                            <div class="form-group">
                                <label for="role">Pilih Role</label>
                                <select name="role" id="role" class="form-control">
                                    <option value="" selected disabled>-- Pilih Role --</option>
                                    @foreach($roles as $role)
                                    <option value="{{ $role->id_roles    }}">{{ $role->nama_roles }}</option>
                                    @endforeach
                                </select>
                                @error('role')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <a href="{{ route('gurus.index') }}" class="btn btn-secondary">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
