@extends('adminlte::page')

@section('title', 'Detail Pelanggaran Murid')

@section('content_header')
    <h3 class="m-0 text-dark">Halaman Pelanggaran Murid | <strong class="btn btn-warning">{{ $murid->nama_murid }}</strong></h3>
@stop

@section('content')
{{-- Halaman ini diatur oleh method modulpelanggaran pada MuridController --}}
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table width="100%" >
                        <tbody>
                            <tr>
                                <td>Nama</td>
                                <td>: {{ $murid->nama_murid }}</td>
                                <td>Wali Kelas</td>
                                <td>: {{ $murid->kelas->guru->nama_guru }}</td>
                            </tr>
                            <tr class="">
                                <td>NISN</td>
                                <td>: {{ $murid->nisn }}</td>
                                <td>Wali Murid</td>
                                <td>: 
                                    @if(isset($murid->ortus) && $murid->ortus->isNotEmpty())
                                        {{ $murid->ortus->first()->nama_ortu }}
                                    @else
                                        <i> -</i>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>Jumlah Pelanggaran</td>
                                <td>: {{ $pelanggaranSiswa->count() }}</td>
                                <td>Kontak Wali Murid</td>
                                <td>: 
                                    @if(isset($murid->ortus) && $murid->ortus->isNotEmpty())
                                        0{{ $murid->ortus->first()->no_hp }}
                                    @else
                                        <i> -</i>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <table class="table table-hover table-bordered table-stripped" id="example2">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama Pelanggaran</th>
                            <th scope="col">Lokasi Pelanggaran</th>
                            <th scope="col">Tanggal Pelanggaran</th>
                            <th scope="col">Poin Pelanggaran</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($pelanggaranSiswa->isNotEmpty())
                            @php $totalPoin = 0; @endphp
                            @foreach($pelanggaranSiswa as $data)
                                @php $totalPoin += $data->pelanggaran->poin; @endphp
                                <tr id="row_{{ $loop->iteration }}">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $data->pelanggaran->nama_pelanggaran }}</td>
                                    <td>
                                        @if($data->lokasi_pelanggaran)
                                        {{ $data->lokasi_pelanggaran }}
                                        @else
                                        <span class="label label-lg label-light-danger label-inline" 
                                        style="color: #f64e60;background-color: #ffe2e5; border-radius: 5px; padding: 3px 8px; text-align: center;">
                                        Belum Ditentukan
                                    </span>
                                    @endif
                                </td>
                                
                                <td>{{ \Carbon\Carbon::parse($data->tanggal_pelanggaran)->format('d-m-y') }}</td>
                                <td>{{ $data->pelanggaran->poin }}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="4" style="text-align: right;"><strong>Total Poin:</strong></td>
                                <td >
                                        <span class="label label-lg label-light-danger label-inline" 
                                            style="color: #f64e60;background-color: #ffe2e5; border-radius: 5px; padding: 3px 8px;">
                                            {{ $totalPoin}}
                                        </span>
                                </td>
                            </tr>
                        @else 
                            <tr>
                                <td colspan="5" style="text-align: center">
                                <strong>   Tidak Ada Data Pelanggaran Murid Terkait</strong> 
                                </td>
                            </tr>
                        @endif
                        </tbody>
                </table>
            </div>
        </div>
    </div>
    {{$pelanggaranSiswa->links()}}
</div>
@endsection