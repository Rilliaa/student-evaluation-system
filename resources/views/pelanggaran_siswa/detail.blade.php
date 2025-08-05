@extends('adminlte::page')

@section('title', 'Detail Pelanggaran Murid')

@section('content_header')
    <h3 class="m-0 text-dark">Rincian Pelanggaran Murid | Detail Murid <span style="font-weight: bold; color :#ff9e2a;">{{ $murid->nama_murid }}</span></h3>
@stop

@section('content')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">

    {{-- Halaman ini di atur di method detail di PelanggaranSiswaController --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3">
                        <a href="{{ route('pelanggaran_siswa.index') }}" class="btn btn-primary">
                        <i class="fas fa-arrow-left"></i>    Kembali
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table width="100%">
                        {{-- <table class="table table-borderless"> --}}
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
                                <th scope="col">Poin Pelanggaran</th>
                                <th scope="col">Lokasi Pelanggaran</th>
                                <th scope="col">Tanggal Pelanggaran</th>
                                <th scope="col" style="text-align: center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $totalPoin = 0; @endphp
                            @foreach($pelanggaranSiswa as $data)
                                @php $totalPoin += $data->pelanggaran->poin; @endphp
                                <tr id="row_{{ $loop->iteration }}">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $data->pelanggaran->nama_pelanggaran }}</td>
                                    <td>{{ $data->pelanggaran->poin }}</td>
                                    <td>{{ $data->lokasi_pelanggaran }}</td>
                                    {{-- <td>{{ $data->tanggal_pelanggaran }}</td> --}}
                                    <td>{{ \Carbon\Carbon::parse($data->tanggal_pelanggaran)->format('d-m-y') }}</td>
                                    <td style="text-align:center;vertical-align:middle;">
                                        <button class="btn btn-success btn-sm editButton" 
                                                data-id_pelanggaran="{{ $data->id_pelanggaran }}" 
                                                data-nama_pelanggaran="{{ $data->pelanggaran->nama_pelanggaran }}" 
                                                data-id_pelanggaransiswa="{{ $data->id }}" 
                                                data-lokasi_pelanggaran="{{ $data->lokasi_pelanggaran }}" 
                                                data-tanggal_pelanggaran="{{ $data->tanggal_pelanggaran }}" 
                                                data-toggle="modal" 
                                                data-target="#modalTambahPelanggaran" id="editBtn">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                        <form action="{{ route('pelanggaran-siswa.destroy', $data) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" id="btnHapus" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="5" style="text-align: right;"><strong>Total Poin:</strong></td>
                                <td style="text-align: center;">
                                    <strong @if($totalPoin > 800) style="color: red" @endif>{{ $totalPoin }}</strong>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        {{$pelanggaranSiswa->links()}}
    </div>

    {{-- Modal EDIT --}}
    <div class="modal fade" id="modalTambahPelanggaran" role="dialog" aria-labelledby="modalTambahPelanggaranTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahPelanggaranTitle">Edit Data Pelanggaran Murid</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="formEditPelanggaran" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <input type="hidden" id="id_pelanggaran-siswa" name="edit_id_pelanggaransiswa">
                        <div class="form-group">
                            <label for="nama_siswa_modal">Nama Siswa:</label>
                            <input type="text" readonly class="form-control" id="nama_siswa_modal" name="nama_siswa" value="{{ $murid->nama_murid }}">
                            <input type="hidden" class="form-control" id="id_siswa_modal" name="id_siswa" value="{{ $murid->id_murid }}">
                        </div>      
                        <div class="form-group">
                            <label for="id_kelas">Kelas:</label>
                            <input type="text" class="form-control" id="nama_kelas_modal" name="nama_kelas_modal" value="{{ $murid->kelas->nama_kelas }}" readonly>
                        </div>                 
                        <div class="form-group">
                            <label for="poin_pelanggaran">Pelanggaran:</label>
                            <select name="nama_pelanggaran_modal" id="nama_pelanggaran_modal" class="form-control" required>
                            </select>
                            <input type="hidden" class="form-control" id="id_pelanggaran" name="id_pelanggaran">
                        </div>
                        <div class="form-group">
                            <label for="lokasi_pelanggaran">Lokasi Pelanggaran:</label>
                            <input type="text" class="form-control" id="lokasi_pelanggaran" name="lokasi_pelanggaran">
                        </div>
                        <div class="form-group">
                            <label for="tanggal_pelanggaran">Tanggal Pelanggaran:</label>
                            <input type="date" class="form-control" id="tanggal_pelanggaran" name="tanggal_pelanggaran" required>
                        </div> 
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('js')
<script>
// Jquery untuk mengisi value lokasi dan tanggal pada modal --Start
$('body').on('click', '#editBtn', function() {
    var lokasi_pelanggaran = $(this).data('lokasi_pelanggaran');
    var tanggal_pelanggaran = $(this).data('tanggal_pelanggaran');
    document.getElementById("lokasi_pelanggaran").value = lokasi_pelanggaran;
    document.getElementById("tanggal_pelanggaran").value = tanggal_pelanggaran;
    console.log('Data = ' + lokasi_pelanggaran + tanggal_pelanggaran);
});
// Jquery untuk mengisi value lokasi dan tanggal pada modal --End


    // Select2 untuk pelanggaran --Start
    $(document).ready(function() {
        $('#modalTambahPelanggaran').on('shown.bs.modal', function () {
            $('#nama_pelanggaran_modal').select2({
                placeholder: 'Pilih Jenis Pelanggaran',
            ajax: {
                url: '{{ route("pelanggaran.search") }}',
                dataType: 'json',
                delay: 250,
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                id: item.id_pelanggaran,
                                text: item.nama_pelanggaran,
                            };
                        })
                    };
                },
                cache: true
            },
        });
    });
    // Select2 untuk pelanggaran --Emd

    $('#nama_pelanggaran_modal').on('change', function () {
        let id_pelanggaran = $(this).val();
        $('#id_pelanggaran').val(id_pelanggaran);
    });

    $('.editButton').click(function() {
        let id_pelanggaran_siswa = $(this).data('id_pelanggaransiswa');
        $('#id_pelanggaran-siswa').val(id_pelanggaran_siswa);
    });


    // Ajax Untuk Update --Start
    $('#formEditPelanggaran').submit(function(event) {
        event.preventDefault();
        let id_pelanggaran_siswa = $('#id_pelanggaran-siswa').val();
        let id_pelanggaran = $('#id_pelanggaran').val();
        let lokasi_pelanggaran = $('#lokasi_pelanggaran').val();
        let tanggal_pelanggaran = $('#tanggal_pelanggaran').val();
        
        $.ajax({
            url: '{{ route("pelanggaran-siswa.update", ":id") }}'.replace(':id', id_pelanggaran_siswa),
            method: 'PUT',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                id_pelanggaran: id_pelanggaran,
                lokasi_pelanggaran: lokasi_pelanggaran,
                tanggal_pelanggaran: tanggal_pelanggaran,
                _method: 'PUT',
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                $('#modalTambahPelanggaran').modal('hide');
                Swal.fire({
                            icon: 'success',
                            title: 'Data Berhasil Di Update',
                            text: response.message,
                            timer: 3000,  
                            // showConfirmButton: false, 
                        }).then(() => {
                            location.reload();  
                        });
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });
});
// Ajax Untuk Update --End
</script>
@endsection