@extends('adminlte::page')

@section('title', 'Wali Murid | Detail Prestasi Murid')

@section('content_header')
    <h3 class="m-0 text-dark">Halaman Prestasi Murid | <strong class="btn btn-success">{{ $murid->nama_murid }}</strong></h3>
@stop

@section('content')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">

    {{-- Halaman ini diatur di method modulprestasi di MuridController --}}
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
                                <tr>
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
                                    <td>Jumlah Prestasi</td>
                                    <td>: {{ $prestasiSiswa->count() }}</td>
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
                                <th scope="col">Nama Prestasi</th>
                                <th scope="col">Tanggal Prestasi</th>
                                <th scope="col">Lokasi Prestasi</th>
                                <th scope="col">Poin Prestasi</th>
                            </tr>
                        </thead>
                        <tbody>
                        @if($prestasiSiswa->isNotEmpty())
                            @php $totalPoin = 0; @endphp
                            @foreach($prestasiSiswa as $data)
                            @php $totalPoin += $data->prestasi->poin; @endphp
                                <tr id="row_{{ $loop->iteration }}">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $data->prestasi->nama_prestasi }}</td>
                                    {{-- <td>{{ $data->tanggal_prestasi }}</td> --}}
                                    <td>{{ \Carbon\Carbon::parse($data->tanggal_prestasi)->format('d-m-y') }}</td>
                                    <td>
                                        @if($data->lokasi_prestasi)
                                        {{ $data->lokasi_prestasi }}
                                        @else
                                        <span class="label label-lg label-light-danger label-inline" 
                                        style="color: #f64e60;background-color: #ffe2e5; border-radius: 5px; padding: 3px 8px; text-align: center;">
                                        Belum Ditentukan
                                    </span>
                                    @endif   
                                </td>
                                <td>{{ $data->prestasi->poin }}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="4" style="text-align: right;"><strong>Total Poin Prestasi:</strong></td>
                                <td >
                                         <span class="label label-lg label-light-danger label-inline" 
                                        style="color: #00a9a4;background-color: #c9f7f5; border-radius: 5px; padding: 3px 8px;">
                                        {{ $totalPoin }}
                                        </span>
                    
                                </td>
                            </tr>
                        @else 
                            <tr>
                                <td colspan="5" style="text-align: center">
                                   <strong>
                                    Tidak Ada Data Prestasi Murid Terkait
                                </strong>
                                </td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        {{$prestasiSiswa->links()}}
    </div>
@endsection