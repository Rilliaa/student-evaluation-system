@extends('adminlte::page')
@section('title', 'List Murid')
@section('content_header')
    <h1 class="m-0 text-dark">Daftar Seluruh Murid</h1>
@stop
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <a href="{{ route('murids.create') }}" class="btn btn-primary mb-2">
                     <i class="fas fa-plus"></i>   Tambah
                    </a>
                    <input type="text" id="search" class="form-control mb-4 mt-4" placeholder="Cari Nama Murid...">
                    <table class="table table-hover table-bordered table-stripped" id="example2">
                        <thead>
                            <tr style="text-align: center">
                                <th >No</th>
                                <th >Nama Murid</th>
                                <th >Tanggal Lahir</th>
                                <th >NISN</th>
                                <th >Jenis Kelamin</th>
                                <th >Kelas</th>
                                <th >Tahun Ajaran</th>
                                <th >Role</th>
                                <th >Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="murid-table-body">
                            @foreach ($murids as $murid)
                                <tr>
                                    <td style="text-align: center">{{ $loop->iteration }}</td>
                                    <td>{{ $murid->nama_murid }}</td>
                                    <td>{{ $murid->tanggal_lahir }}</td>
                                    <td>{{ $murid->nisn }}</td>
                                    <td>{{ $murid->jenis_kelamin }}</td>
                                    <td>{{ $murid->kelas->nama_kelas }}</td>
                                    <td>{{ $murid->tahunAjaran->kode_ta }}</td>
                                    <td>{{ $murid->roles->nama_roles }}</td>
                                    <td style="text-align: center">
                                        <a href="{{ route('edit.murid', $murid->id_murid) }}" class="btn btn-primary ">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <a href="{{ route('murids.grafik', $murid->id_murid) }}" class="btn btn-info ">
                                            <i class="fas fa-chart-bar"></i> Grafik
                                        </a>
                                        <form action="{{ route('murids.destroy', $murid->id_murid) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
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
        {{ $murids->links() }}
    </div>
@endsection

@section('js')
 <script>
document.addEventListener('DOMContentLoaded', function() {
    // Live search event listener
    document.getElementById('search').addEventListener('keyup', function() {
        let query = this.value;

        fetch(`{{ route('murid.livesearch') }}?q=${query}`)
            .then(response => response.json())
            .then(data => {
                let tbody = document.getElementById('murid-table-body');
                tbody.innerHTML = '';

                if(data.murids.length === 0){
                    let row = `<tr>
                        <td colspan="9" class="text-center"> <strong> Data Murid tidak ada atau belum dibuat</strong> </td>
                    </tr>`;
                    tbody.innerHTML = row;
                }
                else{
                    data.murids.forEach((murid, index) => {

                        // var ids = murid.nama_murid;
                        // var url = "{{ route('murids.grafik',':id_murid') }}".replace(':id_murid',ids);
                        let row = `<tr>
                            <td>${index + 1}</td>
                            <td>${murid.nama_murid}</td>
                            <td>${murid.tanggal_lahir}</td>
                            <td>${murid.nisn}</td>
                            <td>${murid.jenis_kelamin}</td>
                            <td>${murid.kelas.nama_kelas}</td>
                            <td>${murid.tahun_ajaran.kode_ta}</td>
                            <td>${murid.roles.nama_roles}</td>
                            <td>
                                <a href="murids/edit/${murid.id_murid}" class="btn btn-primary">
                                   <i class="fas fa-edit"></i> Edit
                                </a>
                                <a href="murids/grafik/${murid.id_murid}" class="btn btn-info ">
                                            <i class="fas fa-chart-bar"></i> Grafik
                                </a>
                                <form action="murids/destroy/${murid.id_murid}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
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
        
        // <a href="{{ route('edit.murid', ':id') }}".replace(':id', murid.id_murid) class="btn btn-primary btn-xs edit-button">
        // Event listener for dynamically created edit buttons
    document.addEventListener('click', function(event) {
        if (event.target.closest('.edit-button')) {
            event.preventDefault(); // Prevent the default behavior of the link
            const href = event.target.closest('.edit-button').getAttribute('href');
            window.location.href = href; // Redirect to the edit page
        }
    });
});


    </script>
@stop
