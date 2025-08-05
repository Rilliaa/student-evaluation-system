@extends('adminlte::page')
@section('title', 'Halaman Guru | Murid Saya')
@section('content_header')
<h1>Halaman Murid Saya | Kelas {{$kelas->nama_kelas}}</h1>
@stop
@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="mb-3 mt-3">
                    <a href="{{ route('modul.guru.kelas-saya',$guru->id_guru)}}" class="btn btn-primary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
                <div class="table table-responsive" id="table-content">
                    <table class="table table-hover table-bordered mt-5" id="table" style="border-width: medium">
                        <thead style="font-weight: bold">
                            <tr style="text-align: center">
                                <td style="width: 5%">No</td>
                                <td style="width: 40%">Nama Murid</td>
                                <td style="width: 20%">Kelas</td>
                                <td style="width: 20%">NISN</td>
                                <td style="width: 15%">Aksi</td>
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
                                        <td style="text-align: center">{{ $kelas->nama_kelas }}</td>
                                        <td>{{ $dataArsip->murids->nisn }}</td>
                                        <td style="text-align: center">
                                            <a href="{{ route('modul.kelola.nilai', [
                                            'id_murid' => $dataArsip->murids->id_murid, 
                                            'id_kelas' => $dataArsip->id_kelas,
                                            'id_guru' => $guru->id_guru 
                                            ]) }}" class="btn btn-primary">
                                            <i class="fas fa-chart-bar"></i> Kelola Nilai  
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