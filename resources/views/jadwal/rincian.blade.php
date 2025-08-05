@extends('adminlte::page')
@section('title', 'Rincian Jadwal')
@section('content_header')

    <h1 class="m-0 text-dark">Jadwal Pelajaran | <span style="color: #ff9e2a; font-weight:bold">Kelola Jadwal Pelajaran</span></h1>
    <div class="d-flex justify-content-between mt-2">
        <div>
            <h3 class="d-inline-block mt-3">Kelas, <span style="color: #ff9e2a;">{{$kelas->nama_kelas}}</span></h3>
        </div>
        <div>
            <h3 class="d-inline-block mt-3">Kode Tahun Ajaran: <button class="btn btn-primary">{{$kelas->tahunAjaran->kode_ta}}</button></h3>
        </div>
    </div>
@stop
{{-- halaman ini di atur pada JadwalController/show --}}
@section('content')


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" defer></script>
<meta name="csrf-token" content="{{ csrf_token() }}">

<style>

</style>


@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@php
        $prevDay = ''; 
        $rowIndex = 1; 
        $found = false;  
        $sortedMapels = $mapels->sortBy('nama_mapel'); 
    @endphp

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="mb-3">
                    <a href="{{ route('jadwalPelajarans.index') }}" class="btn btn-primary">
                    <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>

                @if ($jam->isEmpty())
                    <p>Data Jam Tidak Ada atau Belum Dibuat</p>
                @else
                    <table class="table table-hover table-bordered table-stripped" id="example2">
                        <thead>
                            <tr>
                                <th colspan="8" style="text-align: center;">Tabel Jam Pelajaran</th>
                            </tr>
                            <tr>
                                <th style="text-align: center; vertical-align: middle;">No</th>
                                <th style="text-align: center; vertical-align: middle;">Hari</th>
                                <th style="text-align: center;">Jam Ke</th>
                                <th style="text-align: center;">Waktu</th>
                                <th style="text-align: center;">Keterangan</th>
                                <th style="text-align: center;">Mapel</th>
                                <th style="text-align: center;">Guru Pengampu</th>
                                <th style="text-align: center; vertical-align: middle;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jam as $hari => $jamList)
                                @foreach ($jamList as $index => $data)
                                    <tr id="row_{{ $loop->parent->iteration }}_{{ $loop->iteration }}">
                                        @if ($loop->first)
                                            <td rowspan="{{ $jamList->count() }}">{{ $rowIndex }}</td>
                                            <td rowspan="{{ $jamList->count() }}">{{ $hari }}</td>
                                            @php $rowIndex++; @endphp
                                        @endif
                                        <td>{{ $data->jam_ke }}</td>
                                        <td>{{ $data->jam_mulai }} - {{ $data->jam_selesai }}</td>
                                        <td>{{ $data->keterangan ?: '-' }}</td>
                                        <td>
                                            @php 
                                                $foundMapel = false; 
                                            @endphp
                                            @if ($data->jadwals->isNotEmpty())
                                                @foreach ($data->jadwals as $jadwal)
                                                    @if ($jadwal->id_kelas == $kelas->id_kelas)
                                                        {{ $jadwal->mapels->nama_mapel }}<br>
                                                        @php 
                                                            $foundMapel = true; 
                                                        @endphp
                                                    @endif
                                                @endforeach
                                                @if (!$foundMapel)
                                                    <span class="label label-lg label-light-danger label-inline" style="color: #f64e60;background-color: #ffe2e5; border-radius: 5px; padding: 3px 8px; text-align: center;">Belum Ditentukan</span>
                                                @endif
                                            @else      
                                                <span class="label label-lg label-light-danger label-inline" style="color: #f64e60;background-color: #ffe2e5; border-radius: 5px; padding: 3px 8px; text-align: center;">Belum Ditentukan</span>
                                            @endif
                                        </td>
                                        <td>
                                            @php 
                                                $foundGuru = false; 
                                            @endphp
                                            @if ($data->jadwals->isNotEmpty())
                                                @foreach ($data->jadwals as $jadwal)
                                                    @if ($jadwal->id_kelas == $kelas->id_kelas)
                                                        {{ $jadwal->mapels->gurus->nama_guru }}<br>
                                                        @php 
                                                            $foundGuru = true; 
                                                        @endphp
                                                    @endif
                                                @endforeach
                                                @if (!$foundGuru)
                                                    <span class="label label-lg label-light-danger label-inline" style="color: #f64e60;background-color: #ffe2e5; border-radius: 5px; padding: 3px 8px; text-align: center;">Belum Ditentukan</span>
                                                @endif
                                            @else      
                                                <span class="label label-lg label-light-danger label-inline" style="color: #f64e60;background-color: #ffe2e5; border-radius: 5px; padding: 3px 8px; text-align: center;">Belum Ditentukan</span>
                                            @endif
                                        </td>
                                        <td style="text-align:center; vertical-align:middle;">
                                            @php 
                                                $foundAksi = false;
                                            @endphp
                                            @if ($data->jadwals->isNotEmpty())
                                                @foreach ($data->jadwals as $jadwal)
                                                    @if ($jadwal->id_kelas == $kelas->id_kelas)
                                                        <button id="editMapelButton" type="button" class="btn btn-success btn-sm" 
                                                        data-toggle="modal"
                                                        data-target="#EditModal"
                                                        data-id_jadwal="{{ $jadwal->id_jadwal }}" 
                                                        data-hari="{{ $data->hari }}" 
                                                        data-jam_ke="{{ $data->jam_ke }}" 
                                                        data-id_jam="{{ $data->id_jam }}" 
                                                        data-row="{{ $loop->iteration }}">
                                                            <i class="fas fa-edit"></i> Edit Mapel
                                                        </button>
                                                        <form action="{{ route('jadwal.destroy', $jadwal->id_jadwal) }}" method="POST" style="display: inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                                <i class="fas fa-trash"></i> Hapus Mapel
                                                            </button>
                                                        </form>
                                                        @php
                                                            $foundAksi = true;
                                                        @endphp
                                                    @endif
                                                @endforeach
                                            @endif
                                            @if (!$foundAksi)
                                                <button id="tambahMapelButton" 
                                                    type="button" 
                                                    class="btn btn-primary btn-sm" 
                                                    data-toggle="modal" 
                                                    data-target="#myModal" 
                                                    data-hari="{{ $data->hari }}" 
                                                    data-jam_ke="{{ $data->jam_ke }}" 
                                                    data-id_jam="{{ $data->id_jam }}" 
                                                    data-row="{{ $loop->iteration }}">
                                                            <i class="fa fa-plus"></i> Tambah Mapel
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</div>



{{-- Modal Tambah Jadwal --}}
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="myModalLabel"><strong>Tambah  Jadwal</strong></h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="tambah-jadwal-form">
                    <input type="hidden" id="id_ta_modal" value="{{$kelas->id_ta}}">
                    <div class="form-group">
                        <label for="nama_kelas">Nama Kelas:</label> 
                        <input type="text" class="form-control" id="nama_kelas" name="nama_kelas" value="{{ $kelas->nama_kelas }}" readonly style="text-align: left">
                        <input type="hidden" id="id_kelas" name="id_kelas" value="{{ $kelas->id_kelas }}">
                    </div>  
                    <div class="form-group">
                        <label for="nama_kelas">Hari:</label>
                        <input type="text" class="form-control" id="hari_modal" name="hari_modal" value="" readonly>
                    </div>  
                    <div class="form-group">
                        <label for="nama_kelas">Jam Ke:</label>
                        <input type="text" class="form-control" id="jam_ke_modal" name="jam_ke_modal" value="" readonly>
                        <input type="hidden" id="id_jam_modal" name="id_jam_modal" value="">
                    </div>         
                    <div class="form-group">
                        <label for="id_mapel">Pilih Mapel:</label> 
                        <select class="form-control" id="id_mapels" name="id_mapels">
                            <option value=""></option>
                        </select>
                        <input type="hidden" class="form-control" id="id_mapel" name="id_mapel">
                    </div>    
                    <div class="form-group">            
                        <label for="id_guru">Pilih Pengampu:</label>
                        <select class="form-control" id="id_guru" name="id_guru">
                            <option value="">Pilih Guru</option>
                        </select>
                    </div>
                </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveChangesBtn"data-dismiss="modal">Save Mapel</button>
            </div>
        </div>
    </div>
</div>

{{-- modal untuk edit --}}
<div class="modal fade" id="EditModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="editModalLabel"><strong>Edit Jadwal</strong></h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="id_jadwal_edit" name="id_jadwal_edit">
                <input type="hidden" id="id_ta_edit" value="{{$kelas->id_ta}}">
                <form id="edit-mapel-form">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="nama_kelas">Nama Kelas:</label> 
                        <input type="text" class="form-control" id="nama_kelas" name="nama_kelas" value="{{ $kelas->nama_kelas }}" readonly style="text-align: left">
                        <input type="hidden" id="id_kelas" name="id_kelas" value="{{ $kelas->id_kelas }}">
                    </div>  
                    <div class="form-group">
                        <label for="nama_kelas">Hari:</label>
                        <input type="text" class="form-control" id="hari_modal_edit" name="hari_modal" value="" readonly>
                    </div>  
                    <div class="form-group">
                        <label for="nama_kelas">Jam Ke:</label>
                        <input type="text" class="form-control" id="jam_ke_modal_edit" name="jam_ke_modal" value="" readonly>
                        <input type="hidden" id="id_jam_modal_edit" name="id_jam_modal_edit" value="">
                    </div>         
                    <div class="form-group">
                        <label for="id_mapel">Pilih Mapel:</label> 
                        <select class="form-control" id="id_mapel_edit" name="id_mapels">
                            <option value=""></option>
                        </select>
                        <input type="hidden" class="form-control" id="edit_id_mapel" name="id_mapel">
                    </div>    

                    <div class="form-group">
                        <label for="id_guru_edit">Pilih Pengampu:</label>
                        <select class="form-control" id="id_guru_edit" name="id_guru_edit">
                            <option value="">Pilih Guru</option>
                        </select>
                    </div>
                    
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="editChangesBtn" data-dismiss="modal">Save Mapel</button>
            </div>
        </div>
    </div>
</div>

@endsection
@section('js')

<script>
    // jquery untuk mengisi id_jam pada modal tambah yang di hidden kan
$('body').on('click', '#tambahMapelButton', function() {
    var id_jam = $(this).data('id_jam');
    var hariModal = $(this).data('hari');
    var jamKeModal = $(this).data('jam_ke');
    document.getElementById("id_jam_modal").value = id_jam;
    document.getElementById("hari_modal").value = hariModal;
    document.getElementById("jam_ke_modal").value = jamKeModal;
    console.log('tambah id jam: ' + id_jam);
});
$('body').on('click', '#editMapelButton', function() {
    var id_jadwal_pelajaran = $(this).data('id_jadwal');
    var id_jam = $(this).data('id_jam');
    var hariModal = $(this).data('hari');
    var jamKeModal = $(this).data('jam_ke');
    document.getElementById("id_jadwal_edit").value = id_jadwal_pelajaran;
    document.getElementById("id_jam_modal_edit").value = id_jam;
    document.getElementById("hari_modal_edit").value = hariModal;
    document.getElementById("jam_ke_modal_edit").value = jamKeModal;
    console.log("Id Jadwal = ", id_jadwal_pelajaran);
    console.log('edit id jam: ' + id_jam);
});

var id_jadwal_pelajaran = $(this).data('id_jadwal');
document.getElementById("id_jadwal_edit").value = id_jadwal_pelajaran;

</script>

<script>
    // scirpt untuk  menambahkan data ke database
   $.ajaxSetup({
    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
});

// Ajax Untuk Tambah JADWAL --START
$(document).ready(function () {

    $('#myModal').on('shown.bs.modal', function () {
        $('#id_mapel').focus();
    });
    $('#myModal').on('hidden.bs.modal', function () {
        $(this).find('form').trigger('reset');
    });
    $('#saveChangesBtn').click(function () { 
        var id_mapel = $('#id_mapel').val();
        var id_guru = $('#id_guru').val();
        var id_kelas = $('#id_kelas').val();
        var id_jam = $('#id_jam_modal').val();
        var id_ta = $('#id_ta_modal').val();

        if (id_mapel !== '' && id_guru !== '' && id_kelas !== '') {
            $.ajax({
                type: 'POST',
                url: "{{ route('jadwal.store') }}",
                data: {
                    id_ta: id_ta,
                    id_mapel: id_mapel,
                    id_guru: id_guru,
                    id_jam: id_jam,
                    id_kelas: id_kelas,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    console.log('Data berhasil disimpan:', response);
                   // Menampilkan notifikasi dengan delay
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Jadwal Berhasil Ditambahkan',
                            text: response.message,
                            timer: 3000,  // Waktu delay 3 detik sebelum notifikasi ditutup
                            // showConfirmButton: false,  // Tidak ada tombol konfirmasi
                        }).then(() => {
                            location.reload();  // Reload halaman setelah notifikasi selesai
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Jadwal Bentrok',
                            text: response.message,
                            timer: 3000,  // Waktu delay 3 detik
                            // showConfirmButton: false,  // Tidak ada tombol konfirmasi
                        }).then(() => {
                            location.reload();  // Reload halaman setelah notifikasi selesai
                        });
                    }
                },
                error: function (xhr, status, error) {
                    var errorMessage = xhr.status + ': ' + xhr.statusText;
                    console.log('Error:', errorMessage);
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan',
                        text: 'Gagal menyimpan jadwal. Coba lagi.',
                    });
                    $('#myModal').modal('hide');
                }
            });
        } else {
            console.log('Silakan pilih mapel, guru, dan kelas terlebih dahulu.');
        }
    });

});
// Ajax Untuk Tambah JADWAL --end



