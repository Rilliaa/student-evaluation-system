@extends('adminlte::page')
@section('title', 'Kelola Nilai v2')
@section('content_header')
<h1>Halaman Kelola Nilai, 
    <span class="label label-lg label-light-success label-inline" style="font-weight:bold; color: #ff9e2a; border-radius: 5px; padding: 3px 8px; text-align: center;">
            {{$guru->nama_guru}}
    </span>
</h1>
@stop
@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form id="form-awal">
                    <div class="form-group">
                        <label for="kode_ta">Pilih Tahun Ajaran</label><br>
                        <select name="tahunAjaran" id="tahunAjaran" class="form-control" required>
                            <option value="" selected disabled> -- Pilih Kode TA -- </option>
                            @foreach($tahunAjaran as $ta)
                                <option value="{{$ta->id_ta}}">{{ $ta->kode_ta }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="mata_pelajaran">Pilih Mata Pelajaran</label><br>
                        <select name="mapel" id="mapel" class="form-control" required>
                            <option value="" selected disabled> -- Pilih Mapel --</option>
                            @if($guru->mapels->isNotEmpty())
                               @foreach($guru->mapels as $mapel)
                                    <option value="{{$mapel->id_mapel}}">{{$mapel->nama_mapel}}</option>
                                @endforeach
                            @else
                            <option value="" disabled readonly> -- Tidak ada Data Mata Pelajaran yang Di Ampu--</option>
                            @endif
                        </select>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary" type="submit">
                            Submit <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                </form>
                <div class="table table-responsive mt-4" style="display: none" id="tablecontent">
                    <table class="table table-bordered">
                        <thead>
                            <tr style="font-weight : bold; text-align :center">
                                <td >No</td>
                                <td >Nama Murid</td>
                                <td >NISN</td>
                                <td >Kelas</td>
                                <td>Nilai</td>
                                <td style="width:10% ">Aksi</td>
                            </tr>
                        </thead>
                        <tbody id="tablebody">
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content ">
            <div class="modal-header">
                <h3 class="modal-title" id="myModalLabel"><strong>Tambah Nilai</strong></h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="tambah-Nilai-form">
                    @csrf
                    <input type="hidden" id="id_murid_modal" value="">
                    <input type="hidden" id="id_ta_modal" value="">
                    <div class="form-group">
                        <label for="nama_murid">Nama Murid:</label> 
                        <input type="text" class="form-control" id="nama_murid_modal" name="nama_murid_modal" readonly required >
                    </div>  
                    <div class="form-group">
                        <label for="nama_kelas">Kelas:</label> 
                        <input type="text" class="form-control" id="nama_kelas_modal" name="nama_kelas_modal" readonly required >
                    </div>
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
                        <input type="number" class="form-control" id="nilai_modal" name="nilai_modal" required placeholder="0-100" min="0" max="100">
                    </div>         
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="saveBtn"data-dismiss="modal">Tambah Nilai</button>
            </div>
        </div>
    </div>
</div>
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
                    <input type="hidden" id="id_murid_edit" value="">
                    <input type="hidden" id="id_ta_edit" value="">
                    <input type="hidden" id="id_nilai_edit" value="">
                    <div class="form-group">
                        <label for="nama_murid">Nama Murid:</label> 
                        <input type="text" class="form-control" id="nama_murid_edit" name="nama_murid_edit" readonly required >
                    </div>  
                    <div class="form-group">
                        <label for="nama_kelas">Kelas:</label> 
                        <input type="text" class="form-control" id="nama_kelas_edit" name="nama_kelas_edit" readonly required >
                    </div>
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
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="editBtn"data-dismiss="modal">Simpan Perubahan</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
$(document).ready(function(){

    $('#form-awal').on('submit',function(e){
        e.preventDefault();

        var id_ta = $('#tahunAjaran').val();
        var id_mapel = $('#mapel').val();
        var nama_mapel = $('#mapel :selected').text();
        var id_guru = {{$guru->id_guru}};

        $.ajax({
            url: '{{ route("modul.getdata") }}',
            type: 'GET',
            data: {
                _method:'GET',
                id_mapel: id_mapel,
                id_guru: id_guru, 
                id_ta: id_ta
            },
            success: function(response) {
                $('#tablecontent').show();
                $('#tablebody').empty(); 

                if(response.murid.length === 0){
                    var row = `
                        <tr>
                            <td colspan="6" style="text-align: center">
                                <span class="label label-lg label-light-danger label-inline" style="color: #f64e60;background-color: #ffe2e5; border-radius: 5px; padding: 3px 8px; text-align: center;">Tidak Ada Data Jadwal</span>
                            </td>
                        </tr>
                    `;
                    $('#tablebody').append(row);
                } else {
                    response.murid.forEach(function(item, index) {
                        var nilai = response.nilai_murid.find(n => n.id_murid === item.id_murid);
                        var kode_mapel = response.mapel.kode_mapel;
                        var actionBtn = nilai 
                            ? `<button class="btn btn-success btn-sm" data-target="#editModal" data-toggle="modal" onclick="setEditModal(${item.id_murid}, '${item.nama_murid}', ${nilai.nilai}, ${id_ta}, ${nilai.id_nilai},${kode_mapel}, '${item.kelas.nama_kelas}')">
                                <i class="fas fa-edit"></i> Edit Nilai
                            </button>`
                            : `<button class="btn btn-primary btn-sm" data-target="#myModal" data-toggle="modal" onclick="setTambahModal(${item.id_murid}, '${item.nama_murid}', ${id_ta},${kode_mapel}, '${item.kelas.nama_kelas}' )">
                                <i class="fas fa-plus"></i> Tambah Nilai
                            </button>`;
                        var span = `<span class="label label-lg label-light-danger label-inline" style="color: #f64e60;background-color: #ffe2e5; border-radius: 5px; padding: 3px 8px; text-align: center;">Belum Ditentukan</span>`;
                        var row = `
                            <tr>
                                <td style="text-align:center">${index + 1}</td>
                                <td>${item.nama_murid}</td>
                                <td>${item.nisn}</td>
                                <td style="text-align:center">${item.kelas.nama_kelas}</td>
                                <td style="text-align:center">${nilai ? nilai.nilai : span}</td>
                                <td>${actionBtn}</td>
                            </tr>
                        `;
                        $('#tablebody').append(row);
                    });
                }
            },
                error: function(xhr) {
                    console.error(xhr.responseText);
                }
        });
    });
    
// ajax untuk tambah data --Start
    $('#saveBtn').click(function() {
        var id_mapel = $('#id_mapel_modal').val();
        var id_murid = $('#id_murid_modal').val();
        var nilai = $('#nilai_modal').val();
        var id_ta = $('#id_ta_modal').val();

        $.ajax({
            url: '{{ route("nilai.store-data") }}',
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

       // Ajax untuk UPDATE data --Start
    $('#editBtn').click(function() {
        var id_mapel = $('#id_mapel_edit').val();
        var id_murid = $('#id_murid_edit').val();
        var id_nilai = $('#id_nilai_edit').val();
        var nilai = $('#nilai_edit').val();
        var id_ta = $('#id_ta_edit').val();

        $.ajax({
            url: '{{ route("nilai.update-data",":id_nilai") }}'.replace(":id_nilai",id_nilai),
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
function setTambahModal(id_murid, nama_murid,id_ta,kode_mapel,nama_kelas) {
    $('#id_murid_modal').val(id_murid);
    $('#id_ta_modal').val(id_ta);
    $('#nama_murid_modal').val(nama_murid);
    $('#nama_kelas_modal').val(nama_kelas);
    $('#kode_mapel_modal').val(kode_mapel);
    $('#id_mapel_modal').val($('#mapel').val());
    $('#nama_mapel_modal').val($('#mapel :selected').text());
    $('#id_mapel_modal').val($('#mapel').val());
    $('#nilai_modal').val('');  
}

function setEditModal(id_murid, nama_murid, nilai,id_ta,id_nilai,kode_mapel,nama_kelas) {
    $('#nama_murid_edit').val(nama_murid);
    $('#nama_kelas_edit').val(nama_kelas);
    $('#id_murid_edit').val(id_murid);
    $('#id_ta_edit').val(id_ta);
    $('#id_nilai_edit').val(id_nilai);
    $('#nama_mapel_edit').val($('#mapel :selected').text());
    $('#id_mapel_edit').val($('#mapel').val());
    $('#kode_mapel_edit').val(kode_mapel);
    $('#nilai_edit').val(nilai); 
}


</script>
@stop