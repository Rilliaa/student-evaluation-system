@extends('adminlte::page')
@section('title','Halaman Guru | Kelas Saya')
@section('content_header')
<h1>Halaman Kelas Saya, 
    {{-- <span style="background-color: #c9f7f5; color: #3dc7c4">{{$guru->nama_guru}}</span> --}}
    <span  class="label label-lg label-light-success label-inline" style="font-weight:bold; color: #ff9e2a; border-radius: 5px; padding: 3px 8px; text-align: center;">{{$guru->nama_guru}}</span>
</h1>
@stop
@section('content')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form method="GET" id="formTahunAjaran">
                    <div class="form-group">
                        <label for="tahunAjaran">Silahkan Pilih Kode Tahun Ajaran</label> <br>
                        <select name="kode_ta" id="kode_ta" class="form-control">
                            <option value="" selected disabled>Pilih Kode TA</option>
                                @foreach($tahunAjaran as $ta)
                                    <option value="{{$ta->id_ta}}">{{$ta->kode_ta}}</option>
                                @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary mb-3">
                        Cek Kelas <i class="fas fa-arrow-right"></i>
                    </button>
                </form>
                <div class="table table-responsive" id="table-content" style="display: none">
                    <table class="table table-hover table-bordered mt-5" id="table">
                        <thead style="font-weight:bold">
                            <tr style="text-align: center">
                                <td style="width: 5%">No</td>
                                <td style="width: 60%">Nama Kelas</td>
                                <td style="width: 20% ">Tahun Ajaran</td>
                                <td style="width: 15%">Aksi</td>
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
@endsection

@section('js')
<script>
  $(document).ready(function() {
    $('#formTahunAjaran').on('submit', function(e){
        e.preventDefault();
        var id_ta = $('#kode_ta').val();
        var id_guru = {{ $guru->id_guru }};
        var kode_ta = $('#kode_ta :selected').text();
        console.log(kode_ta);

        $.ajax({
            url: '{{ route("modul.get.kelas") }}',
            type: "GET",
            data: {
                id_ta: id_ta,
                id_guru: id_guru
            },
            success: function(response) {
                console.log(response);

                $('#tablebody').empty(); 

                if (response.message) {
  
                    var row = `
                        <tr>
                            <td colspan="4" style="text-align : center;">
                                <span class="label label-lg label-light-danger label-inline" 
                                    style="color: #f64e60;
                                    background-color: #ffe2e5; 
                                    border-radius: 5px; 
                                    padding: 3px 8px; 
                                    text-align: center;"
                                    >
                                        Tidak ada Data Wali Kelas Untuk Guru Yang Terkait
                                </span>
                            </td>
                        </tr>
                    `;
                    $('#tablebody').append(row);
                } else {
                    var classes = Array.isArray(response) ? response : Object.values(response);
                    classes.forEach(function(item, index) {
                        var url = "{{ route ('modul.daftar-murid',[':id_kelas',':id_guru'])}}".replace(':id_kelas',item.id_kelas).replace(':id_guru',id_guru);
                        var row = `
                            <tr>
                                <td style="text-align:center;">${index + 1}</td>
                                <td>${item.nama_kelas}</td>
                                <td>${kode_ta}</td>
                                <td style="text-align : center">
                                    <a href="${url}" class="btn btn-primary">
                                        <i class="fas fa-eye"></i> Lihat Murid
                                    </a>
                                </td>
                            </tr>
                        `;
                        $('#tablebody').append(row);
                    });
                }

                // Show the table after updating the content
                $('#table-content').show();
            },
            error: function(xhr, error) {
                alert(error);
            }
        });
    });
});

</script>
@stop