@extends('adminlte::page')
@section('title', 'List Guru')
@section('content_header')
    <h1 class="m-0 text-dark">Halaman Daftar Guru</h1>
@stop
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <a href="{{ route('gurus.create') }}" class="btn btn-primary mb-2">
                      <i class="fas fa-plus"></i>  Tambah
                    </a>
                    <input type="text" id="search" class="form-control mb-4 mt-4" placeholder="Cari Nama Guru...">
                    <table class="table table-hover table-bordered table-stripped" id="example2">
                        <thead>
                            <tr style="text-align: center">
                                <th scope="col">No</th>
                                <th scope="col">Nama</th>
                                <th scope="col">NIP</th>
                                <th scope="col">Mapel Yang Di Ampu</th>
                                <th scope="col">Alamat</th>
                                <th scope="col">E-mail</th>
                                <th scope="col">Role</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="guru-table-body">
                            @foreach($gurus as $guru)
                                <tr>
                                    <td style="text-align: center">{{ $loop->iteration }}</td>
                                    <td>{{ $guru->nama_guru }}</td>
                                    <td>{{ $guru->nip }}</td>
                                    <td>
                                        @if($guru->mapels->isNotEmpty())
                                        <div class="dropdown">
                                            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Tekan Untuk Melihat 
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                @foreach($guru->mapels as $mapel)
                                                    <a class="dropdown-item" href="#">{{ $mapel->nama_mapel }}</a>
                                                @endforeach
                                            </div>
                                        </div>
                                        @else 
                                        <span class="label label-lg label-light-danger label-inline" 
                                            style="color: #f64e60;background-color: #ffe2e5; border-radius: 5px; padding: 3px 8px; text-align: center;">
                                            Belum Ditentukan
                                        </span>
                                        @endif
                                    </td>
                                    <td>{{ $guru->alamat }}</td>
                                    <td>{{ $guru->email }}</td>
                                    <td>{{ $guru->roles->nama_roles }}</td>
                                    <td style="text-align: center">
                                        <a href="{{ route('gurus.edit', $guru) }}" class="btn btn-primary ">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('gurus.destroy', $guru) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger " onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        {{ $gurus->links() }}
    </div>
@endsection

@section('js')
    <script>
        document.getElementById('search').addEventListener('keyup', function() {
            let query = this.value;

            fetch(`{{ route('guru.livesearch') }}?q=${query}`)
                .then(response => response.json())
                .then(data => {
                    let tbody = document.getElementById('guru-table-body');
                    tbody.innerHTML = '';
                    
                    if (data.gurus.length === 0) {
                        let row = `<tr>
                            <td colspan="8" class="text-center"><strong>Data guru tidak ada atau belum dibuat</strong></td>
                        </tr>`;
                        tbody.innerHTML = row;
                    } else {
                        data.gurus.forEach((guru, index) => {
                            let editUrl = `{{ route('gurus.edit', ':guru') }}`.replace(':guru', guru.id_guru);
                            let deleteUrl = `{{ route('gurus.destroy', ':guru') }}`.replace(':guru', guru.id_guru);

                            let row = `<tr>
                                <td>${index + 1}</td>
                                <td>${guru.nama_guru}</td>
                                <td>${guru.nip}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Tekan Untuk Melihat
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            ${guru.mapels.map(mapel => `<a class="dropdown-item" href="#">${mapel.nama_mapel}</a>`).join('')}
                                        </div>
                                    </div>
                                </td>
                                <td>${guru.alamat}</td>
                                <td>${guru.email}</td>
                                <td>${guru.roles.nama_roles}</td>
                                <td>
                                    <a href="${editUrl}" class="btn btn-primary btn-xs">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="${deleteUrl}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-xs" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>`;
                            tbody.innerHTML += row;
                        });
                    }
                });
        });
    </script>
@stop
