@extends('adminlte::page')
@section('title', 'Daftar Pelanggaran')
@section('content_header')
    <h1 class="m-0 text-dark">Daftar Pelanggaran</h1>
@stop
@section('content')
{{-- Halaman ini di atur pada PelanggaranController method index --}}
<meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="row">
        <div class="col-12">
            <div class="card">
                    <div class="card-body">
                        <button id="tambahPelanggaranButton" type="button" class="btn btn-primary btn-sm mb-3" data-toggle="modal" data-target="#modalTambahPelanggaran">
                            <i class="fas fa-plus"></i>     Tambah Pelanggaran
                        </button>
                        <table class="table table-hover table-bordered table-stripped" id="example2">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Nama Pelanggaran</th>
                                    <th scope="col">Poin Pelanggaran</th>
                                    <th scope="col" style="text-align: center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pelanggaran as $data)
                                    <tr id="row_{{ $loop->iteration }}">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{$data->nama_pelanggaran}}</td>
                                        <td>{{$data->poin}}</td>
                                        <td style="text-align:center;vertical-align:middle;">
                                            <button class="btn btn-success btn-sm editButton" id="EditPelanggaran" onclick="openEditModal({{ $data->id_pelanggaran }})" data-id_pelanggaran="{{ $data->id_pelanggaran }}" data-nama_pelanggaran="{{ $data->nama_pelanggaran }}" data-poin="{{ $data->poin }}" data-toggle="modal" data-target="#modalEditPelanggaran">
                                                <i class="fas fa-edit"></i> Edit
                                             </button>
                                            <form action="{{ route('pelanggaran.destroy', $data->id_pelanggaran) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" id="btnHapus" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                    <i class="fas fa-trash"></i>   Hapus
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
        {{$pelanggaran->links()}}
    </div>
    {{-- Modal Tambah data --}}
    <div class="modal fade" id="modalTambahPelanggaran" tabindex="-1" role="dialog" aria-labelledby="modalTambahPelanggaranTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTambahPelanggaranTitle">Tambah Data Pelanggaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formTambahPelanggaran">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nama_pelanggaran">Nama Pelanggaran:</label>
                        <input type="text" class="form-control" id="nama_pelanggaran" name="nama_pelanggaran" required placeholder="Masukan Nama Pelanggaran">
                    </div>
                    <div class="form-group">
                        <label for="poin_pelanggaran">Poin Pelanggaran:</label>
                        <input type="number" class="form-control" id="poin_pelanggaran" name="poin_pelanggaran" required placeholder="Masukan Poin Pelanggaran">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- Modal edit data --}}
<div class="modal fade" id="modalEditPelanggaran" tabindex="-1" role="dialog" aria-labelledby="modalEditPelanggaranTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditPelanggaranTitle">Edit Data Pelanggaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formEditPelanggaran" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_nama_pelanggaran">Nama Pelanggaran:</label>
                        <input type="text" class="form-control" id="edit_nama_pelanggaran" name="edit_nama_pelanggaran" required placeholder="Masukan Nama Pelanggaran">
                        <input type="hidden" name="id_pelanggaran" id="edit_id_pelanggaran">
                    </div>
                    <div class="form-group">
                        <label for="edit_poin_pelanggaran">Poin Pelanggaran:</label>
                        <input type="number" class="form-control" id="edit_poin_pelanggaran" name="edit_poin_pelanggaran" required placeholder="Masukan Poin Pelanggaran">
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
@endsection

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
        $('#modalTambahPelanggaran').on('shown.bs.modal', function () {
            $('#nama_pelanggaran').focus(); // Fokuskan input "nama_pelanggaran"
        });

        // Fungsi untuk menutup modal tambah
        $('#modalTambahPelanggaran').on('hidden.bs.modal', function () {
            $(this).find('form').trigger('reset'); // Mereset formulir di dalam modal
        });

        // Fungsi untuk menyimpan data pelanggaran baru
        $('#formTambahPelanggaran').submit(function(event) {
            event.preventDefault(); // Mencegah form dari pengiriman default

            // Mengambil nilai dari input fields
            var namaPelanggaran = $('#nama_pelanggaran').val();
            var poinPelanggaran = $('#poin_pelanggaran').val();

            // Mengirim data ke server melalui AJAX
            $.ajax({
                url: '{{ route("pelanggaran.store") }}', // Ganti dengan URL yang sesuai untuk menyimpan data pelanggaran
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')                                                                                                                                                                                                
                },
                data: {
                    nama_pelanggaran: namaPelanggaran,
                    poin: poinPelanggaran,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $('#modalTambahPelanggaran').modal('hide');
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
// $('body').on('click', '#EditPelanggaran', function() {
//     var nama_pelanggaran = $(this).data('nama_pelanggaran');
//     var poin = $(this).data('poin');
//     var id_pelanggaran = $(this).data('id_pelanggaran');
//     document.getElementById("edit_nama_pelanggaran").value = nama_pelanggaran;
//     document.getElementById("edit_poin_pelanggaran").value = poin;
//     document.getElementById("edit_id_pelanggaran").value = id_pelanggaran;
// });
$('body').on('click', '#EditPelanggaran', function() {
    var id_pelanggaran = $(this).data('id_pelanggaran');
    var nama_pelanggaran = $(this).data('nama_pelanggaran');
    var poin = $(this).data('poin');
    $('#edit_id_pelanggaran').val(id_pelanggaran);
    $('#edit_nama_pelanggaran').val(nama_pelanggaran);
    $('#edit_poin_pelanggaran').val(poin);
});

// $('body').on('click', '#btnHapus', function() {
//     alert('Anda akan Menghapus')
// });
// Jquery untuk mengisi form pada modal edit --end


// Jquery untuk Edit --Start
$('#formEditPelanggaran').submit(function(event) {
    event.preventDefault(); // Mencegah form dari pengiriman default

    var id = $('#edit_id_pelanggaran').val();
    var nama_pelanggaran = $('#edit_nama_pelanggaran').val();
    var poin_pelanggaran = $('#edit_poin_pelanggaran').val();
    console.log('Id Pelanggaran yang dipilih adalah : ',id)
    $.ajax({
        url: '{{ route("pelanggaran.update", ":id")}}'.replace(':id', id),
        method : 'PUT',
        headers: 
        {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')                                                                                                                                                                                                
        },
        data: 
        {
            nama_pelanggaran: nama_pelanggaran,
            poin: poin_pelanggaran,
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            $('#modalEditPelanggaran').modal('hide');
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
            // Tampilkan pesan error jika ada
        }
    });

});

    // Jquery untuk Edit --End

    function openEditModal(id_pelanggaran) {
        // Lakukan apa pun yang diperlukan saat modal edit dibuka, seperti mengatur nilai input
        console.log('Modal edit dibuka untuk pelanggaran dengan id: ' + id_pelanggaran);
    }
</script>
@stop

