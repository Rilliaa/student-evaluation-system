@extends('adminlte::page')
@section('title','Halaman Kelola Kehadiran')
@section('content_header')
<h1>Halaman Kelola Kehadiran, Kelas 
    <span  class="label label-lg label-light-success label-inline" style="font-weight:bold; color: #ff9e2a; border-radius: 5px; padding: 3px 8px; text-align: center;">{{$kelas->nama_kelas}}</span>
 
</h1>
@stop

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="mb-3 mt-3">
                    <a href="{{ route('modul.guru.jadwal',$guru->id_guru)}}" class="btn btn-primary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
                @if($sesi !== null)
                <div id="resultContainer" style="margin-top: 20px;">
                    <div class="form-Group" style="margin-bottom: 15px;">
                        <label style="font-weight: bold;">Data absensi Untuk Tanggal:</label>
                        <input type="text" id="testValue" class="form-control" style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #ced4da;" value="{{ \Carbon\Carbon::parse($tgl_sekarang)->format('d-m-y') }}" readonly />
                        <input type="hidden" id="id_sesi_form" name="id_sesi_form" value="{{$sesi->id_sesi}}" class="form-control" disabled readonly>
                    </div>
                    <div class="table-responsive" id="tableContainer">
                        <button type="button" class="btn btn-success mb-3" id="cekKehadiranBtn">
                        Cek Kehadiran <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                </div>
                <div class="table-responsive" id="tabelData" style="display: none">
                {{-- <div class="table-responsive" id="tabelData" > --}}
                    <table class="table table-hover table-bordered table-stripped" id="example2">
                        <thead>
                            <tr>
                                <td colspan="6" style="text-align: center"><strong>Data Absensi Kelas {{ $kelas->nama_kelas }}, Tanggal <span id="tanggal_sesi_tabel">{{ \Carbon\Carbon::parse($tgl_sekarang)->format('d-m-y') }}</span></strong></td>
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
                <form id="FormTambahKehadiran" method="POST" action="/modul/guru/store-kehadiran">
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
                        <input type="text" id="tanggal_modal" name="tanggal_modal" class="form-control" style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #ced4da; background-color: #f8f9fa;" value="{{$tgl_sekarang}}" readonly>
                        <input type="hidden" id="id_sesi_modal" name="id_sesi_modal" value="{{$sesi->id_sesi}}">
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
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
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
                <h5 class="modal-title" id="myModalLabel">Edit Kehadiran</h5>
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
                            <input type="text" id="tanggal_edit" name="tanggal_edit" class="form-control" style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #ced4da; background-color: #f8f9fa;" value="{{$tgl_sekarang}}" readonly>
                            <input type="hidden" id="id_sesi_edit" name="id_sesi_edit" value="{{$sesi->id_sesiz}}">
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
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary" id="editPresensiBtn" data-dismiss="modal">Simpan</button>
            </div>
        </div>
    </div>
</div>

@else
<input type="hidden" id="sesiNull" value="true">
@endif

<div class="modal fade" id="sesiModal" tabindex="-1" role="dialog" aria-labelledby="sesiModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="sesiModalLabel" >Pemberitahuan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <span class="label label-lg label-light-danger label-inline" style="color: #f64e60;background-color: #ffe2e5; border-radius: 5px; padding: 3px 8px; text-align: center;"> Sesi Belum Dibuka!. Silahkan hubungi admin untuk membuka sesi</span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
$(document).ready(function() {
    if ($('#sesiNull').val() === 'true') {
            $('#sesiModal').modal('show');
        }


    document.getElementById('cekKehadiranBtn').addEventListener('click', function() {
    var id_sesi = document.getElementById('id_sesi_form').value;
    var tanggal_sesi = document.getElementById('testValue').value;
    var id_kelas = {{ $kelas->id_kelas }};


    $.ajax({
        url: '{{ route("modul.guru.cekKehadiran") }}',
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
                url: '{{ route("modul.guru.getKehadiranByMurid") }}',
                method: 'GET',
                data: {
                    id_kelas: id_kelas,
                    id_sesi: id_sesi
                },
                success: function(response) {
                    response.forEach(function(data, index) {
                        var kehadiran = data.kehadirans.length > 0 ? data.kehadirans[0] : {};
                        var tombol = '';
                        // var deleteUrl = `{{ route('kehadiran.destroy', ':id') }}`.replace(':id', kehadiran.id);
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
        url: '{{ route("modul.guru.kehadiran.store") }}',
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
        url: '{{ route("modul.guru.kehadiran.update", ":id") }}'.replace(':id', $('#id_kehadiran_edit').val()),
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