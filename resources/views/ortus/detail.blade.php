@extends('adminlte::page')
@section('tittle','Detail Orang Tua')
@section('content_header')

<h3 class="m-0 text-dark">Halaman Detail Wali  |
Nama Wali, <button class="btn btn-success">{{$ortu->nama_ortu}}</button></h3>
@stop
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="mb-3">
                    <a href="{{ route('ortus.index')}}" class="btn btn-primary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
                <form>
                    <div class="form-group">
                        <label for="nama_ortu">Nama Orang Tua</label> <br>
                        <input type="text" class="form-control" id="nama_ortu" value="{{$ortu->nama_ortu}}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="nama_ortu">Tanggal Lahir</label> <br>
                        <input type="text" class="form-control" id="nama_ortu" value="{{$ortu->tanggal_lahir}}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="jenis_kelamin">Jenis Kelamin</label> <br>
                        <input type="text" class="form-control" id="jenis_kelamin" value="{{$ortu->jenis_kelamin}}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat</label> <br>
                        <input type="text" class="form-control" id="alamat" value="{{$ortu->alamat}}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="email">Email Wali</label> <br>
                        <input type="text" class="form-control" id="email" value="{{$ortu->email ?? '-'}}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="no_hp">No Hp Wali</label> <br>
                        <input type="text" class="form-control" id="no_hp" value="{{$ortu->no_hp}}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="role">Role Wali</label> <br>
                        <input type="text" class="form-control" id="role" value="{{ $ortu->roles->nama_roles }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="nama_anak">Nama Anak</label> <br>
                        <input type="text" class="form-control" id="nama_anak" value="{{ $ortu->murids->nama_murid }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="nama_anak">Tahun Ajaran Anak</label> <br>
                        <input type="text" class="form-control" id="tahun_ajaran" value="{{ $ortu->murids->tahunAjaran->kode_ta }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="kelas_anak">Kelas Anak</label> <br>
                        <input type="text" class="form-control" id="kelas_anak" value="{{ $ortu->murids->kelas->nama_kelas }}" readonly>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection