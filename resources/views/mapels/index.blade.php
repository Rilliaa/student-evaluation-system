@extends('adminlte::page')
@section('title', 'List Mapel')
@section('content_header')
<h1>Daftar Mata Pelajaran</h1>
@stop
@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" defer></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <button class="btn btn-primary mt-3 mb-3" data-target="#modalTambah" data-toggle="modal">
                    <i class="fas fa-plus"></i> Tambah Mapel
                </button>
                    <table class="table table-hover table-bordered table-stripped" id="example2">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Kode Mata Pelajaran</th>
                                    <th scope="col">Nama Mata Pelajaran</th>
                                    <th scope="col">Guru Pengampu</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($mapels as $mapel)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $mapel->kode_mapel }}</td>
                                        <td>{{ $mapel->nama_mapel }}</td>                         
                                        <td>
                                            @if ($mapel->gurus)
                                                {{ $mapel->gurus->nama_guru }}
                                            @endif
                                        </td>
                                        <td>
                                            {{-- <a href="{{ route('mapels.edit', $mapel->id_mapel) }}" class="btn btn-primary btn-xs">
                                                <i class="fas fa-edit"></i>   Edit
                                            </a> --}}
                                            <button class="btn btn-success" id="btnEdit" 
                                            data-toggle="modal"
                                            data-target="#modalEdit"
                                            data-id_guru="{{$mapel->gurus->id_guru}}"
                                            data-id_mapel="{{$mapel->id_mapel}}"
                                            data-nama_mapel="{{$mapel->nama_mapel}}"
                                            data-kode_mapel="{{$mapel->kode_mapel}}"
                                            >
                                                <i class="fas fa-edit"></i> Edit 
                                            </button>
                                            <form action="{{ route('mapels.destroy', $mapel->id_mapel) }}" method="POST" style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-xs" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                    <i class="fas fa-trash"></i>   Delete
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
        {{$mapels->links()}}
        </div>
    </div>

    <div class="modal fade" id="modalTambah" role="dialog" aria-labelledby="modalTambah" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambah">Tambah Data Mapel</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="formTambahMapel">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama">Nama Mata Pelajaran :</label>
                            <input type="text" name="nama_mapel" id="nama_mapel" class="form-control" placeholder="Masukan Nama Mata Pelajaran" required>
                        </div>      
                        <div class="form-group">
                            <label for="kode">Kode Mapel:</label>
                            <input type="text" class="form-control" id="kode_mapel" name="kode_mapel" placeholder="Masukan Kode Mata Pelajaran" required>
                        </div>                 
                        <div class="form-group">
                            <label for="guru">Pilih Guru Pengampu:</label>
                            <select name="nama_guru" id="nama_guru" class="form-control" required >
                            </select>
                            <input type="hidden" name="id_guru" id="id_guru">
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

    <div class="modal fade" id="modalEdit" role="dialog" aria-labelledby="modalEdit" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEdit">Edit Data Mapel</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="formEditMapel">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama">Nama Mata Pelajaran :</label>
                            <input type="text" name="nama_mapel_edit" id="nama_mapel_edit" class="form-control" placeholder="Masukan Nama Mata Pelajaran" required>
                            <input type="hidden" name="id_mapel_edit" id="id_mapel_edit">
                        </div>      
                        <div class="form-group">
                            <label for="kode">Kode Mapel:</label>
                            <input type="text" class="form-control" id="kode_mapel_edit" name="kode_mapel_edit" placeholder="Masukan Kode Mata Pelajaran" required>
                        </div>                 
                        <div class="form-group">
                            <label for="guru">Pilih Guru Pengampu:</label>
                            <select name="nama_guru_edit" id="nama_guru_edit" class="form-control" required >
                            </select>
                            <input type="hidden" name="id_guru_edit" id="id_guru_edit">
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
@endsection

@section('js')
<script>
$(document).ready(function() {
    $('#modalTambah').on('shown.bs.modal', function () {
        $('#nama_guru').select2({
            placeholder: 'Pilih Guru',
            dropdownParent: $('#modalTambah'), // Menyelesaikan masalah z-index
            ajax: {
                url: '{{ route("guru.search") }}',
                dataType: 'json',
                delay: 250,
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                id: item.id_guru,
                                text: item.nama_guru,
                            };
                        })
                    };
                },
                cache: true
            }
        });
    });

    $('#nama_guru').on('change', function () {
        let id_guru = $(this).val();
        $('#id_guru').val(id_guru); 
    });

    $('#modalEdit').on('shown.bs.modal', function () {
        $('#nama_guru_edit').select2({
            placeholder: 'Pilih Guru',
            dropdownParent: $('#modalEdit'), // Menyelesaikan masalah z-index
            ajax: {
                url: '{{ route("guru.search") }}',
                dataType: 'json',
                delay: 250,
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                id: item.id_guru,
                                text: item.nama_guru,
                            };
                        })
                    };
                },
                cache: true
            }
        });
    });

    $('#nama_guru_edit').on('change', function () {
        let id_guru = $(this).val();
        $('#id_guru_edit').val(id_guru); 
    });


    $('#formTambahMapel').on('submit', function(e){
        e.preventDefault();

        let nama_mapel = $('#nama_mapel').val();
        let kode_mapel = $('#kode_mapel').val();
        let id_guru = $('#id_guru').val();

        $.ajax({
            url: "{{route('mapels.store')}}",
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                nama_mapel: nama_mapel,
                kode_mapel: kode_mapel,
                id_guru: id_guru, 
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                $('#modalTambah').modal('hide');
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
                // console.error(xhr.responseText);
                Swal.fire({
                            icon: 'error',
                            title: 'Data Gagal Ditambahkan',
                            text: xhr.responseText,
                            timer: 3000,  // Waktu delay 3 detik
                            // showConfirmButton: false,  // Tidak ada tombol konfirmasi
                        }).then(() => {
                            location.reload();  // Reload halaman setelah notifikasi selesai
                        });
            }
        });
    });

    $(document).on('click', '#btnEdit', function(){
        let id_mapel = $(this).data('id_mapel');
        let kode_mapel = $(this).data('kode_mapel');
        let nama_mapel = $(this).data('nama_mapel');
        let id_guru = $(this).data('id_guru');

        // Assign values to modal inputs
        $('#nama_mapel_edit').val(nama_mapel);
        $('#id_mapel_edit').val(id_mapel);
        $('#kode_mapel_edit').val(kode_mapel);
        $('#id_guru_edit').val(id_guru).trigger('change'); // Update dropdown selectz
    });

    // Handle form submission for editing
    $('#formEditMapel').on('submit', function(e){
        e.preventDefault();

        let id_mapel = $('#id_mapel_edit').val();
        let nama_mapel = $('#nama_mapel_edit').val();
        let kode_mapel = $('#kode_mapel_edit').val();
        let id_guru = $('#id_guru_edit').val();

        $.ajax({
            url: "{{route('mapels.update', ':id_mapel')}}".replace(':id_mapel', id_mapel),
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                nama_mapel: nama_mapel,
                kode_mapel: kode_mapel,
                id_guru: id_guru, 
                _token: '{{ csrf_token() }}',
                _method: 'PUT'
            },
            success: function(response) {
                $('#modalEdit').modal('hide');
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

</script>

@stop
