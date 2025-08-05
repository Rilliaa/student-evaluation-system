@extends('adminlte::page')
@section('title', 'Daftar Prestasi Siswa')
@section('content_header')
    <h1 class="m-0 text-dark">Halaman Daftar Murid Berprestasi</h1>
@stop
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" defer></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
{{-- Halaman ini diatur di method index PrestasiSiswaController --}}
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <button id="tambahPrestasiButton" type="button" class="btn btn-primary btn-sm mb-3" data-toggle="modal" data-target="#modalTambahPrestasi">
                    <i class="fas fa-plus"></i> Tambah Data
                </button>
                <table class="table table-hover table-bordered table-stripped" id="example2">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama Murid</th>
                            <th scope="col">Kelas</th>
                            <th scope="col">Jumlah Prestasi</th>
                            <th scope="col" style="text-align: center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($prestasiSiswa->isEmpty())
                            <td colspan="5" style="text-align: center"><strong> Tidak Ada Siswa Berprestasi</strong></td>
                        @else     
                        @foreach($prestasiSiswa as $data)
                        <tr id="row_{{ $loop->iteration }}">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $data->murid->nama_murid }}</td>
                            <td>{{ $data->murid->kelas->nama_kelas }}</td>
                            <td>{{ $data->prestasi_count }}</td>
                            <td style="text-align:center;vertical-align:middle;">
                                <a class="btn btn-primary " id="detailPrestasi" href="{{ route('prestasi-siswa.detail', $data->murid->id_murid) }}">
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
    {{$prestasiSiswa->links()}}
</div>
@endsection

{{-- Modal Tambah data --}}
<div class="modal fade" id="modalTambahPrestasi" role="dialog" aria-labelledby="modalTambahPrestasiTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTambahPrestasiTitle">Tambah Data Murid Berprestasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formTambahPrestasi">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nama_siswa_modal">Nama Murid:</label>
                        <select class="form-control" id="nama_siswa_modal" name="nama_siswa_modal" required>
                            <option value=""></option>
                        </select>
                        <input type="hidden" class="form-control" id="id_siswa_modal" name="id_siswa">
                    </div>      
                    <div class="form-group">
                        <label for="id_kelas">Kelas:</label>
                        <input type="text" class="form-control" id="nama_kelas_modal" name="nama_kelas_modal" readonly>
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
                        <input type="date" class="form-control" id="tanggal_prestasi" name="tanggal_prestasi" required>
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
        $('#modalTambahPrestasi').on('shown.bs.modal', function () {
            $('#nama_prestasi').focus(); // Fokuskan input "nama_prestasi"
        });
        $('#modalTambahPrestasi').on('hidden.bs.modal', function () {
            $(this).find('form').trigger('reset'); // Mereset formulir di dalam modal
        });
        $('#formTambahPrestasi').submit(function(event) {
            event.preventDefault(); // Mencegah form dari pengiriman default

            // Mengambil nilai dari input fields
            let id_prestasi = $('#id_prestasi').val();
            let id_murid = $('#id_siswa_modal').val();
            let lokasi_prestasi = $('#lokasi_prestasi').val();
            let tanggal_prestasi = $('#tanggal_prestasi').val();

            // Mengirim data ke server melalui AJAX
            $.ajax({
                url: '{{ route("prestasi-siswa.send") }}', // Ganti dengan URL yang sesuai untuk menyimpan data prestasi
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    id_prestasi: id_prestasi,
                    id_murid: id_murid,
                    lokasi_prestasi: lokasi_prestasi,
                    tanggal_prestasi: tanggal_prestasi,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {

                    $('#modalTambahPrestasi').modal('hide'); // Menutup modal setelah data berhasil disimpan
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
        $('#modalTambahPrestasi').on('shown.bs.modal', function () {
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

    // Jquery untuk select2 prestasi --START
    $(document).ready(function(){
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
                    success: function(data){
                        console.log('Sukses mengambil data Prestasi :', data);
                    },
                    cache: true
                },
            });
        });
    });

    $('#nama_prestasi_modal').on('change', function () {
        let id_prestasi = $(this).val();
        document.getElementById('id_prestasi').value = id_prestasi;
    });
    // Jquery untuk select2 prestasi --END

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
            url : "{{ route('getkelasprestasi') }}",
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
