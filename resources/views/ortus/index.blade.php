@extends('adminlte::page')
@section('title', 'List Wali Murid')
@section('content_header')
    <h1 class="m-0 text-dark">Daftar Wali Murid</h1>
@stop
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <a href="{{ route('ortus.create') }}" class="btn btn-primary mb-2">
                    <i class="fas fa-plus"></i>    Tambah Wali
                    </a>
                    <input type="text" id="search" class="form-control mb-4 mt-4" placeholder="Cari Nama Wali Murid...">
                    <table class="table table-hover table-bordered table-stripped" id="example2">
                        <thead>
                            <tr style="text-align: center">
                                <th>No</th>
                                <th>Nama Wali Murid</th>
                                <th>Alamat</th>
                                <th>No HP Wali</th>
                                <th>Role</th>
                                <th>Nama Anak</th>
                                <th>Kelas Anak</th>
                                <th >Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="ortu-table-body">
                            @foreach ($ortus as $key => $ortu)
                                <tr>
                                    <td style="text-align: center">{{ $loop->iteration }}</td>
                                    <td>{{ $ortu->nama_ortu }}</td>
                                    <td>{{ $ortu->alamat }}</td>
                                    <td>{{ $ortu->no_hp }}</td>                                  
                                    <td>{{ $ortu->roles->nama_roles }}</td>
                                    <td>{{ $ortu->murids->nama_murid }}</td>
                                    <td>{{ $ortu->murids->kelas->nama_kelas }}</td>
                                    <td style="text-align: center">
                                        <a href="{{ route('ortus.edit', $ortu) }}" class="btn btn-primary ">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <a href="{{ route ('ortus.show',$ortu->id_ortu)}}" class="btn btn-info ">
                                            <i class="fas fa-eye"></i> Detail
                                        </a>
                                        <form action="{{ route('ortus.destroy', $ortu) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger " onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                <i class="fas fa-trash"></i> Delete
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
        {{ $ortus->links() }}
    </div>
@endsection


@section('js')
    <script>
        document.getElementById('search').addEventListener('keyup', function() {
            let query = this.value;

            fetch(`{{ route('ortus.livesearch') }}?q=${query}`)
                .then(response => response.json())
                .then(data => {
                    let tbody = document.getElementById('ortu-table-body');
                    tbody.innerHTML = '';
                    
                    if (data.ortus.length === 0) {
                        let row = `<tr>
                            <td colspan="11" class="text-center"><strong>Data Wali Murid tidak ada atau belum dibuat</strong></td>
                        </tr>`;
                        tbody.innerHTML = row;
                    } else {
                        data.ortus.forEach((ortu, index) => {
                            let editUrl = `{{ route('ortus.edit', ':ortu') }}`.replace(':ortu', ortu.id_ortu);
                            let deleteUrl = `{{ route('ortus.destroy', ':ortu') }}`.replace(':ortu', ortu.id_ortu);
                            let detailUrl = `{{ route ('ortus.show',':ortu')}}`.replace(':ortu', ortu.id_ortu);


                            let row = `<tr>
                                <td>${index + 1}</td>
                                <td>${ortu.nama_ortu}</td>
                                <td>${ortu.alamat}</td>
                                <td>${ortu.no_hp}</td>
                                <td>${ortu.roles.nama_roles}</td>
                                <td>${ortu.murids.nama_murid}</td>
                                <td>${ortu.murids.kelas.nama_kelas}</td>
                                <td style="text-align: center">
                                    <a href="${editUrl}" class="btn btn-primary ">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <a href="${detailUrl}" class="btn btn-info ">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
                                    <form action="${deleteUrl}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger " onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
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