// script untuk mengupdate --Start 
$('#editChangesBtn').click(function () { 
    var idMapel = $('#id_mapel_edit').val();
    var idGuru = $('#id_guru_edit').val();
    var idKelas = $('#id_kelas').val();
    var idJam = $('#id_jam_modal_edit').val();
    var idJadwal = $('#id_jadwal_edit').val();
    var id_ta = $('#id_ta_edit').val();

    if (idMapel !== '' && idGuru !== '' && idKelas !== '') {
        $.ajax({
            type: 'POST',
            url: "{{ route('jadwal.update', ':id_jadwal') }}".replace(':id_jadwal', idJadwal),
            data: {
                id_ta: id_ta,
                id_mapel: idMapel,
                id_guru: idGuru,
                id_kelas: idKelas,
                id_jam: idJam,
                _method: 'PUT',
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                console.log('Data berhasil diperbarui:', response);

                // Menampilkan notifikasi sesuai dengan response dari server
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Jadwal Berhasil Diperbarui',
                        text: response.message,
                        timer: 3000, // Delay sebelum notifikasi hilang
                        // showConfirmButton: false, // Tanpa tombol konfirmasi
                    }).then(() => {
                        location.reload(); // Reload halaman setelah notifikasi
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Jadwal Bentrok',
                        text: response.message,
                        timer: 3000, // Delay sebelum notifikasi hilang
                        // showConfirmButton: false, // Tanpa tombol konfirmasi
                    });
                }
            },
            error: function (xhr, status, error) {
                var errorMessage = xhr.status + ': ' + xhr.statusText;
                console.log('Error:', errorMessage);
                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi Kesalahan',
                    text: 'Gagal memperbarui jadwal. Coba lagi.',
                    timer: 3000,
                    showConfirmButton: false,
                });
            }
        });
    } else {
        console.log('Silakan pilih mapel, guru, dan kelas terlebih dahulu.');
    }
});

// script untuk mengupdate --End 




  // Jquery untuk select2 nama mapel modal Tmabah --START
  $(document).ready(function(){
        $('#myModal').on('shown.bs.modal', function () {
            $('#id_mapels').select2({
                placeholder: 'Pilih Mapel',
                dropdownParent: $('#myModal'), //untuk dropdown form list pada select2, ini spesial karna biasanya tidak menggunakan ini
                ajax: {
                    url: '{{ route("mapels.search") }}',
                    dataType: 'json',
                    delay: 250,
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    id: item.id_mapel,
                                    text: item.nama_mapel,
                                };
                            })
                        };
                    },
                    success: function(data){
                        console.log('Sukses mengambil data mapel :', data);
                  
                    },
                    cache: true
                },
            });
        });
            $('#id_mapels').on('change', function() {
        let selectedValue = $(this).val();
        $('#id_mapel').val(selectedValue);
    });
    });
    // Jquery untuk select2 nama mapel modal Tambah --END

     // Jquery untuk select2 nama mapel modal Edit --START
  $(document).ready(function(){
        $('#EditModal').on('shown.bs.modal', function () {
            console.log("Modal Edit MuNCUL");


            $('#id_mapel_edit').select2({
                placeholder: 'Pilih Mapel',
                dropdownParent: $('#EditModal'), //untuk dropdown form list pada select2, ini spesial karna biasanya tidak menggunakan ini
                ajax: {
                    url: '{{ route("mapels.search") }}',
                    dataType: 'json',
                    delay: 250,
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    id: item.id_mapel,
                                    text: item.nama_mapel,
                                };
                            })
                        };
                    },
                    success: function(data){
                        console.log('Sukses mengambil data mapel :', data);
                  
                    },
                    cache: true
                },
            });
        });
             $('#id_mapel_edit').on('change', function() {
        let selectedValue = $(this).val();
        $('#edit_id_mapel').val(selectedValue);
    });
    });
    // Jquery untuk select2 nama mapel modal Edit --END





</script>


<script>
    // jqruey dropdown on change
$(function () {
    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
    });
    $('#id_mapels').on('change', function () {
        let id_mapel = $(this).val();
        console.log(id_mapel);
                
        $.ajax({
            type : 'POST',
            url : "{{ route('getguru')}}",
            data: {id_mapel: id_mapel},
            cache: false,
            success : function (msg) {
                $('#id_guru').html(msg);
                console.log('Sukses : ',msg);
            },
            error : function(data) {
                console.log('error: ',data);
            },
        })
    });
    $('#id_mapel_edit').on('change', function () {
        let id_mapel_edit = $(this).val();
        console.log("ID yang mau di edit",id_mapel_edit);
                
        $.ajax({
            type : 'POST',
            url : "{{ route('getguruedit')}}",
            data: {id_mapel_edit: id_mapel_edit},
            cache: false,
            success : function (msg) {
                $('#id_guru_edit').html(msg);
                console.log('Sukses : ',msg);
            },
            error : function(data) {
                console.log('error: ',data);
            },
        })
    });
});
</script>

@stop

