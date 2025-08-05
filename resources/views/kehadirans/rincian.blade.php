@extends('adminlte::page')
@section('title', 'Rincian Kehadiran | Daftar Kelas')
@section('content_header')
<h1 class="m-0 text-dark"> 
    Halaman Kelola Kehadiran | <span style="color: #ff9e2a; font-weight:bold">Daftar Kelas</span> 
</h1>
@stop

@section('content')
{{-- Halaman Ini di atur pada KehadiranController/method rincian --}}
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
                            <option value="" selected disabled> -- Pilih Tahun Ajaran -- </option>
                            @foreach($tahunAjaran as $ta)
                                <option value="{{ $ta->id_ta }}">{{ $ta->kode_ta }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>

                <div id="resultContainer" style="margin-top: 20px;">
                    <div class="form-group" style="margin-bottom: 15px;">
                        <label style="font-weight: bold;">Kode Tahun Ajaran yang Dipilih:</label>
                        <input type="text" id="testValue" class="form-control" style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #ced4da;" value="" readonly />
                        <input type="hidden" id="id_testValue" class="form-control"/>
                    </div>
                </div>
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
                        var row = '<tr>' +
                                    '<td>' + (index + 1) + '</td>' +
                                    '<td>' + kelas.nama_kelas + '</td>' +
                                    '<td>' + kelas.nama_guru + '</td>' +
                                    '<td>' + kelas.kode_ta + '</td>' +
                                    '<td style="text-align : center;">' +
                                        '<a href="{{ url('/kelas-kehadiran') }}/' + kelas.id_kelas + '/' + kelas.id_ta + '" class="btn btn-primary btn-sm">' +
                                            '<i class="fas fa-eye"></i> Kelola Kehadiran' +
                                        '</a> ' +
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
   });
</script>


@stop
