@extends('adminlte::page')

@section('title', 'Detail Murid| Daftar Murid')

@section('content_header')
    <h1 class="m-0 text-dark">Detail Murid | <span style="font-weight:bold; color: #ff9e2a;">Daftar Murid</span></h1>
    <div class="d-flex justify-content-between mt-2">
        <div>
            <h3 class="d-inline-block">Kelas: <button class="btn btn-warning">{{ $kelas->nama_kelas }}</button></h3>
        </div>
        <div>
            <h3 class="d-inline-block">Kode Tahun Ajaran: <button class="btn btn-primary">{{ $kelas->tahunAjaran->kode_ta }}</button></h3>
        </div>
    </div>
@stop

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <a href="{{ route('modul.guru.detail-murid',$guru->id_guru) }}" class="btn btn-primary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-striped" id="example2">
                        <thead>
                            <tr style="text-align: center">
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
                                            <td style="text-align: center">{{ $loop->iteration }}</td>
                                            <td>{{ $dataArsip->murids->nama_murid }}</td>
                                            <td>{{ $kelas->nama_kelas }}</td>
                                            <td>{{ $dataArsip->murids->jenis_kelamin }}</td>
                                            <td>{{ $dataArsip->murids->nisn }}</td>
                                            <td style="text-align: center">
                                                <a href="{{ route('modul.murids.detail', [
                                                'id_guru' => $guru->id_guru,
                                                'id_murid' => $dataArsip->murids->id_murid, 
                                                'id_ta' => $dataArsip->id_ta, 
                                                'id_kelas' => $dataArsip->id_kelas
                                                ]) }}" class="btn btn-primary">
                                                    <i class="fas fa-eye"></i> Detail Murid
                                                </a>
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
