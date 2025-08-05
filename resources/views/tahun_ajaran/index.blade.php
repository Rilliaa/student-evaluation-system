<!-- Daftar Tahun Ajaran -->
@extends('adminlte::page')
@section('title', 'Tahun Ajaran')
@section('content_header')
    <h1 class="m-0 text-dark">Daftar Tahun Ajaran</h1>
@stop
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" defer></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
{{-- Halaman ini di atur di method index TahunAjaranController --}}

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <button id="tambahPelanggaranButton" type="button" class="btn btn-primary btn-sm mb-3" data-toggle="modal" data-target="#modalTambahTA">
                    <i class="fas fa-plus"></i>Tambah Tahun Ajaran
                </button>
                <table class="table table-hover table-bordered table-stripped" id="example2">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Tahun Mulai</th>
                            <th scope="col">Tahun Selesai</th>
                            <th scope="col">Kode Tahun Ajaran</th>
                            {{-- <th>ID</th> --}}
                            <th scope="col" style="text-align: center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tahunAjarans as $data)
                        <tr id="row_{{ $loop->iteration }}">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{$data->tahun_mulai}}</td>                           
                            <td>{{$data->tahun_selesai}}</td>                           
                            <td>{{$data->kode_ta}}</td>
                            {{-- <td>{{$data->id_ta}}</td> --}}
                            <td>
                                    <button type="button" id="btnEdit" class="btn btn-success btn-sm editButton" data-toggle="modal" data-target="#modalEditTA" data-id_ta="{{ $data->id_ta }}" data-tahun_mulai="{{ $data->tahun_mulai }}" data-tahun_selesai="{{ $data->tahun_selesai }}" data-kode_ta="{{ $data->kode_ta }}">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    {{-- <button type="button" class="btn btn-danger btn-sm deleteButton" data-id="{{ $data->id_ta }}">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>     --}}
                                    <form action="{{ route('tahun-ajaran.destroy', $data->id_ta) }}" method="POST" style="display: inline;">
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
    {{$tahunAjarans->links()}}
</div>
@endsection

{{-- Modal Tambah data --}}
<div class="modal fade" id="modalTambahTA" role="dialog" aria-labelledby="modalTambahTA" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTambahPelanggaranTitle">Tambah Tahun Ajaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formTambahTA">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="tahun_mulai">Tahun Mulai:</label>
                        <input type="number" class="form-control" id="tahun_mulai" name="tahun_mulai" placeholder="Tahun Sekarang"  required>
                    </div>      
                    <div class="form-group">
                        <label for="tahun_selesai">Tahun Selesai:</label>
                        <input type="number" class="form-control" id="tahun_selesai" name="tahun_selesai" placeholder="Tahun Depan" required>
                    </div>      
                    <div class="form-group">
                        <label for="kode_ta">Kode Tahun Ajaran:</label>
                        <input type="text" class="form-control" id="kode_ta" name="kode_ta" placeholder="Tahun Sekarang / Semester(2020/1)" required>
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

<!-- Modal Edit Tahun Ajaran -->
<div class="modal fade" id="modalEditTA" tabindex="-1" role="dialog" aria-labelledby="modalEditTATitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditTATitle">Edit Tahun Ajaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formEditTA">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input type="hidden" id="edit_id_ta" name="edit_id_ta">
                    <div class="form-group">
                        <label for="edit_tahun_mulai">Tahun Mulai:</label>
                        <input type="number" class="form-control" id="edit_tahun_mulai" name="edit_tahun_mulai" placeholder="Tahun Mulai" required>
                    </div>      
                    <div class="form-group">
                        <label for="edit_tahun_selesai">Tahun Selesai:</label>
                        <input type="number" class="form-control" id="edit_tahun_selesai" name="edit_tahun_selesai" placeholder="Tahun Selesai" required>
                    </div>      
                    <div class="form-group">
                        <label for="edit_kode_ta">Kode Tahun Ajaran:</label>
                        <input type="text" class="form-control" id="edit_kode_ta" name="edit_kode_ta" placeholder="Kode Tahun Ajaran" required>
                    </div>               
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
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

    // Script untuk store data --Start
    $(document).ready(function() {
        // Form submission via AJAX
        $('#formTambahTA').submit(function(event) {
        event.preventDefault(); // Prevent default form submission
        
        var tahun_mulai = $('#tahun_mulai').val();
        var tahun_selesai = $('#tahun_selesai').val();
        var kode_ta = $('#kode_ta').val();
        
        $.ajax({
            url: '{{ route("tahun-ajaran.store") }}',
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                tahun_mulai: tahun_mulai,
                tahun_selesai: tahun_selesai,
                kode_ta: kode_ta
            },
            success: function(response) {
                console.log("Sukses", response);
                $('#modalTambahTA').modal('hide');
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
// Script untuk store data --End

// Jquery untuk ngisi value modal edit --Start
$('body').on('click', '#btnEdit', function() {
    var tahun_mulai = $(this).data('tahun_mulai');
    var tahun_selesai = $(this).data('tahun_selesai');
    var kode_ta = $(this).data('kode_ta');
    var id = $(this).data('id_ta');

    document.getElementById("edit_id_ta").value = id;
    document.getElementById("edit_tahun_mulai").value = tahun_mulai;
    document.getElementById("edit_tahun_selesai").value = tahun_selesai;
    document.getElementById("edit_kode_ta").value = kode_ta;

});
// Jquery untuk ngisi value modal edit --End

// Sciprt untuk Mengedit --START
$('#formEditTA').submit(function(event) {
    event.preventDefault();
    
    let id_tahun = $('#edit_id_ta').val();
    let tahun_mulai = $('#edit_tahun_mulai').val();
    let tahun_selesai = $('#edit_tahun_selesai').val();
    let kode_ta = $('#edit_kode_ta').val();

    $.ajax({
        url: '{{ route("tahun-ajaran.update", [ ":id"]) }}'.replace(':id', id_tahun),
        method: 'PUT',
        data: {
            _token: '{{ csrf_token() }}',
            tahun_mulai: tahun_mulai,
            tahun_selesai: tahun_selesai,
            kode_ta: kode_ta
        },
        success: function(response) {
            console.log("Sukses", response);
            $('#modalEditTA').modal('hide');
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
// Sciprt untuk Mengedit --END

// Script untuk Menghapus --START
// $('body').on('click', '.deleteButton', function () {
//     var id = $(this).data("id");
//     var result = confirm("Apakah Anda yakin ingin menghapus data ini?");
//     if (result) {
//         $.ajax({
//             type: "DELETE",
//             url: '{{ route("tahun-ajaran.destroy", [ ":id"]) }}'.replace(':id', id),
//             data: {
//                 _token: '{{ csrf_token() }}',
//             },
//             success: function (response) {
//                 console.log("Sukses", response);
//                 location.reload();
//             },
//             error: function (xhr, status, error) {
//                 console.error(xhr.responseText);
//             }
//         });
//     }
// });
// Script untuk Menghapus --END

</script>

@endsection
