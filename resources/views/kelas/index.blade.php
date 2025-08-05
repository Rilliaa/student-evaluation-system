@extends('adminlte::page')
@section('title', 'Daftar Kelas')
@section('content_header')
<h1 class="m-0 text-dark">Daftar Kelas</h1>
@stop

@section('content')
{{-- Halaman Ini di atur pada KelasController/method index --}}
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" defer></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form id="formFilterTahunAjaran">
                    <div class="form-group">
                        <label for="tahunAjaran">Pilih Tahun Ajaran</label>
                        <select id="tahunAjaran" name="tahunAjaran" class="form-control" aria-placeholder="tes" required>
                            <option value=""> -- Pilih Tahun Ajaran -- </option>
                            @foreach($tahunAjaran as $ta)
                                <option value="{{ $ta->id_ta }}">{{ $ta->kode_ta }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-info">Submit</button>
                </form>

                <div id="resultContainer" style="margin-top: 20px;">
                    <div class="form-group" style="margin-bottom: 15px;">
                        <label style="font-weight: bold;">Kode Tahun Ajaran yang Dipilih:</label>
                        <input type="text" id="testValue" class="form-control" style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #ced4da;" value="" readonly />
                        <input type="hidden" id="id_testValue" class="form-control"/>
                    </div>
                </div>
                <button class="btn btn-primary mb-3 " 
                id="tambahKelas"
                data-target="#tambahKelasModal" 
                type="button" 
                class="btn btn-primary btn-sm"
                data-toggle="modal">
                    <i class="fas fa-plus"></i> Tambah Kelas
                </button>
                <div class="table-responsive" id="tableContainer" style="display: none;">
                    <table class="table table-hover table-bordered table-stripped">
                        <thead>
                            <tr style="text-align: center">
                                <th>No</th>
                                <th>Nama Kelas</th>
                                <th>Wali Kelas</th>
                                <th>Kode Tahun Ajaran</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody">
                            {{-- Data akan diisi menggunakan AJAX --}}
                        </tbody>
                    </table>
                </div>
                
            </div>
        </div>
    </div>
</div>
{{-- Modal Tambah Kelas --}}
<div class="modal fade" id="tambahKelasModal" role="dialog" aria-labelledby="tambahKelasLabel">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahKelasLabel">Tambah Data Kelas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="tambahKelasForm">
                    @csrf
                    <div class="form-group">
                        <label for="nama_kelas">Nama Kelas:</label>
                        <input type="text" class="form-control" id="nama_kelas" name="nama_kelas" required placeholder="Masukan Nama Kelas">
                    </div>
                    <div class="form-group">
                        <label for="id_guru">Pilih Wali Kelas</label>
                        <select name="id_guru" id="id_guru" class="form-control" required>
                        </select>
                        <input type="hidden" class="form-control" id="id_guru_real" name="id_guru_real">
                    </div>
                    <div class="form-group">
                        <label for="kode_ta">Kode Tahun Ajaran:</label>
                        <input type="text" class="form-control" id="kode_ta_modal" name="kode_ta_modal" readonly required>
                        <input type="hidden" class="form-control" id="id_ta_modal" name="id_ta_modal" readonly>
                    </div>        
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveBtn">Save Kelas</button>
            </div>
        </div>
    </div>
</div>

{{-- Modal Edit Kelas --}}
<div class="modal fade" id="editKelasModal"  role="dialog" aria-labelledby="editKelasModalLabel">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editKelasModalLabel">Edit Kelas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editKelasForm" method="POST" action="">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input type="hidden" id="edit_id_kelas" name="edit_id_kelas" value="">
                    <div class="form-group">
                        <label for="edit_nama_kelas">Nama Kelas:</label>
                        <input type="text" class="form-control" id="edit_nama_kelas" name="edit_nama_kelas" value="" required>
                    </div>  
                    <div class="form-group">
                        <label for="id_guru">Pilih Wali Kelas</label>
                        <select name="edit_id_guru" id="edit_id_guru" class="form-control" required>
                        </select>
                        <input type="hidden" class="form-control" id="id_guru_modal" name="id_guru_modal">
                    </div>
                    <div class="form-group">
                        <label for="edit_kode_ta">Kode Tahun Ajaran:</label>
                        <input type="text" class="form-control" id="edit_kode_ta" name="kode_ta" value="" readonly required>
                        <input type="hidden" class="form-control" id="edit_id_ta" name="edit_id_ta" value="" readonly>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="updateBtn" data-dismiss="modal">Save Changes</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
   $(document).ready(function() {
    $('#formFilterTahunAjaran').on('submit', function(event) {
        event.preventDefault();
        var id_ta = $('#tahunAjaran').val();
        var kode_ta = $('#tahunAjaran option:selected').text();
        $('#testValue').val(kode_ta);
        $('#id_testValue').val(id_ta);

        // Ajax untuk menampilkan kelas bedasarkan tahun ajaran yang dipilih --start
        $.ajax({
            url: '{{ route("kelas.byTahunAjaran") }}',
            method: 'GET',
            data: { id_ta: id_ta },
            success: function(response) {
                $('#tableBody').empty();
                if (response.length === 0) {
                    $('#tableContainer').hide();
                    alert('Data Kelas Tidak Ada Atau Belum Dibuat');
                } else {
                    $('#tableContainer').show();
                    response.forEach(function(kelas, index) {
                    var csrfToken = $('meta[name="csrf-token"]').attr('content'); // Ambil CSRF token dari meta tag

                    // URL untuk rute destroy, di-generate menggunakan Blade di luar JavaScript
                    var deleteUrl = "{{ route('kelasdestroy', ':id_kelas') }}";
                    deleteUrl = deleteUrl.replace(':id_kelas', kelas.id_kelas); // Ganti placeholder dengan id_kelas dinamis

                    var row = '<tr>' +
                                '<td>' + (index + 1) + '</td>' +
                                '<td>' + kelas.nama_kelas + '</td>' +
                                '<td>' + kelas.nama_guru + '</td>' +
                                '<td>' + kelas.kode_ta + '</td>' +
                                '<td>' +
                                    '<button id="editKelas" type="button" class="btn btn-primary editBtn" data-toggle="modal" data-target="#editKelasModal"  data-id_guru="' + kelas.id_guru + '" data-nama_kelas="' + kelas.nama_kelas + '" data-id_kelas="' + kelas.id_kelas + '" data-id_ta="' + kelas.id_ta + '" data-kode_ta="' + kelas.kode_ta + '">' + "<i class= 'fas fa-edit'></i>"+ 'Edit</button>' +
                                    '<form action="' + deleteUrl + '" method="POST" class="d-inline deleteForm">' +
                                        '<input type="hidden" name="_token" value="' + csrfToken + '">' + // Tambahkan CSRF token secara manual
                                        '<input type="hidden" name="_method" value="DELETE">' + // Tambahkan method DELETE
                                        '<button type="submit" class="btn btn-danger deleteBtn" onclick="return confirm(\'Apakah Anda yakin ingin menghapus data ini?\')">' +
                                            '<i class="fas fa-trash"></i> Delete' +
                                        '</button>' +
                                    '</form>' +
                                '</td>' +
                            '</tr>';

                    $('#tableBody').append(row);
                });



                    // script untuk notifikasi --start
                    var notification = document.createElement('div');
                    notification.classList.add('alert', 'alert-success');
                    notification.setAttribute('role', 'alert');
                    notification.textContent = 'Data Ditemukan';
                    notification.style.textAlign = 'center';

                    var resultContainer = document.getElementById('resultContainer');
                    resultContainer.appendChild(notification);

                    setTimeout(function() { //untuk timer durasi notif
                        resultContainer.removeChild(notification);
                    }, 1000);
                    // script untuk notifikasi --end
                }
            },
            error: function(xhr) {
                console.error(xhr.responseText);
            }
        });
        // Ajax untuk menampilkan kelas bedasarkan tahun ajaran yang dipilih --End
    });

    // Jquery untuk mengisi modal edit --start
    $('body').on('click', '.editBtn', function() {
        let nama_kelas = $(this).data('nama_kelas');
        let id_kelas = $(this).data('id_kelas');
        let id_ta = $(this).data('id_ta');
        let kode_ta = $(this).data('kode_ta');
        let id_guru = $(this).data('id_guru');
        console.log("ID GURU Sekarang: ", id_guru)

        document.getElementById('edit_id_guru').value = id_guru;
        document.getElementById('edit_nama_kelas').value = nama_kelas;
        document.getElementById('edit_id_ta').value = id_ta;
        document.getElementById('edit_kode_ta').value = kode_ta;
        document.getElementById('edit_id_kelas').value = id_kelas;
    });
    // Jquery untuk mengisi modal edit --end

    // Jquery untuk mengisi form kode ta pada modal tambah kelas --Start
    $('body').on('click', '#tambahKelas', function() {
        let kode_ta = document.getElementById("testValue").value;
        let id_ta = document.getElementById("id_testValue").value;
        document.getElementById("kode_ta_modal").value = kode_ta;
        document.getElementById("id_ta_modal").value = id_ta;
    });
    // Jquery untuk mengisi form kode ta pada modal tambah kelas --End


    // Jquery Untuk Select2 nama guru pada modal TAMBAH --start
    $(document).ready(function(){
    $('#tambahKelasModal').on('shown.bs.modal', function () {
        $('#id_guru').select2({
            placeholder: 'Pilih Nama Guru',
            ajax: {
                url: '{{ route("kelas.searchguru") }}',
                dataType: 'json',
                delay: 250,
                processResults: function(data) {
                    console.log("Data dari server : ", data);
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
            },
        });

            });

            $('#id_guru').on('change', function () {
                let id_guru_real = $(this).val();
                document.getElementById('id_guru_real').value = id_guru_real;
            });
        });

    // Jquery Untuk Select2 nama guru pada modal TAMBAH --end
    

    // Jquery Untuk Select2 nama guru pada modal EDIT --start
    $(document).ready(function(){
    $('#editKelasModal').on('shown.bs.modal', function () {
            $('#edit_id_guru').select2({
            placeholder: 'Pilih Nama Guru',
            ajax: {
                url: '{{ route("kelas.searchguru") }}',
                dataType: 'json',
                delay: 250,
                processResults: function(data) {
                    console.log("Data dari server : ", data);
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
            },
        });
            });
            $('#edit_id_guru').on('change', function () {
                let id_guru_real = $(this).val();
                document.getElementById('id_guru_modal').value = id_guru_real;
            });
        });

    // Jquery Untuk Select2 nama guru pada modal EDIT --end

    // Ketika Tombol simpan data ditekan --Start
    $('#saveBtn').click(function() {
        var nama_kelas = $('#nama_kelas').val();
        var id_guru = $('#id_guru').val();
        var id_ta = $('#id_ta_modal').val();

        $.ajax({
            url: '{{ route("kelas.store") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                nama_kelas: nama_kelas,
                id_guru: id_guru,
                id_ta: id_ta
            },
            success: function(response) {
                var newRow = '<tr>' +
                                '<td>' + ($('#tableBody tr').length + 1) + '</td>' +
                                '<td>' + nama_kelas + '</td>' +
                                '<td>' + $('#id_guru option:selected').text() + '</td>' +
                                '<td>' + $('#testValue').val() + '</td>' +
                                '<td>' +
                                    '<button id="editKelas" type="button" class="btn btn-primary btn-sm editBtn" data-toggle="modal" data-target="#editKelasModal" data-nama_kelas="' + nama_kelas + '" data-id_guru="' + response.id_guru + '" data-id_kelas="' + response.id_kelas + '" data-id_ta="' + id_ta + '" data-kode_ta="' + $('#testValue').val() + '">' + "<i class= 'fas fa-edit'></i>"+ 'Edit</button>' +
                                    '<form action="{{ url('/destroy') }}/' + response.id_kelas + '" method="POST" style="display:inline-block;">' +
                                        '@csrf' +
                                        '@method("DELETE")' +
                                        '<button type="submit" class="btn btn-danger btn-xs" onclick="return confirm(\'Apakah Anda yakin ingin menghapus data ini?\')">' +
                                            '<i class="fas fa-trash"></i> Delete' +
                                        '</button>' +
                                    '</form>' +
                                '</td>' +
                            '</tr>';
                $('#tableBody').append(newRow);
                // location.reload();
                $('#tableContainer').show();
                $('#tambahKelasModal').modal('hide');
            },
            error: function(xhr, status, error) {
                alert("Gagal Menyimpan Data");
            }
        });
    });
    // Ketika Tombol simpan data ditekan --End

    // Ketika Tombol updateBtn ditekan --Start
    $('#updateBtn').click(function() {
        var id_kelas = $('#edit_id_kelas').val();
        var edit_nama_kelas = $('#edit_nama_kelas').val();
        var edit_id_ta = $('#edit_id_ta').val();
        var edit_id_guru = $('#edit_id_guru option:selected').val();
        var edit_nama_guru = $('#edit_id_guru option:selected').text();

        $.ajax({
            url: '{{ route("kelas.update", ":id") }}'.replace(':id', id_kelas),
            method: 'POST',
            data: {
                _method: 'PUT',
                _token: '{{ csrf_token() }}',
                edit_nama_kelas: edit_nama_kelas,
                edit_id_guru: edit_id_guru,
                edit_id_ta: edit_id_ta
            },
            success: function(response) {
                if (response.success) {
                    $('#editKelasModal').modal('hide');

                    // Menghapus notifikasi lama jika ada
                    $('.alert-info').remove();

                    // script untuk notifikasi --start
                    var notification = document.createElement('div');
                    notification.classList.add('alert', 'alert-info');
                    notification.setAttribute('role', 'alert');
                    notification.textContent = 'Data berhasil di update';
                    notification.style.textAlign = 'center';

                    var resultContainer = document.getElementById('resultContainer');
                    resultContainer.appendChild(notification);

                    setTimeout(function() { //untuk timer durasi notif
                        resultContainer.removeChild(notification);
                    }, 1000);
                    // script untuk notifikasi --end

                    $('#formFilterTahunAjaran').submit();
                    // // Update row in the table
                    $('#tableBody tr').each(function() {
                        if ($(this).find('td:eq(0)').text() === id_kelas.toString()) {
                            $(this).find('td:eq(1)').text(edit_nama_kelas);
                            $(this).find('td:eq(2)').text(edit_nama_guru);
                        }
                    });
                } else {
                    alert('Terjadi kesalahan saat mengupdate data kelas.');
                }
            },
            error: function(xhr) {
                console.error(xhr.responseText);
                alert('Terjadi kesalahan saat mengupdate data kelas.');
            }
        });
    });
    // Ketika Tombol updateBtn ditekan --End
});

</script>


@stop
