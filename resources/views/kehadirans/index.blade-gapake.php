@extends('adminlte::page')
@section('title', 'Kehadiran')
@section('content_header')
    <h1 class="m-0 text-dark">Daftar Kehadiran Siswa</h1>
@stop
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                    <div class="card-body">
                        <a href="{{route('kehadirans.create')}}" class="btn btn-primary mb-2">
                            Tambah
                        </a>
                        <table class="table table-hover table-bordered table-stripped" id="example2">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Nama Murid</th>
                                    <th scope="col">Kelas</th>
                                    <th scope="col">Tanggal</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Keterangan</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($kehadirans as $kehadiran)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $kehadiran->murids->nama_murid }}</td>
                                        <td>{{ $kehadiran->murids->id_kelas }}</td>
                                        <td>{{ $kehadiran->tanggal }}</td>
                                        <td>{{ $kehadiran->status }}</td>
                                        <td>{{ $kehadiran->keterangan }}</td>
                                        <td>
                                            <a href="{{route('kehadirans.edit', $kehadiran)}}" class="btn btn-primary btn-xs">
                                                <i class="fas fa-edit"></i>       Edit
                                            </a>
                                            <a href="{{route('kehadirans.destroy', $kehadiran)}}" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')" class="btn btn-danger btn-xs">
                                                <i class="fas fa-trash"></i>    Delete
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
