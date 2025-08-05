@extends('adminlte::page')
@section('title', 'Rincian Nilai || Detail Murid')
@section('content_header')
    <h3 class="m-0 text-dark">
        Halaman Kelola Nilai | Detail  Nilai , 
        <span style="font-weight: bold ; color:#ff9e2a">{{ $murid->nama_murid }}</span>
    </h3>
    <div class="d-flex justify-content-between mt-2">
        <div>
            <h3 class="d-inline-block mt-3">
                Kelas, <span style="font-weight: bold ; color:#ff9e2a">{{$kelas->nama_kelas}}</span>
            </h3>
        </div>
        <div>
            <h3 class="d-inline-block mt-3">
                Kode Tahun Ajaran Kelas: <button class="btn btn-primary">{{$tahunAjaran->kode_ta}}</button>
            </h3>
        </div>
    </div>
@stop
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" defer></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
{{-- Halaman ini di atur dalam MuridController/method detail --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3">
                        <a href="{{ url()->previous()}}" class="btn btn-primary"> <i class="fas fa-arrow-left"></i> Kembali</a>
                    </div>
                    <div class="table-responsive">
                        <div id="body">
                            <table border="0" width="100%" cellpadding="0" cellspacing="0" style="border-collapse: collapse;">
                                <tbody>
                                    <tr>
                                        <td>Nama</td>
                                        <td>: {{ $murid->nama_murid }}</td>
                                        <td>Wali Kelas</td>
                                        <td>: {{$murid->kelas->guru->nama_guru}}</td>
                                    </tr>                                                              
                                    <tr>
                                        <td>NISN</td>
                                        <td>: {{ $murid->nisn }}</td>
                                        <td>Wali Murid</td>
                                        <td>:
                                            @if(isset($murid->ortus) && $murid->ortus->isNotEmpty())
                                                {{ $murid->ortus->first()->nama_ortu }}
                                            @else
                                                <i> -</i>
                                            @endif
                                        </td>                                        
                                    </tr>
                                    <tr>
                                        <td>Tahun Ajaran Saat Ini</td>
                                        <td>: {{ $murid->tahunAjaran->kode_ta }}</td>
                                        <td>Tanggal Lahir</td>
                                        <td>: {{$murid->tanggal_lahir}}</td>                                        
                                    </tr>
                                </tbody>
                            </table>
                       </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-hover table-bordered table-stripped">
                        <thead>
                            <th colspan="5" style="text-align: center">Data Diambil Dari Jadwal Pelajaran {{$kelas->nama_kelas}}, {{$tahunAjaran->kode_ta}}</th>
                            <tr style="font-weight: bold">
                                <th>No</th>
                                <th>Nama Mata Pelajaran</th>
                                <th>Kode Mapel</th>
                                <th>Nilai</th>
                                <th style="text-align: center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(empty($jadwalData))
                                <tr>
                                    <td colspan="5" style="text-align: center; color: #f64e60;">Data Jadwal Tidak Ada Atau Belum Di Buat</td>
                                </tr>
                            @else
                                @foreach($jadwalData as $index => $data)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $data['mapel']->nama_mapel }}</td>
                                        <td>{{ $data['mapel']->kode_mapel }}</td>
                                        <td>
                                            @if($data['nilai'] !== null)
                                                {{ $data['nilai'] }}
                                            @else
                                            <span class="label label-lg label-light-danger label-inline" style="color: #f64e60;background-color: #ffe2e5; border-radius: 5px; padding: 3px 8px; text-align: center;">Belum Ditentukan</span>
                                            @endif
                                        </td>
                                        <td style="text-align:center;">
                                            @if($data['nilai'] !== null)
                                            <button id="editNilaiButton" type="button" 
                                            class="btn btn-success btn-sm" 
                                            data-toggle="modal" 
                                            data-target="#editModal" 
                                            data-nama_mapel="{{ $data['mapel']->nama_mapel }}" 
                                            data-id_mapel="{{ $data['mapel']->id_mapel }}" 
                                            data-kode_mapel="{{ $data['mapel']->kode_mapel }}" 
                                            data-id_nilai="{{ $data['id_nilai'] }}"
                                            data-nilai="{{ $data['nilai'] }}" 
                                            data-row="{{ $index+1 }}">
                                            <i class="fa fa-edit"></i> Edit Nilai
                                        </button>
                                    
                                        <form action="{{ route('nilai.destroy', $data['id_nilai']) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                <i class="fas fa-trash"></i> Hapus Nilai
                                            </button>
                                        </form>
                                            @else
                                                <button id="tambahNilaiButton" type="button" 
                                                    class="btn btn-primary btn-sm" 
                                                    data-toggle="modal" 
                                                    data-target="#myModal" 
                                                    data-nama_mapel="{{ $data['mapel']->nama_mapel }}" 
                                                    data-id_mapel="{{ $data['mapel']->id_mapel }}" 
                                                    data-kode_mapel="{{ $data['mapel']->kode_mapel }}" 
                                                    data-row="{{ $index +1  }}">
                                                        <i class="fa fa-plus"></i> Tambah Nilai
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="4" style="text-align: right;"><strong>Total Nilai:</strong></td>
                                    <td style="text-align: center;"><strong>{{ $totalNilai }}</strong></td>
                                </tr>
                                <tr>
                                    <td colspan="4" style="text-align: right;"><strong>Rata-rata:</strong></td>
                                    <td style="text-align: center;"><strong>{{ $rata }}</strong></td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
{{-- Modal Tambah Nilail --}}
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="myModalLabel"><strong>Tambah Nilai</strong></h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="tambah-Nilai-form">
                    @csrf
                    <input type="hidden" id="id_murid_modal" value="{{$murid->id_murid}}">
                    <input type="hidden" id="id_ta_modal" value="{{$tahunAjaran->id_ta}}">
                    <div class="form-group">
                        <label for="nama_kelas">Nama Mapel:</label> 
                        <input type="text" class="form-control" id="nama_mapel_modal" name="nama_mapel_modal" readonly required >
                    </div>  
                    <div class="form-group">
                        <label for="nama_kelas">Kode Mapel:</label>
                        <input type="text" class="form-control" id="kode_mapel_modal" name="kode_mapel_modal" value="" readonly required>
                        <input type="hidden" class="form-control" id="id_mapel_modal" name="id_mapel_modal" readonly>
                    </div>  
                    <div class="form-group">
                        <label for="nama_kelas">Nilai:</label>
                        <input type="number" class="form-control" id="nilai_modal" name="nilai_modal" required>
                    </div>         
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveBtn"data-dismiss="modal">Save Nilai</button>
            </div>
        </div>
    </div>
