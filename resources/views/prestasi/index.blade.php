@extends('adminlte::page')
@section('title', 'Daftar Prestasi')
@section('content_header')
    <h1 class="m-0 text-dark">Daftar Prestasi</h1>
@stop
@section('content')
{{-- Halaman ini diatur pada PrestasiController method index --}}
<meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="row">
        <div class="col-12">
            <div class="card">
                    <div class="card-body">
                        <button id="tambahPrestasiButton" type="button" class="btn btn-primary btn-sm mb-3" data-toggle="modal" data-target="#modalTambahPrestasi">
                            <i class="fas fa-plus"></i> Tambah Prestasi
                        </button>
                        <table class="table table-hover table-bordered table-stripped" id="example2">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Nama Prestasi</th>
                                    <th scope="col">Poin Prestasi</th>
                                    <th scope="col" style="text-align: center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($prestasi as $data)
                                    <tr id="row_{{ $loop->iteration }}">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{$data->nama_prestasi}}</td>
                                        <td>{{$data->poin}}</td>
                                        <td style="text-align:center;vertical-align:middle;">
                                            <button class="btn btn-success btn-sm editButton" id="EditPrestasi" onclick="openEditModal({{ $data->id_prestasi }})" data-id_prestasi="{{ $data->id_prestasi }}" data-nama_prestasi="{{ $data->nama_prestasi }}" data-poin="{{ $data->poin }}" data-toggle="modal" data-target="#modalEditPrestasi">
                                                <i class="fas fa-edit"></i> Edit
                                            </button>
                                            <form action="{{ route('prestasi.destroy', $data->id_prestasi) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" id="btnHapus" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
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
        </div>
        {{$prestasi->links()}}
    </div>
@endsection

{{-- Modal Tambah data --}}
<div class="modal fade" id="modalTambahPrestasi" tabindex="-1" role="dialog" aria-labelledby="modalTambahPrestasiTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTambahPrestasiTitle">Tambah Data Prestasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formTambahPrestasi">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nama_prestasi">Nama Prestasi:</label>
                        <input type="text" class="form-control" id="nama_prestasi" name="nama_prestasi" required placeholder="Masukan Nama Prestasi">
                    </div>
                    <div class="form-group">
                        <label for="poin_prestasi">Poin Prestasi:</label>
                        <input type="number" class="form-control" id="poin_prestasi" name="poin_prestasi" required placeholder="Masukan Poin Prestasi">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal edit data --}}
<div class="modal fade" id="modalEditPrestasi" tabindex="-1" role="dialog" aria-labelledby="modalEditPrestasiTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditPrestasiTitle">Edit Data Prestasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
              <form id="formEditPrestasi" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_nama_prestasi">Nama Prestasi:</label>
                        <input type="text" class="form-control" id="edit_nama_prestasi" name="edit_nama_prestasi" required placeholder="Masukan Nama Prestasi">
                        <input type="hidden" name="id_prestasi" id="edit_id_prestasi">
                    </div>
                    <div class="form-group">
                        <label for="edit_poin_prestasi">Poin Prestasi:</label>
                        <input type="number" class="form-control" id="edit_poin_prestasi" name="edit_poin_prestasi" required placeholder="Masukan Poin Prestasi">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@section('js')
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Jquery untuk Tambah --Start
    $(document).ready(function() {
        // Fungsi untuk menampilkan modal tambah
        $('#modalTambahPrestasi').on('shown.bs.modal', function () {
            $('#nama_prestasi').focus(); // Fokuskan input "nama_prestasi"
        });

        // Fungsi untuk menutup modal tambah
        $('#modalTambahPrestasi').on('hidden.bs.modal', function () {
            $(this).find('form').trigger('reset'); // Mereset formulir di dalam modal
        });

        // Fungsi untuk menyimpan data prestasi baru
        $('#formTambahPrestasi').submit(function(event) {
            event.preventDefault(); // Mencegah form dari pengiriman default

            // Mengambil nilai dari input fields
            var namaPrestasi = $('#nama_prestasi').val();
            var poinPrestasi = $('#poin_prestasi').val();

            // Mengirim data ke server melalui AJAX
            $.ajax({
                url: '{{ route("prestasi.store") }}', // Ganti dengan URL yang sesuai untuk menyimpan data prestasi
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    nama_prestasi: namaPrestasi,
                    poin: poinPrestasi,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $('#modalTambahPrestasi').modal('hide'); 
                    Swal.fire({
                            icon: 'success',
                            title: 'Data Berhasil Ditambahkan',
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
    // Jquery untuk Tambah --End

    // Jquery untuk mengisi form pada modal edit --start 
    $('body').on('click', '#EditPrestasi', function() {
        var id_prestasi = $(this).data('id_prestasi');
        var nama_prestasi = $(this).data('nama_prestasi');
        var poin = $(this).data('poin');
        $('#edit_id_prestasi').val(id_prestasi);
        $('#edit_nama_prestasi').val(nama_prestasi);
        $('#edit_poin_prestasi').val(poin);
    });

    // Jquery untuk Edit --Start
    $('#formEditPrestasi').submit(function(event) {
        event.preventDefault(); // Mencegah form dari pengiriman default

        var id = $('#edit_id_prestasi').val();
        var nama_prestasi = $('#edit_nama_prestasi').val();
        var poin_prestasi = $('#edit_poin_prestasi').val();
        console.log('Id Prestasi yang dipilih adalah : ',id)
        $.ajax({
            url: '{{route("prestasi.update", ":id")}}'.replace(':id', id),
            method : 'PUT',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                nama_prestasi: nama_prestasi,
                poin: poin_prestasi,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                $('#modalEditPrestasi').modal('hide');
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
    // Jquery untuk Edit --End

    function openEditModal(id_prestasi) {
        // Lakukan apa pun yang diperlukan saat modal edit dibuka, seperti mengatur nilai input
        console.log('Modal edit dibuka untuk prestasi dengan id: ' + id_prestasi);
    }
</script>
@stop
