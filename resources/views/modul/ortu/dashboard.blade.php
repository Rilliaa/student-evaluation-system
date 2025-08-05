@extends('adminlte::page')
@section('title', 'Dashboard Wali Murid')
@section('content_header')
    <h1 class="m-0" style="color: #333;" >Selamat Datang di Dashboard Wali Murid!</h1>
@stop

@section('content')

@php
    $prevDay = ''; 
    $rowIndex = 1; 
    $found = false;
@endphp

<div class="row">
    <div class="card-body d-flex justify-content-between">
        <div style="background-color: #f0f4f8; padding: 20px; border-radius: 10px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);">
            <p class="mr-auto" style="font-size: 20px; color: #333; width: 1300px; text-align: justify;">
                Selamat datang, <strong style="color: #ff9e2a;">{{ Auth::user()->nama_ortu }}</strong>!  <br> <br>
                Anda adalah wali dari <strong style="color: #ff9e2a;">{{ $murid->nama_murid }}</strong>. 
                Kami berharap Anda merasa nyaman menggunakan sistem ini untuk memantau perkembangan <strong style="color: #ff9e2a;">{{ $murid->nama_murid }}</strong>.
            </p>
        </div>
    </div>

    <div class="col-md-12" onclick="window.location='{{ route('modul.murid.prestasi',$murid->id_murid) }}'" style="cursor: pointer;" >
        <div id="mainCard" class="card bg-success text-white shadow" style="height: 100px;">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div style="flex: 4;">
                    <p class="card-title mb-0" style="font-size: 1.5rem; font-weight: bold;">Prestasi Yang Diraih Anak :</p>
                </div>
                <div style="flex: 0; text-align: center;">
                    <p class="mb-0" style="font-size: 3rem; font-weight: bold;">{{ $prestasi_anak}}</p>
                </div>
                <i class="fas fa-trophy fa-3x" style="flex: 0.2; text-align: right;"></i>
            </div>
        </div>
    </div>
    
    <div class="col-md-12 mt-1 " onclick="window.location='{{ route('modul.murid.pelanggaran',$murid->id_murid) }}'" style="cursor: pointer;">
        <div id="mainCard" class="card bg-danger text-white shadow" style="height: 100px;" >
            <div class="card-body d-flex justify-content-between align-items-center">
                <div style="flex: 4;">
                    <p class="card-title mb-0" style="font-size: 1.5rem; font-weight: bold;">Pelanggaran Yang Dilakukan Anak:</p>
                </div>
                <div style="flex: 0; text-align: center;">
                    <p class="mb-0" style="font-size: 3rem; font-weight: bold;">{{ $pelanggaran_anak}}</p>
                </div>
                <i class="fas fa-exclamation-triangle fa-3x" style="flex: 0.2; text-align: right;"></i>
            </div>
        </div>
    </div>



    <div class="table table-responsive table-bordered mt-4">
        @if ($jam->isEmpty())
            <p style="color: #666;">Data jadwal belum tersedia untuk saat ini.</p>
        @else
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th colspan="7" style="text-align: center; background-color: #f9fafb; color: #333;">
                            Jadwal Pelajaran Kelas 
                            <span class="label label-lg label-light-danger label-inline" style="color: #27c8c0; background-color: #c9f7f5; border-radius: 5px; padding: 3px 8px; text-align: center;">
                                {{ $kelas->nama_kelas }}
                            </span> 
                        </th>
                    </tr>
                    <tr style="background-color: #f1f3f5; color: #555;">
                        <th style="text-align: center;">No</th>
                        <th style="text-align: center;">Hari</th>
                        <th style="text-align: center;">Jam Ke</th>
                        <th style="text-align: center;">Waktu</th>
                        <th style="text-align: center;">Keterangan</th>
                        <th style="text-align: center;">Mapel</th>
                        <th style="text-align: center;">Guru Pengampu</th>
                    </tr>
                </thead>
                <tbody id="tablebody">
                    @foreach ($jam as $hari => $jamList)
                        @foreach ($jamList as $index => $data)
                            <tr id="row_{{ $loop->parent->iteration }}_{{ $loop->iteration }}" style="background-color: #f9f9f9; color: #333;">
                                @if ($loop->first)
                                    <td rowspan="{{ $jamList->count() }}" style="text-align: center;">{{ $rowIndex }}</td>
                                    <td rowspan="{{ $jamList->count() }}" style="text-align: center;">{{ $hari }}</td>
                                    @php $rowIndex++; @endphp
                                @endif
                                <td style="text-align: center;">{{ $data->jam_ke }}</td>
                                <td>{{ $data->jam_mulai }} - {{ $data->jam_selesai }}</td>
                                <td>{{ $data->keterangan ?: '-' }}</td>
                                <td>
                                    @php $foundMapel = false; @endphp
                                    @if ($data->jadwals->isNotEmpty())
                                        @foreach ($data->jadwals as $jadwal)
                                            @if ($jadwal->id_kelas == $kelas->id_kelas)
                                                {{ $jadwal->mapels->nama_mapel }}<br>
                                                @php $foundMapel = true; @endphp
                                            @endif
                                        @endforeach
                                        @if (!$foundMapel)
                                            <span style="color: #f64e60; background-color: #ffe2e5; border-radius: 5px; padding: 3px 8px;">Belum Ditentukan</span>
                                        @endif
                                    @else
                                        <span style="color: #f64e60; background-color: #ffe2e5; border-radius: 5px; padding: 3px 8px;">Belum Ditentukan</span>
                                    @endif
                                </td>
                                <td>
                                    @php $foundGuru = false; @endphp
                                    @if ($data->jadwals->isNotEmpty())
                                        @foreach ($data->jadwals as $jadwal)
                                            @if ($jadwal->id_kelas == $kelas->id_kelas)
                                                {{ $jadwal->mapels->gurus->nama_guru }}<br>
                                                @php $foundGuru = true; @endphp
                                            @endif
                                        @endforeach
                                        @if (!$foundGuru)
                                            <span style="color: #f64e60; background-color: #ffe2e5; border-radius: 5px; padding: 3px 8px;">Belum Ditentukan</span>
                                        @endif
                                    @else
                                        <span style="color: #f64e60; background-color: #ffe2e5; border-radius: 5px; padding: 3px 8px;">Belum Ditentukan</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>

@endsection
