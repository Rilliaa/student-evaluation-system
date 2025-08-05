@extends('adminlte::page')
@section('title', 'Rincian Kehadiran Kelas')

@section('content_header')
<h1 class="m-0 text-dark">Halaman Kelola Kehadiran | <span style="font-weight:bold ; color:#ff9e2a">Daftar Murid</span> 

</h1>
<div class="d-flex justify-content-between mt-2">
    <div>
        <h3 class="d-inline-block mt-3">Kelas: <span style="font-weight:bold ; color:#ff9e2a">{{ $kelas->nama_kelas }}</span></h3>
    </div>
    <div>
        <h3 class="d-inline-block mt-3">Kode Tahun Ajaran: <button class="btn btn-primary">{{ $kelas->tahunAjaran->kode_ta }}</button></h3>
    </div>
</div>
@stop

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
{{-- Halamaan ini di atur pada method kehadiran pada KelasController --}}
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="mb-3">
                    <a href="{{ route('rincian-kehadiran.index') }}" class="btn btn-primary">
                    <i class="fas fa-arrow-left"></i>    Kembali 
                    </a>
                </div>
                <form id="formFilterTanggal" class="mt-3">
                    <div class="form-group">
                        <label for="tanggal">Pilih Tanggal Sesi</label>
                        <input type="date" id="tanggal" name="tanggal" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-success">
                    Cek Sesi <i class="fas fa-arrow-right"></i>
                    </button>
                </form>
                <div id="resultContainer" style="margin-top: 20px;">
                    <div class="form-Group" style="margin-bottom: 15px;">
                        <label style="font-weight: bold;">Data absensi Untuk Tanggal:</label>
                        <input type="text" id="testValue" class="form-control" style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #ced4da;" value="" readonly />
                        <input type="hidden" id="id_sesi_form" name="id_sesi_form" class="form-control">
                    </div>
                    <div class="table-responsive" id="tableContainer" style="display: none;">
                        <button type="button" class="btn btn-primary mb-3" id="cekKehadiranBtn">
                        Cek Kehadiran <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                </div>
                <div class="table-responsive" id="tabelData" style="display: none">
                    <table class="table table-hover table-bordered table-stripped" id="example2">
                        <thead>
                            <tr>
                                <td colspan="6" style="text-align: center"><strong>Data Absensi Kelas {{ $kelas->nama_kelas }}, Tanggal <span id="tanggal_sesi_tabel"></span></strong></td>
                            </tr>
                            <tr style="text-align: center">
                                <th>No</th>
                                <th>Nama Murid</th>
                                <th>Kelas</th>
                                <th>Status</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody">
    
                        </tbody>
                    </table>
                </div>
                
            </div>
        </div>
    </div>
</div>

{{--  Modal tambah --}}
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Tambah Presensi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="FormTambahKehadiran" method="POST" action="/store-kehadiran">
                    @csrf
                    <div class="form-group">
                        <label for="nama_murid">Nama Murid:</label>
                        <input type="text" class="form-control" id="nama_murid_modal" name="nama_murid_modal" value="" readonly>
                        <input type="hidden" id="id_murid_modal" name="id_murid_modal" value="">
                    </div>
                    <div class="form-group">
                        <label for="nama_kelas">Nama Kelas:</label>
                        <input type="text" class="form-control" id="nama_kelas_modal" name="nama_kelas_modal" value="" readonly>
                        <input type="hidden" class="form-control" id="id_kelas_modal" name="id_kelas_modal" value="{{ $kelas->id_kelas }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="nama_kelas">Tanggal:</label><br>
                        <input type="text" id="tanggal_modal" name="tanggal_modal" class="form-control" style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #ced4da; background-color: #f8f9fa;" value="" readonly>
                        <input type="hidden" id="id_sesi_modal" name="id_sesi_modal" value="">
                    </div>
                    <div class="form-group">
                        <label for="status">Status Kehadiran:</label>
                        <select name="status" id="status_modal" class="form-control" required>
                            <option value="">Pilih Status</option>
                            <option value="Hadir">Hadir</option>
                            <option value="Mangkir">Mangkir</option>
                            <option value="Izin">Izin</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Keterangan:</label>
                        <input type="text" class="form-control" id="keterangan" name="keterangan" value="">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="tambahPresensiBtn" data-dismiss="modal">Simpan</button>
            </div>
        </div>
    </div>
