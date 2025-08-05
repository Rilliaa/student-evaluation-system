@extends('adminlte::page') 
@section('title', 'Jadwal Pelajaran || Daftar Kelas')

@section('content_header')
<h1 class="m-0 text-dark"> 
    Halaman Jadwal Pelajaran | 
    <span style="color: #ff9e2a; font-weight: bold">
        Daftar Kelas
    </span>
</h1>
@stop

@section('content')
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
                        <select id="tahunAjaran" name="tahunAjaran" class="form-control" required>
                            <option value="" selected disabled> -- Pilih Tahun Ajaran -- </option>
                            @foreach($tahunAjaran as $ta)
                                <option value="{{ $ta->id_ta }}">{{ $ta->kode_ta }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-info">Submit</button>
                </form>

                <div id="resultContainer" style="margin-top: 20px;">
                    <div class="form-group">
                        <label style="font-weight: bold;">Kode Tahun Ajaran yang Dipilih:</label>
                        <input type="text" id="testValue" class="form-control" readonly />
                        <input type="hidden" id="id_testValue" />
                    </div>
                </div>

                <div class="table-responsive" id="tableContainer" style="display: none;">
                    <table class="table table-hover table-bordered table-striped">
                        <thead>
                            <tr class="text-center">
                                <th>No</th>
                                <th>Nama Kelas</th>
                                <th>Wali Kelas</th>
                                <th>Kode Tahun Ajaran</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody"></tbody>
                    </table>
                </div>
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
                            var url = '{{ route("jadwal.rincian", ["id_kelas" => ":id_kelas", "id_ta" => ":id_ta"]) }}';
                            url = url.replace(':id_kelas', kelas.id_kelas).replace(':id_ta', kelas.id_ta);

                            let row = `
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${kelas.nama_kelas}</td>
                                    <td>${kelas.nama_guru}</td>
                                    <td>${kelas.kode_ta}</td>
                                    <td style="text-align : center">
                                        <a href="${url}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-cog"></i> Kelola Jadwal
                                        </a>
                                    </td>
                                </tr>
                            `;
                            $('#tableBody').append(row);
                        });

                        var notification = $('<div>', {
                            class: 'alert alert-success',
                            role: 'alert',
                            text: 'Data Ditemukan',
                            style: 'text-align: center'
                        });

                        $('#resultContainer').append(notification);
                        setTimeout(function() {
                            notification.remove();
                        }, 1000);
                    }
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                }
            });
        });
    });
</script>
@stop
