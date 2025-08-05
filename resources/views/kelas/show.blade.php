@extends('adminlte::page')

@section('title', 'Halaman Kelas | Rincian Nilai | Daftar Nama Murid')

@section('content_header')
    <h1 class="m-0 text-dark">Halaman Kelola Nilai | <span style="color: #ff9e2a; font-weight :bold" > Daftar Nama Murid</span></h1>
    <div class="d-flex justify-content-between mt-2">
        <div>
            <h3 class="d-inline-block mt-3">Kelas, <span style="color: #ff9e2a; font-weight :bold">{{ $kelas->nama_kelas }}</span></h3>
        </div>
        <div>
            <h3 class="d-inline-block mt-3">Kode Tahun Ajaran: <button class="btn btn-primary">{{ $kelas->tahunAjaran->kode_ta }}</button></h3>
        </div>
    </div>
@stop

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <a href="{{ route('rincians.index') }}" class="btn btn-primary">
                <i class="fas fa-arrow-left"></i>    Kembali
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-striped" id="example2">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Murid</th>
                                <th>Kelas</th>
                                <th>Jenis Kelamin</th>
                                <th>NISN</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($arsip->isEmpty())
                                <tr>
                                    <td colspan="6" class="text-center"><strong>Tidak ada data murid pada kelas {{ $kelas->nama_kelas }} tahun ajaran {{ $kelas->tahunAjaran->kode_ta }}</strong></td>
                                </tr>
                            @else
                                @foreach($arsip as $index => $dataArsip)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $dataArsip->murids->nama_murid }}</td>
                                            <td>{{ $kelas->nama_kelas }}</td>
                                            <td>{{ $dataArsip->murids->jenis_kelamin }}</td>
                                            <td>{{ $dataArsip->murids->nisn }}</td>
                                            <td>
                                                <a href="{{ route('murids.detail', [
                                                    'id_murid' => $dataArsip->murids->id_murid, 
                                                    'id_ta' => $dataArsip->id_ta, 
                                                    'id_kelas' => $dataArsip->id_kelas]) }}" class="btn btn-primary"> <i class="fas fa-eye"></i> Detail Nilai</a>
                                            </td>
                                        </tr>
                                @endforeach
                            @endif
                        </tbody>
                        
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
