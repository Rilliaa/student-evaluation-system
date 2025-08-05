@extends('adminlte::page')
@section('title', 'Sesi')
@section('content_header')
    <h1 class="m-0 text-dark">Daftar Sesi</h1>
@stop
@section('content')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="card-body d-flex justify-content-between">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                        <i class="fas fa-plus"></i>    Tambah Sesi
                        </button>

                </div>
                <div class="card-body">
                <table class="table table-hover table-bordered table-stripped" id="example2">
                    <thead>
                        <tr>
                            <th style="text-align:center">No</th>
                            <th>Tanggal</th>
                            <th>Hari</th>
                            <th>Kode Tahun Ajaran</th>
                            <th style="text-align: center">Status</th>
                            <th style="text-align: center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    @if($sesi->isEmpty())
                        <td colspan="6" style="text-align: center"><strong>Tidak Ada Data Sesi</strong></td>
                    @else
                        @foreach($sesi as $key => $sesiItem)
                             <tr id="row_{{ $loop->iteration }}">
                                <td style="text-align: center">{{ $key + 1 }}</td>
                                <td>{{ \Carbon\Carbon::parse($sesiItem->tanggal)->format('d-m-y') }}</td>
                                <td>{{ $sesiItem->hari }}</td>
                                <td>
                                    @if($sesiItem->tahunAjaran)
                                        {{ $sesiItem->tahunAjaran->kode_ta }}
                                    @else 
                                    Tidak Valid
                                    @endif
                                </td>
                                <td style="text-align: center">
                                    <span id="status{{ $key + 1 }}" style="border-radius: 5px; padding: 3px 8px; text-align: center;">
                                    </span>
                                </td> 
                                <td style="text-align: center">
                                    <button id="editBarisButton" type="button" class="btn btn-primary " 
                                    data-id_sesi="{{ $sesiItem->id_sesi }}" 
                                    data-tanggal="{{ $sesiItem->tanggal }}" 
                                    data-hari="{{ $sesiItem->hari }}" 
                                    data-id_ta="{{ $sesiItem->id_ta }}" 
                                    data-toggle="modal" data-target="#editModal"> 
                                        <i class="fas fa-edit"></i> Edit Sesi
                                    </button>
                                    <form action="{{ route('sesi.destroy', $sesiItem->id_sesi) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger " onclick="return confirm('Apakah Anda yakin ingin menghapus sesi ini?')">
                                        <i class="fas fa-trash"></i>
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
              
            </div>
        
        </div>
    </div>
    {{$sesi->links()}}
</div>
{{-- Modal Simpan Data --}}
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Tambah Sesi </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form untuk input data sesi pembelajaran -->
                <form id="bukaSesiForm">
                    <div class="form-group">
                        <label for="tanggal">Tanggal:</label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                    </div>
                    <div class="form-group">
                        <label for="hari">Hari:</label>
                        <select class="form-control" id="hari" name="hari" required>
                            <option value="">Silahkan Pilih Tanggal</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tahunAjaran">Pilih Kode Tahun Ajaran</label>
                        <select name="tahunAjaran" id="tahunAjaran" class="form-control" required>
                            @foreach($tahunAjaran as $data)
                                <option value="{{ $data->id_ta }}" id="id_ta">{{ $data->kode_ta}}</option>
                            @endforeach
                        </select>
                        @error('id_ta')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="simpanSesiBtn">Simpan</button>
            </div>
        </div>
    </div>
</div>