</div>

{{-- Modal Edit Nilai --}}
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="myModalLabel"><strong>Edit Nilai</strong></h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="Edit-Nilai-form">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="id_murid_edit" value="{{$murid->id_murid}}">
                    <input type="hidden" id="id_ta_edit" value="{{$tahunAjaran->id_ta}}">
                    <input type="hidden" id="id_nilai_edit">
                    <div class="form-group">
                        <label for="nama_kelas">Nama Mapel:</label> 
                        <input type="text" class="form-control" id="nama_mapel_edit" name="nama_mapel_edit" readonly >
                    </div>  
                    <div class="form-group">
                        <label for="nama_kelas">Kode Mapel:</label>
                        <input type="text" class="form-control" id="kode_mapel_edit" name="kode_mapel_edit" value="" readonly>
                        <input type="hidden" class="form-control" id="id_mapel_edit" name="id_mapel_edit" readonly>
                    </div>  
                    <div class="form-group">
                        <label for="nama_kelas">Nilai:</label>
                        <input type="number" class="form-control" id="nilai_edit" name="nilai_edit">
                    </div>         
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="editBtn"data-dismiss="modal">Save Changes</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
$(document).ready(function() {
 // Jquery untuk mengisi modal Tambah --start
       $('body').on('click', '#tambahNilaiButton', function() {
        let nama_mapel = $(this).data('nama_mapel');
        let kode_mapel = $(this).data('kode_mapel');
        let id_mapel = $(this).data('id_mapel');
        // console.log("ID GURU Sekarang: ", id_guru)

        document.getElementById('nama_mapel_modal').value = nama_mapel;
        document.getElementById('kode_mapel_modal').value = kode_mapel;
        document.getElementById('id_mapel_modal').value = id_mapel;
    });
 
// Jquery untuk mengisi modal Tambah --end


// ajax untuk tambah data --Start
$('#saveBtn').click(function() {
    var id_mapel = $('#id_mapel_modal').val();
    var id_murid = $('#id_murid_modal').val();
        var nilai = $('#nilai_modal').val();
        var id_ta = $('#id_ta_modal').val();
        console.log(
            "ID MAPEL : " ,id_mapel,
            "id_murid : " ,id_murid,
            "nilai : " ,nilai,
            "ID ta : " ,id_ta,

        );
        $.ajax({
            url: '{{ route("nilai.store") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                id_mapel: id_mapel,
                id_murid: id_murid,
                nilai: nilai,
                id_ta: id_ta
            },
            success: function(response) {
                // alert("Berhasil Menyimpan Nilai")
                location.reload();
                console.log(response);
            },
            error: function(xhr, status, error) {
                alert("Gagal Menyimpan Data");
            }
        });
  
    });
    // ajax untuk tambah data --End


     // Jquery untuk mengisi modal Edit --start
 $('body').on('click', '#editNilaiButton', function() {
        let nama_mapel = $(this).data('nama_mapel');
        let kode_mapel = $(this).data('kode_mapel');
        let id_mapel = $(this).data('id_mapel');
        let id_nilai = $(this).data('id_nilai');
        let nilai = $(this).data('nilai');
        // console.log("ID GURU Sekarang: ", id_guru)

        document.getElementById('nama_mapel_edit').value = nama_mapel;
        document.getElementById('kode_mapel_edit').value = kode_mapel;
        document.getElementById('id_mapel_edit').value = id_mapel;
        document.getElementById('id_nilai_edit').value = id_nilai;
        document.getElementById('nilai_edit').value = nilai;
    });
// Jquery untuk mengisi modal Tambah --Edit

    // Ajax untuk UPDATE data --Start
$('#editBtn').click(function() {
    var id_mapel = $('#id_mapel_edit').val();
    var id_murid = $('#id_murid_edit').val();
    var id_nilai = $('#id_nilai_edit').val();
    var nilai = $('#nilai_edit').val();
    var id_ta = $('#id_ta_edit').val();

        console.log(
            "ID MAPEL : " ,id_mapel,
            "id_murid : " ,id_murid,
            "nilai : " ,nilai,
            "ID ta : " ,id_ta,
            "ID Nilai : " ,id_nilai,

        );
        $.ajax({
            url: '{{ route("nilai.update","id_nilai") }}'.replace("id_nilai",id_nilai),
            // method: 'PUT',
            method: 'POST',
            data: {
                _method: 'PUT',
                _token: '{{ csrf_token() }}',
                id_mapel: id_mapel,
                id_murid: id_murid,
                nilai: nilai,
                id_ta: id_ta
            },
            success: function(response) {
                alert("Berhasil Update Nilai")
                location.reload();
                console.log(response);
            },
            error: function(xhr, status, error) {
                alert("Gagal Menyimpan Data");
                console.log(error);
            }
        });
  
    });
    // Ajax untuk UPDATE data --End

});
</script>
@endsection