</div>

{{-- Modal edit --}}
<div class="modal fade" id="EditModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Edit Presensi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="FormEditKehadiran" method="PUT"  >
                {{-- <form action="{{ route('kehadiran.update', $kehadiran->id) }}" method="POST"> --}}
                @csrf
                @method('PUT')
                 <div class="modal-body">
                        <input type="hidden" id="id_kehadiran_edit" name="id_kehadiran_edit">
                        <div class="form-group">
                            <label for="nama_murid">Nama Murid:</label>
                            <input type="text" class="form-control" id="nama_murid_edit" name="nama_murid_modal" value="" readonly>
                            <input type="hidden" id="id_murid_edit" name="id_murid_edit" value="">
                        </div>
                        <div class="form-group">
                            <label for="nama_kelas">Nama Kelas:</label>
                            <input type="text" class="form-control" id="nama_kelas_edit" name="nama_kelas_edit" value="" readonly>
                            <input type="hidden" class="form-control" id="id_kelas_edit" name="id_kelas_edit" value="{{ $kelas->id_kelas }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="nama_kelas">Tanggal:</label><br>
                            <input type="text" id="tanggal_edit" name="tanggal_edit" class="form-control" style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #ced4da; background-color: #f8f9fa;" value="" readonly>
                            <input type="hidden" id="id_sesi_edit" name="id_sesi_edit" value="">
                        </div>
                        <div class="form-group">
                            <label for="status">Status Kehadiran:</label>
                            <select name="status" id="status__edit" class="form-control" required>
                                <option value="">Pilih Status</option>
                                <option value="Hadir">Hadir</option>
                                <option value="Mangkir">Mangkir</option>
                                <option value="Izin">Izin</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Keterangan:</label>
                            <input type="text" class="form-control" id="keterangan_edit" name="keterangan" value="">
                        </div>
                    </div>
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="editPresensiBtn" data-dismiss="modal">Simpan</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
$(document).ready(function() {
    function formatTanggal(tanggal) {
        var parts = tanggal.split('-'); 
        return parts[2] + '/' + parts[1] + '/' + parts[0]; 
}

    var tanggal_sementara = '';
   // Validasi data di AJAX request filterByTanggal
document.getElementById('formFilterTanggal').addEventListener('submit', function(event) {
    event.preventDefault();

    tanggal_sementara = document.getElementById('tanggal').value;
    var format = formatTanggal(tanggal_sementara); 
    var id_kelas = {{ $kelas->id_kelas }};

    $.ajax({
        url: '{{ route("filterByTanggal") }}',
        method: 'GET',
        data: {
            tanggal: tanggal_sementara,
            id_kelas: id_kelas
        },
        success: function(response) {
            if (response && response.length === 0) {
                alert('Sesi tidak ada atau belum dimulai');
            } else if (response && response.length > 0) {
                var notification = document.createElement('div');
                notification.classList.add('alert', 'alert-success');
                notification.setAttribute('role', 'alert');
                notification.textContent = 'Data Sesi Ditemukan';
                notification.style.textAlign = 'center';


                var resultContainer = document.getElementById('resultContainer');
                resultContainer.appendChild(notification);

                setTimeout(function() {
                    resultContainer.removeChild(notification);
                }, 1000);

                // Ngisi Value untuk form tanggal pada form utama 
                document.getElementById('testValue').value = tanggal_sementara;
                document.getElementById('id_sesi_form').value = response[0].id_sesi;
                
                // Ngisi Value untuk form tanggal pada modal tambah 
                document.getElementById('tanggal_modal').value = tanggal_sementara;
                document.getElementById('id_sesi_modal').value = response[0].id_sesi;
                
                // Ngisi Value untuk form tanggal pada modal edit 
                document.getElementById('tanggal_edit').value = tanggal_sementara;
                document.getElementById('id_sesi_edit').value = response[0].id_sesi;
                
                document.getElementById('tableContainer').style.display = 'block';
            } else {
                console.error('Invalid response:', response);
            }
        },
        error: function(xhr, status, error) {
            console.error('Gagal mengambil data tanggal:', error);
        }
    });
});

// Validasi data di AJAX request cekKehadiran
document.getElementById('cekKehadiranBtn').addEventListener('click', function() {
    var id_sesi = document.getElementById('id_sesi_form').value;
    var tanggal_sesi = document.getElementById('testValue').value;
    var formattedTanggal = formatTanggal(tanggal_sesi);
    $('#tanggal_sesi_tabel').text(formattedTanggal);

    var id_kelas = {{ $kelas->id_kelas }};


    $.ajax({
        url: '{{ route("cekKehadiran") }}',
        method: 'GET',
        data: {
            id_sesi: id_sesi,
            id_kelas: id_kelas
        },
        success: function(response) {
            // console.log("Data :", response);
            var tableBody = document.getElementById('tableBody');
            tableBody.innerHTML = '';

            // // Jika Kosong
            // if (response && response.length === 0) {
            //     var notification = document.createElement('div');
            //     notification.classList.add('alert', 'alert-danger');
            //     notification.setAttribute('role', 'alert');
            //     notification.textContent = 'Data Kehadiran Tidak Ditemukan';
            //     notification.style.textAlign = 'center';

            // } else if (response && response.length > 0) {
                var notification = document.createElement('div');
                notification.classList.add('alert', 'alert-success');
                notification.setAttribute('role', 'alert');
                notification.textContent = 'Data Kehadiran Ditemukan';
                notification.style.textAlign = 'center';

            // } else {
            //     console.error('Invalid response:', response);
            // }

            var resultContainer = document.getElementById('resultContainer');
                resultContainer.appendChild(notification);

            setTimeout(function() {
                resultContainer.removeChild(notification);
            }, 1000);

            document.getElementById('tabelData').style.display = 'block';
            $.ajax({
                url: '{{ route("getKehadiranByMurid") }}',
                method: 'GET',
                data: {
                    id_kelas: id_kelas,
                    id_sesi: id_sesi
                },
                success: function(response) {
                    response.forEach(function(data, index) {
                        // respon nya = data. Responnya berisi informasi murid lalu informasi kelas dari murid -> informasi kehadiran dari murid

                        // console.log("Halo ini id_sesi view ",id_sesi);
                        // console.log("dan ini id_sesi controller", id_sesi_controller);

                        var kehadiran = data.kehadirans.length > 0 ? data.kehadirans[0] : {};
                        var tombol = '';
                        var deleteUrl = `{{ route('kehadiran.destroy', ':id') }}`.replace(':id', kehadiran.id);
                        var nama_kelas = `{{$kelas->nama_kelas}}`;

                            if (Object.keys(kehadiran).length === 0) {
                                // Jika presensi belum ada
                                tombol = `
                                    <button class="btn btn-primary" 
                                        id="tambahPresensi" 
                                        data-target="#myModal" 
                                        type="button" 
                                        data-id_murid="${data.id_murid}" 
                                        data-id_kelas="${id_kelas}" 
                                        data-nama_kelas="${nama_kelas}" 
                                        data-nama_murid="${data.nama_murid}" 
                                        class="btn btn-primary btn-sm" 
                                        data-toggle="modal" 
                                        data-row="${index + 1}"
                                        >
                                      <i class="fas fa-plus"></i>  Tambah Presensi
                                    </button>`;
                            } else {
                                // Jika presensi sudah ada
                                tombol = `
                                    <button class="btn btn-success"
                                        id="editPresensi"
                                        data-target="#EditModal"
                                        data-id_kehadiran="${kehadiran.id}" 
                                        data-id_murid="${data.id_murid}" 
                                        data-id_kelas="${id_kelas}" 
                                        data-nama_kelas="${nama_kelas}" 
                                        data-nama_murid="${data.nama_murid}" 
                                        data-status="${kehadiran.status}"
                                        data-keterangan="${kehadiran.keterangan}"
                                        class="btn btn-primary btn-sm" 
                                        data-toggle="modal" 
                                        data-row="${index + 1}"
                                    >
                                      <i class="fas fa-edit"></i> Edit Presensi
                                    </button>`;
                            }

                            var row = `
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${data.nama_murid}</td>
                                    <td>${nama_kelas}</td>
                                    <td>${kehadiran.status ? kehadiran.status :
                                        `<span class="label label-lg label-light-danger label-inline" 
                                            style="color: #f64e60;background-color: #ffe2e5; border-radius: 5px; padding: 3px 8px; text-align: center;">
                                            Belum Ditentukan
                                        </span>`}
                                    </td>
                                    <td>${kehadiran.keterangan ? kehadiran.keterangan : 
                                        `<span class="label label-lg label-light-danger label-inline" 
                                            style="color: #f64e60;background-color: #ffe2e5; border-radius: 5px; padding: 3px 8px; text-align: center;">
                                            Belum Ditentukan
                                        </span>`}
                                    </td>
                                    <td style="text-align:center; vertical-align:middle;">${tombol}</td>
                                </tr>
                            `;

                        tableBody.insertAdjacentHTML('beforeend', row);

                        $(`#tambahPresensi[data-row="${index + 1}"]`).on('click', function() {
                            var id_murid = $(this).data('id_murid');
                            var id_kelas = $(this).data('id_kelas');
                            var nama_murid = $(this).data('nama_murid');
                            var nama_kelas = $(this).data('nama_kelas');

                            $('#id_murid_modal').val(id_murid);
                            $('#id_kelas_modal').val(id_kelas);
                            $('#nama_murid_modal').val(nama_murid);
                            $('#nama_kelas_modal').val(nama_kelas);
                        });

                        $(`#editPresensi[data-row="${index + 1}"]`).on('click', function() {
                            var id_murid = $(this).data('id_murid');
                            var id_kelas = $(this).data('id_kelas');
                            var nama_murid = $(this).data('nama_murid');
                            var nama_kelas = $(this).data('nama_kelas');
                            var status = $(this).data('status');
                            var keterangan = $(this).data('keterangan');
                            var id_kehadiran = $(this).data('id_kehadiran');
                            
                            console.log('id_kehadiran',id_kehadiran);

                            $('#id_murid_edit').val(id_murid);
                            $('#id_kelas_edit').val(id_kelas);
                            $('#nama_murid_edit').val(nama_murid);
                            $('#nama_kelas_edit').val(nama_kelas);

                            $('#status_edit').val(status);
                            $('#id_kehadiran_edit').val(id_kehadiran);
                            $('#keterangan_edit').val(keterangan);
                        });

                    });
                },
                error: function(xhr, status, error) {
                    console.error('Gagal mengambil data murid:', error);
                }
            });


        },
        error: function(xhr, status, error) {
            console.error('Gagal mengambil data kehadiran:', error);
        }
    });
});

$('#tambahPresensiBtn').on('click', function() {
    $('#FormTambahKehadiran').submit(); 
});

$('#FormTambahKehadiran').on('submit', function(event) {
    event.preventDefault(); 
    console.log($(this).serialize()); 

    $.ajax({
        url: '{{ route("kehadiran.store") }}',
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: $(this).serialize(),
        success: function(response) {
            alert("Berhasil Menambahkan Presensi");
            $('#myModal').modal('hide');
            
            location.reload(); 
        },
        error: function(xhr, status, error) {
            console.error('Gagal menambahkan presensi:', error);
        }
    });
});




$('#editPresensiBtn').on('click', function() {
    $('#FormEditKehadiran').submit(); 
});

$('#FormEditKehadiran').on('submit', function(event) {
    event.preventDefault(); 
    console.log("Data Update",$(this).serialize());
    var id = $('#id_kehadiran_edit').val();
    console.log("Id Kehadiran", id) ;

    $.ajax({
        url: '{{ route("kehadiran.update", ":id") }}'.replace(':id', $('#id_kehadiran_edit').val()),
        // url : /update-kehadiran/+ id,
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: $(this).serialize(),
        success: function(response) {
            alert("Berhasil Edit Presensi");
            // $('#EditModal').modal('hide');
            location.reload(); 
        },
        error: function(xhr, status, error) {
            console.error('Gagal mengedit presensi:', error);
        }
    });
});



});

</script>
@stop