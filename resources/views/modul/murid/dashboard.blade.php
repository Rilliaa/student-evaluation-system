@extends('adminlte::page')
@section('title', 'Dashbaord Murid')
@section('content_header')
<h1 class="m-0" style="color: #333;" >Selamat Datang di Dashboard Murid!</h1>
@stop
@section('content')
@php
        $prevDay = ''; 
        $rowIndex = 1; 
        $found = false;

@endphp

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body d-flex justify-content-between">
                <div style="background-color: #f0f4f8; padding: 20px; border-radius: 10px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);">
                    <p class="mr-auto" style="font-size: 20px; color: #333; width: 1300px; text-align: justify;" >
                        Hi, <strong style="color: #ff9e2a;">{{ Auth::user()->nama_murid }}</strong>! Di sistem ini, kamu dapat memantau perkembangan akademik dan non-akademikmu. 
                    </p>
                </div>
            </div>

            <div class="table table-responsive table-bordered mt-5" >
            @if ($jam->isEmpty())
                    <p>Data Jam Tidak Ada atau Belum Dibuat</p>
            @else
                <table class="table table-hover ml-auto mr-auto">
                         <thead>
                            <tr>
                                <th colspan="7" style="text-align: center; ">Tabel Jadwal Pelajaran Kelas , <span class="label label-lg label-light-danger label-inline" style="color: #27c8c0;background-color: #c9f7f5; border-radius: 5px; padding: 3px 8px; text-align: center;">
                                        {{ $kelas->nama_kelas}}
                                    </span> 
                                </th>
                                
                            </tr>
                            <tr >
                                <th style="text-align: center; vertical-align: middle;">No</th>
                                <th style="text-align: center; vertical-align: middle;">Hari</th>
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
                                    <tr id="row_{{ $loop->parent->iteration }}_{{ $loop->iteration }}">
                                        @if ($loop->first)
                                            <td rowspan="{{ $jamList->count() }}"  style="text-align :center">{{ $rowIndex }}</td>
                                            <td rowspan="{{ $jamList->count() }}"  style="text-align :center">{{ $hari }}</td>
                                            @php $rowIndex++; @endphp
                                        @endif
                                        <td  style="text-align :center">{{ $data->jam_ke }}</td>
                                        <td>{{ $data->jam_mulai }} - {{ $data->jam_selesai }}</td>
                                        <td>{{ $data->keterangan ?: '-' }}</td>
                                        <td>
                                            @php 
                                                $foundMapel = false; 
                                            @endphp
                                            @if ($data->jadwals->isNotEmpty())
                                                @foreach ($data->jadwals as $jadwal)
                                                    @if ($jadwal->id_kelas == $kelas->id_kelas)
                                                        {{ $jadwal->mapels->nama_mapel }}<br>
                                                        @php 
                                                            $foundMapel = true; 
                                                        @endphp
                                                    @endif
                                                @endforeach
                                                @if (!$foundMapel)
                                                    <span class="label label-lg label-light-danger label-inline" style="color: #f64e60;background-color: #ffe2e5; border-radius: 5px; padding: 3px 8px; text-align: center;">Belum Ditentukan</span>
                                                @endif
                                            @else      
                                                <span class="label label-lg label-light-danger label-inline" style="color: #f64e60;background-color: #ffe2e5; border-radius: 5px; padding: 3px 8px; text-align: center;">Belum Ditentukan</span>
                                            @endif
                                        </td>
                                        <td>
                                            @php 
                                                $foundGuru = false; 
                                            @endphp
                                            @if ($data->jadwals->isNotEmpty())
                                                @foreach ($data->jadwals as $jadwal)
                                                    @if ($jadwal->id_kelas == $kelas->id_kelas)
                                                        {{ $jadwal->mapels->gurus->nama_guru }}<br>
                                                        @php 
                                                            $foundGuru = true; 
                                                        @endphp
                                                    @endif
                                                @endforeach
                                                @if (!$foundGuru)
                                                    <span class="label label-lg label-light-danger label-inline" style="color: #f64e60;background-color: #ffe2e5; border-radius: 5px; padding: 3px 8px; text-align: center;">Belum Ditentukan</span>
                                                @endif
                                            @else      
                                                <span class="label label-lg label-light-danger label-inline" style="color: #f64e60;background-color: #ffe2e5; border-radius: 5px; padding: 3px 8px; text-align: center;">Belum Ditentukan</span>
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
    </div>
</div>
@endsection