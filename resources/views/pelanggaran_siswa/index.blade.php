@extends('adminlte::page')
@section('title', 'Daftar Pelanggaran Siswa')
@section('content_header')
    <h1 class="m-0 text-dark">Halaman Daftar Pelanggaran Murid</h1>
@stop
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" defer></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
{{-- Halaman ini diatur di method index PelanggaranSiswaController --}}
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <button id="tambahPelanggaranButton" type="button" class="btn btn-primary btn-sm mb-3" data-toggle="modal" data-target="#modalTambahPelanggaran">
                    <i class="fas fa-plus"></i>Tambah Siswa Melanggar
                </button>
                <table class="table table-hover table-bordered table-stripped" id="example2">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama Murid</th>
                            <th scope="col">Kelas</th>
                            <th scope="col">Kuantitas Pelanggaran</th>
                            <th scope="col" style="text-align: center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($pelanggaranSiswa->isEmpty())
                            <td colspan="5" style="text-align: center"><strong> Tidak ada Siswa Melanggar</strong></td>
                        @else
                            @foreach($pelanggaranSiswa as $data)
                            <tr id="row_{{ $loop->iteration }}">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->murid->nama_murid }}</td>
                                <td>{{ $data->murid->kelas->nama_kelas }}</td>
                                <td>{{ $data->pelanggaran_count }}</td>
                                <td style="text-align:center;vertical-align:middle;">
                                    <a class="btn btn-primary b" id="detailPelanggaran" href="{{ route('pelanggaran-siswa.detail', $data->murid->id_murid) }}">
                                        <i class="fa fa-search-plus"></i> Detail
                                    </a>
                                </td>            
                            </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {{$pelanggaranSiswa->links()}}
</div>
@endsection

{{-- Modal Tambah data --}}
<div class="modal fade" id="modalTambahPelanggaran" role="dialog" aria-labelledby="modalTambahPelanggaranTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTambahPelanggaranTitle">Tambah Data Pelanggaran Murid</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formTambahPelanggaran">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nama_siswa_modal">Nama Siswa:</label>
                        <select class="form-control" id="nama_siswa_modal" name="nama_siswa_modal" required>
                        </select>
                        <input type="hidden" class="form-control" id="id_siswa_modal" name="id_siswa">
                    </div>      
                    <div class="form-group">
                        <label for="id_kelas">Kelas:</label>
                        <input type="text" class="form-control" id="nama_kelas_modal" name="nama_kelas_modal" readonly>
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
                    <button type="submit" class="btn btn-primary">Tambah</button>
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
        $('#modalTambahPelanggaran').on('shown.bs.modal', function () {
            $('#nama_pelanggaran').focus(); // Fokuskan input "nama_pelanggaran"
        });
        $('#modalTambahPelanggaran').on('hidden.bs.modal', function () {
            $(this).find('form').trigger('reset'); // Mereset formulir di dalam modal
        });
        $('#formTambahPelanggaran').submit(function(event) {
            event.preventDefault(); // Mencegah form dari pengiriman default

            // Mengambil nilai dari input fields
            let id_pelanggaran = $('#id_pelanggaran').val();
            let id_murid = $('#id_siswa_modal').val();
            let lokasi_pelanggaran = $('#lokasi_pelanggaran').val();
            let tanggal_pelanggaran = $('#tanggal_pelanggaran').val();

            // Mengirim data ke server melalui AJAX
            $.ajax({
                url: '{{ route("pelanggaran-siswa.send") }}', // Ganti dengan URL yang sesuai untuk menyimpan data pelanggaran
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    id_pelanggaran: id_pelanggaran,
                    id_murid: id_murid,
                    lokasi_pelanggaran: lokasi_pelanggaran,
                    tanggal_pelanggaran: tanggal_pelanggaran,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {

                    $('#modalTambahPelanggaran').modal('hide'); // Menutup modal setelah data berhasil disimpan
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

    // Jquery untuk select2 murid --START
    $(document).ready(function(){
        $('#modalTambahPelanggaran').on('shown.bs.modal', function () {
            $('#nama_siswa_modal').select2({
                placeholder: 'Pilih Nama Siswa',
                ajax: {
                    url: '{{ route("murids.search") }}',
                    dataType: 'json',
                    delay: 250,
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    id: item.id_murid,
                                    text: item.nama_murid,
                                };
                            })
                        };
                    },
                    success: function(data){
                        console.log('Sukses mengambil data Murid :', data);
                    },
                    cache: true
                },
            });
        });
    });
    // Jquery untuk select2 murid --END

    // Jquery untuk select2 pelanggaran --START
    $(document).ready(function(){
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
                    success: function(data){
                        console.log('Sukses mengambil data Pelanggaran :', data);
                    },
                    cache: true
                },
            });
        });
    });

    $('#nama_pelanggaran_modal').on('change', function () {
        let id_pelanggaran = $(this).val();
        document.getElementById('id_pelanggaran').value = id_pelanggaran;
    });
    // Jquery untuk select2 pelanggaran --END

    // Jquery untuk mengisi nilai id_murid pada select2 modal tambah --START
    $('#nama_siswa_modal').on('change', function () {
        let id_siswa = $(this).val();
        document.getElementById('id_siswa_modal').value = id_siswa;
    });
    // Jquery untuk mengisi nilai id_murid pada select2 --END

    // Jquery untuk dropdown kelas onchange based on murids --START
    $('#nama_siswa_modal').on('change', function () {
        let id_nama = document.getElementById('id_siswa_modal').value;
        console.log("Id Murid yang dipilih adalah :", id_nama);
        $.ajax({
            type : 'POST',
            url : "{{ route('getkelas') }}",
            data: {id_nama: id_nama},
            cache: false,
            success : function (msg) {
                console.log('Sukses Besar : ', msg);
                $('#nama_kelas_modal').val(msg);
            },
            error : function(data) {
                console.log('error: ', data);
            },
        });
    });
    // Jquery untuk dropdown kelas onchange based on murids --END
</script>
@endsection