{{-- Modal Edit Data --}}
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Edit Sesi </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="id_sesi">
                <form id="updateSesiForm">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="tanggal">Tanggal:</label>
                        <input type="date" class="form-control" id="tanggal_edit" name="tanggal_edit" required>
                    </div>
                    <div class="form-group">
                        <label for="hari_edit">Hari:</label>
                        <select class="form-control" id="hari_edit" name="hari_edit" required>
                            <option value="">Silahkan Pilih Tanggal</option>
                        </select>
                    </div>                    
                    <div class="form-group">
                        <label for="tahunAjaran">Pilih Kode Tahun Ajaran</label>
                        <select name="tahunAjaran" id="tahunAjaran_Edit" class="form-control" required>
                            @foreach($tahunAjaran as $data)
                                <option value="{{ $data->id_ta }}" id="id_ta">{{ $data->kode_ta}}</option>
                            @endforeach
                        </select>
                        @error('id_ta')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="simpanSesiEditBtn">Simpan</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Function untuk dropdown hari bedasarkan tanggal --Strat
    function getDayName(dateString) {
        var days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        var date = new Date(dateString);
        var dayIndex = date.getDay();
        return days[dayIndex];
        }
    // Function untuk dropdown hari bedasarkan tanggal --End

        // Function untuk memeriksa apakah tanggal yang sama sudah ada di database --Start
        function cekTanggalSama(tanggal) {
        console.log("Tanggal yang dipilih : ", tanggal);
        var result = false; // Defaultnya, tanggal belum ada
        
        $.ajax({
            url: '{{ route("cekTanggal") }}',
            type: 'POST',
            async: false, // Membuatnya menjadi synchronous agar  bisa menunggu hasil kembalian
            data: {
                tanggal: tanggal,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                result = response.exists; // Menggunakan hasil dari server
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    
        return result;
        }
    // Function untuk memeriksa apakah tanggal yang sama sudah ada di database --End
    

    // function setStatus sekaligus set css nya --Start
    function setStatus() {
        var currentDate = new Date();
        @foreach($sesi as $key => $sesiItem)
            var rowDate = new Date('{{ $sesiItem->tanggal }}');
            var status = '';
            var statusElement = document.getElementById('status{{ $key + 1 }}');
            if (currentDate.getFullYear() === rowDate.getFullYear() && currentDate.getMonth() === rowDate.getMonth() && currentDate.getDate() === rowDate.getDate()) {
                status = 'Sedang Berlangsung';
                statusElement.classList.add('status-berlangsung');
                statusElement.style.color = '#d8f3e7'; 
                statusElement.style.backgroundColor = ' #00b267'; 
            } else if (currentDate > rowDate) {
                status = 'Sudah Terlewat';
                statusElement.classList.add('status-terlewat');
                statusElement.style.color = '#f75864'; 
                statusElement.style.backgroundColor = '#ffe2e5'; 
            } else {
                status = 'Belum Dimulai';
                statusElement.classList.add('status-belum');
                statusElement.style.color = '#00246B'; 
                statusElement.style.backgroundColor = '#CADCFC'; 
            }
            statusElement.innerText = 'Sesi '+ status;
            @endforeach
    }
    document.addEventListener('DOMContentLoaded', setStatus);
// function setStatus sekaligus set css nya --End
    
        
// Jquery untuk mengisi modal edit --Start 
$('body').on('click', '#editBarisButton', function() {
    var id_sesi = $(this).data('id_sesi');
    var tanggal = $(this).data('tanggal');
    var hari = getDayName(tanggal);
    var id_ta = $(this).data('id_ta');
    
    document.getElementById("tanggal_edit").value = tanggal;
    
    // Ambil elemen lalu isi ddatanya
    var hariEditDropdown = document.getElementById("hari_edit");
    // Setelah di ambil lalu di kosongin 
    hariEditDropdown.innerHTML = ''; // Kosongkan dropdown
    
    var option = document.createElement('option');
    option.text = hari;
    option.value = hari;
    hariEditDropdown.add(option);

    document.getElementById("id_ta").value = id_ta;
    document.getElementById("id_sesi").value = id_sesi;
    
    console.log("Data Edit : ", hari)
});
// Jquery untuk mengisi modal edit --End 


//Jquery untuk mmengatur hari pada modal tambah data --Start

document.getElementById('tanggal').addEventListener('change', function() {
        var tanggal = this.value;
        var hari = getDayName(tanggal);
        document.getElementById('hari').innerHTML = ''; // Kosongkan dropdown hari
        var option = document.createElement('option');
        option.text = hari;
        option.value = hari;
        document.getElementById('hari').add(option);
    });


    //Jquery untuk mmengatur hari pada tambah data --End

    // Untuk mengatur hari pada modal edit --Start

 document.getElementById('tanggal_edit').addEventListener('change', function() {
    var tanggal = this.value;
    var hari = getDayName(tanggal);
    document.getElementById('hari_edit').innerHTML = ''; 
    var option = document.createElement('option');
    option.text = hari;
    option.value = hari;
    document.getElementById('hari_edit').add(option);
});
    // Untuk mengatur hari pada modal edit --End

    // Ajax Simpan data aka Store --Start
    $('#simpanSesiBtn').click(function() {
        var tanggal = $('#tanggal').val();
        var hari = $('#hari').val();
        // var tahunAjaran = $('#tahunAjaran').val();
        var id_ta = $('#id_ta').val();

        console.log("ID TA = ", id_ta)
        
        // Memeriksa apakah tanggal yang sama sudah ada
        if (cekTanggalSama(tanggal)) {
            alert('Tanggal sudah digunakan. Silahkan Pilih tanggal lain.');
            return; // Menghentikan eksekusi fungsi jika tanggal sudah digunakan
            }
            
            // Lakukan pengiriman ke server untuk menyimpan sesi pembelajaran
            $.ajax({
                url: '{{ route("simpanSesiPembelajaran") }}',
            type: 'POST',
            data: {
                tanggal: tanggal,
                hari: hari,
                id_ta: id_ta,
                _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    console.log(response);
                    // $('#myModal').modal('hide');
                alert('Sesi Berhasil Ditambahkan');
                location.reload();
                },
                error: function(xhr, status, error) {
                console.error(xhr.responseText);
                }
                });
    });
    // Ajax Simpan data aka Store --End

// Ajax update data ke database --Start
$('#simpanSesiEditBtn').click(function() {
        var id_sesi = $('#id_sesi').val();
        var tanggal_edit = $('#tanggal_edit').val();
        var hari_edit = $('#hari_edit').val();
        var tahunAjaran_edit = $('#tahunAjaran_Edit').val();
        console.log("Id Sesi nya banh : ", id_sesi)

        // if (cekTanggalSama(tanggal_edit)) {
        //     alert('Tanggal yang dipilih sudah ada. Silahkan pilih tanggal lain.');
        //     return;
        // }

        $.ajax({
            // url : '/update-sesi/' + id_sesi, 
            url: '{{route("sesi.update", ":id")}}'.replace(':id', id_sesi), 
            method: 'PUT',
            data: {
                _token: '{{ csrf_token() }}',
                tanggal: tanggal_edit,
                hari: hari_edit,
                id_ta: tahunAjaran_edit
            },
            success: function(response) {
                alert("Data Berhasil Diperbarui");
                location.reload();
            },
            error: function(xhr, status, error) {
                console.error('Terjadi kesalahan:', error);
                alert('Terjadi kesalahan saat menyimpan data sesi.');
            }
        });
    });
// Ajax update data ke database --End

    </script>
@stop
