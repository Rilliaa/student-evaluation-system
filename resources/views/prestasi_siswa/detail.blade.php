@extends('adminlte::page')

@section('title', 'Detail Prestasi Murid')

@section('content_header')
    <h3 class="m-0 text-dark">Rincian Murid Berprestasi |
         Detail Murid, <span style="font-weight: bold; color :#ff9e2a;">{{ $murid->nama_murid }}</span></h3>
@stop

@section('content')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">

    {{-- Halaman ini diatur di method detail di PrestasiSiswaController --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3">
                        <a href="{{ route('prestasi-siswa.index') }}" class="btn btn-primary">
                        <i class="fas fa-arrow-left"></i>   Kembali 
                        </a>
                    </div>
                    <div class="table-responsive">
                        {{-- <table class="table table-borderless"> --}}
                        <table width="100%">
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
                                            {{ $murid->ortus->first()->no_hp }}
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
                            <tr style="text-align: center">
                                <th scope="col">No</th>
                                <th scope="col">Nama Prestasi</th>
                                <th scope="col">Poin Prestasi</th>
                                <th scope="col">Tanggal Prestasi</th>
                                <th scope="col">Lokasi Prestasi</th>
                                <th scope="col" >Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $totalPoin = 0; @endphp
                            @foreach($prestasiSiswa as $data)
                            @php $totalPoin += $data->prestasi->poin; @endphp
                                <tr id="row_{{ $loop->iteration }}">
                                    <td style="text-align: center">{{ $loop->iteration }}</td>
                                    <td>{{ $data->prestasi->nama_prestasi }}</td>
                                    <td>{{ $data->prestasi->poin }}</td>
                                    {{-- <td>{{ $data->tanggal_prestasi }}</td> --}}
                                    <td>{{ \Carbon\Carbon::parse($data->tanggal_prestasi)->format('d-m-y') }}</td>
                                    <td>{{ $data->lokasi_prestasi }}</td>
                                    <td style="text-align:center;vertical-align:middle;">
                                        <button class="btn btn-success btn-sm editButton" 
                                                data-id_prestasi="{{ $data->id_prestasi }}" 
                                                data-nama_prestasi="{{ $data->prestasi->nama_prestasi }}" 
                                                data-id_prestasisiswa="{{ $data->id }}" 
                                                data-tanggal_prestasi="{{ $data->tanggal_prestasi }}" 
                                                data-lokasi_prestasi="{{ $data->lokasi_prestasi }}" 
                                                data-toggle="modal" 
                                                data-target="#modalTambahPrestasi" id="editBtn">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                        <form action="{{ route('prestasi-siswa.destroy', $data) }}" method="POST" style="display: inline;">
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
                                <td colspan="5" style="text-align: right;"><strong>Total Poin Prestasi:</strong></td>
                                <td style="text-align: center;">
                                    <strong @if($totalPoin > 800) style="color : red" @endif>{{ $totalPoin }}</strong>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        {{$prestasiSiswa->links()}}
    </div>

    {{-- Modal EDIT --}}
    <div class="modal fade" id="modalTambahPrestasi" role="dialog" aria-labelledby="modalTambahPrestasiTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahPrestasiTitle">Edit Data Prestasi Murid</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="formEditPrestasi" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <input type="hidden" id="id_prestasi-siswa" name="edit_id_prestasisiswa">
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
                            <label for="prestasi">Prestasi:</label>
                            <select name="nama_prestasi_modal" id="nama_prestasi_modal" class="form-control" required>
                            </select>
                            <input type="hidden" class="form-control" id="id_prestasi" name="id_prestasi">
                        </div>
                        <div class="form-group">
                            <label for="lokasi_prestasi">Lokasi Prestasi:</label>
                            <input type="text" class="form-control" id="lokasi_prestasi" name="lokasi_prestasi">
                        </div>
                        <div class="form-group">
                            <label for="tanggal_prestasi">Tanggal Prestasi:</label>
                            <input type="date" class="form-control" id="tanggal_prestasi" name="tanggal_prestasi">
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
    // Untuk Select2 --Start
    $(document).ready(function() {
        $('#modalTambahPrestasi').on('shown.bs.modal', function () {
            $('#nama_prestasi_modal').select2({
            placeholder: 'Pilih Jenis Prestasi',
            ajax: {
                url: '{{ route("prestasi.search") }}',
                dataType: 'json',
                delay: 250,
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                id: item.id_prestasi,
                                text: item.nama_prestasi,
                            };
                        })
                    };
                },
                cache: true
            },
        });
    });
    // Untuk Select2 --End

    $('#nama_prestasi_modal').on('change', function () {
        let id_prestasi = $(this).val();
        $('#id_prestasi').val(id_prestasi);
    });

    $('.editButton').click(function() {
        let id_prestasi_siswa = $(this).data('id_prestasisiswa');
        $('#id_prestasi-siswa').val(id_prestasi_siswa);
    });
    
 $('body').on('click', '#editBtn', function() {
    var lokasi_prestasi = $(this).data('lokasi_prestasi');
    var tanggal_prestasi = $(this).data('tanggal_prestasi');
    document.getElementById("lokasi_prestasi").value = lokasi_prestasi;
    document.getElementById("tanggal_prestasi").value = tanggal_prestasi;
    console.log('Data = ' + lokasi_prestasi + tanggal_prestasi);
});


    // Ajax Update --Start
    $('#formEditPrestasi').submit(function(event) {
        event.preventDefault();
        let id_prestasi_siswa = $('#id_prestasi-siswa').val();
        let id_prestasi = $('#id_prestasi').val();
        let lokasi_prestasi = $('#lokasi_prestasi').val();
        let tanggal_prestasi = $('#tanggal_prestasi').val();

        $.ajax({
            url: '{{ route("prestasi-siswa.update", ":id") }}'.replace(':id', id_prestasi_siswa),
            method: 'PUT',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                id_prestasi: id_prestasi,
                lokasi_prestasi: lokasi_prestasi,
                tanggal_prestasi: tanggal_prestasi,
                _method: 'PUT',
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                $('#modalTambahPrestasi').modal('hide');
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
// Ajax Update --End
</script>
@endsection
