@extends('adminlte::page')
@section('title', 'List Nilai Murid')
@section('content_header')
    <h1 class="m-0 text-dark">Daftar Nilai  Seluruh Murid</h1>
@stop
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                    <div class="card-body">  
                        {{-- <a href="{{route('nilais.create')}}" class="btn btn-primary mb-2">
                            Tambah
                        </a> --}}
                        <table class="table table-hover table-bordered table-stripped" id="example2">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Murid</th>
                                    <th>Tahun Ajaran </th>
                                    <th>Kelas</th>
                                    <th>Nama Mapel</th>
                                    <th>Nilai</th>
                                    {{-- <th>Aksi</th> --}}
              
                             
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($nilais as $nilai)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        @if ($nilai->murids)
                                        {{ $nilai->murids->nama_murid }}
                                        @endif
                                    </td>
                                    <td>{{ $nilai->murids->tahunAjaran->kode_ta }}</td>
                                    <td>
                                        {{ $nilai->murids->kelas->nama_kelas }}

                                    </td>
                                    
                                    <td>
                                        @if ($nilai->mapels)
                                            {{ $nilai->mapels->nama_mapel }}
                                        @endif
                                    </td>
                                    {{-- <td>{{ $nilai->mapels->nama_mapel }}</td> --}}
                                    <td>{{ $nilai->nilai }}</td>
                                    {{-- <td>
                                        <a href="{{route('nilais.edit', $nilai->id_nilai)}}" class="btn btn-primary btn-xs">
                                                Edit
                                        </a>
                                        <form action="{{ route('nilais.destroy', $nilai->id_nilai) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-xs" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Delete</button>
                                        </form>
                                    </td> --}}
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            {{$nilais->links()}}
        </div>
    @endsection
        
