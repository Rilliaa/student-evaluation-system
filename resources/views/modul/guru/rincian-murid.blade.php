@extends('adminlte::page')
@section('title', 'Halaman Guru | Rincian Murid')

@section('content_header')
<div class="container-fluid">
    <table>
        <tr>
            <td><h3>Detail Murid</h3></td>
            <td>
                <h3>: <span class="detail-murid-highlight">{{ $murid->nama_murid }}</span></h3>
            </td>
        </tr>
        <tr>
            <td><h3>Kelas</h3></td>
            <td>
                <h3>: <button class="btn btn-success">{{ $kelas->nama_kelas }}</button></h3>
            </td>
        </tr>
    </table>
    <div class="d-flex justify-content-between mt-2">
        <div></div>
        <div>
            <h3 class="d-inline-block">Kode Tahun Ajaran: 
                <button class="btn btn-primary">{{ $kelas->tahunAjaran->kode_ta }}</button>
            </h3>
        </div>
    </div>
</div>
@stop

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <a href="{{ route('modul.guru.detail', ['id_kelas' => $kelas->id_kelas, 'id_ta' => $ta->id_ta, 'id_guru' => $guru->id_guru]) }}" class="btn btn-primary mb-3 mt-3">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>

                <div class="table-responsive">
                    <!-- Data Murid -->
                    <table class="table table-bordered">
                        <thead class="table-light text-center">
                            <tr>
                                <th colspan="4">Data Murid</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Nama</td>
                                <td>: {{ $murid->nama_murid }}</td>
                                <td>Wali Kelas Saat Ini</td>
                                <td>: {{ $murid->kelas->guru->nama_guru }}</td>
                            </tr>
                            <tr>
                                <td>NISN</td>
                                <td>: {{ $murid->nisn }}</td>
                                <td>Jenis Kelamin</td>
                                <td>: {{ $murid->jenis_kelamin }}</td>
                            </tr>
                            <tr>
                                <td>Tahun Ajaran Murid Saat Ini</td>
                                <td>: {{ $murid->tahunAjaran->kode_ta }}</td>
                                <td>Tanggal Lahir Murid</td>
                                <td>: {{ $murid->tanggal_lahir }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- Data Wali Murid -->
                    <table class="table table-bordered mt-3">
                        <thead class="table-light text-center">
                            <tr>
                                <th colspan="4">Data Wali Murid</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $wali = $ortu->isNotEmpty() ? $ortu->first() : null;
                            @endphp
                            <tr>
                                <td>Nama Wali</td>
                                <td>: {{ $wali ? $wali->nama_ortu : 'Belum Ditentukan' }}</td>
                                <td>Tanggal Lahir Wali</td>
                                <td>: {{ $wali ? $wali->tanggal_lahir : 'Belum Ditentukan' }}</td>
                            </tr>
                            <tr>
                                <td>Jenis Kelamin</td>
                                <td>: {{ $wali ? $wali->jenis_kelamin : 'Belum Ditentukan' }}</td>
                                <td>Alamat</td>
                                <td>: {{ $wali ? $wali->alamat : 'Belum Ditentukan' }}</td>
                            </tr>
                            <tr>
                                <td>Email Wali</td>
                                <td>: {{ $wali ? $wali->email : 'Belum Ditentukan' }}</td>
                                <td>Nomor Hp</td>
                                <td>: {{ $wali ? '0' . $wali->no_hp : 'Belum Ditentukan' }}</td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
