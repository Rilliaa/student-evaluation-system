@extends('adminlte::page')
@section('title', 'Halaman Guru | Lihat Jadwal')
@section('content_header')
<h1>Halaman Lihat Jadwal, 
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
                <form method="POST" id="form_ta">
                    <div class="form-group">
                        <input type="hidden" id="jam_sekarang" value="{{$jamskrng}}">
                        <label for="form_kode_ta">Pilih Kode TA</label> <br>
                        <select name="kode_ta" id="kode_ta" class="form-control" required>
                            <option value="" selected disabled> -- Pilih Kode TA -- </option>
                            @foreach($tahunAjaran as $ta)
                                <option value="{{$ta->id_ta}}">{{$ta->kode_ta}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="form_hari">Pilih Hari:</label> <br>
                        <select name="hari" id="hari" class="form-control" required>
                            <option selected disabled value=""> -- Pilih Hari -- </option>
                            <option value="senin">Senin</option>
                            <option value="selasa">Selasa</option>
                            <option value="rabu">Rabu</option>
                            <option value="kamis">Kamis</option>
                            <option value="jumat">Jumat</option>
                            <option value="sabtu">Sabtu</option>
                            <option value="minggu">Minggu</option>
                        </select>
                    </div>
                    <div class="mb-3 mt-3">
                        <button type="submit" class="btn btn-primary" id="submitBtn">
                            Submit
                        </button>
                    </div>
                </form>
                <div class="table table-responsive">
                    <table class="table table-hover table-bordered mt-5" id="table-kelas" style="display: none;">
                        <thead>  
                            <tr style="text-align: center ; font-weight:bold;">
                                <td>No</td>
                                <td>Kelas</td>
                                <td>Wali Kelas</td>
                                <td>Mapel</td>
                                <td>Waktu</td>
                                <td>Hari</td>
                                <td>Aksi</td>
                            </tr>
                        </thead>
                        <tbody id="table-content">
                            {{-- <td>
                                
                            </td> --}}
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
    $('#form_ta').on('submit', function(e) {
        e.preventDefault();
        let id_ta = $('#kode_ta').val();
        let id_guru = {{$guru->id_guru}};
        let hari = $('#hari').val();
        let jam = $('#jam_sekarang').val();
        $.ajax({
            url: '{{ route("modul.getjadwal") }}',
            method: 'GET',
            data: {
                id_guru: id_guru,
                id_ta: id_ta,
                jam_sekarang: jam,
                hari: hari,
            },
            success: function(response) {
                var tabel = document.getElementById('table-kelas');
                tabel.style.display = 'table'; // Properly display the table
                $('#table-content').empty(); // Clear existing rows to prevent duplicates

                let tes = Array.isArray(response) ? response : Object.values(response);

                // Corrected spelling of 'length'
                if (tes.length === 0) {
                    // Display a message if there are no schedules
                    $('#table-content').html(`
                        <tr style="text-align: center">
                            <td colspan="7" style="text-align:center;color:#f64e60;background-color:#ffe2e5;">
                            Data Jadwal Tidak Ada Atau Belum Di Buat
                            </td>
                        </tr>`);
                } else {
                    // Iterate over each item in the response
                    tes.forEach(function(item, index) {
                        // Convert jam_mulai, jam_selesai, and jam_sekarang to time objects for comparison
                        var jamMulai = new Date('1970-01-01T' + item.jampels.jam_mulai + 'Z');
                        var jamSelesai = new Date('1970-01-01T' + item.jampels.jam_selesai + 'Z');
                        var jamSekarang = new Date('1970-01-01T' + $('#jam_sekarang').val() + 'Z');
                        
                        // Check if current time is within the schedule time range
                        var isActive = jamSekarang >= jamMulai && jamSekarang <= jamSelesai;

                        var buttonClass = isActive ? '' : 'disabled'; // Disable or enable button based on condition
                        var buttonStatus = isActive ? '' : 'disabled'; // Add "disabled" attribute 
                        
                        var id_kelas = item.kelas.id_kelas;

                        var url = "{{ route('modul.kehadiran',[':id_ta',':id_kelas',':id_guru'])}}".replace(':id_ta',id_ta).replace(':id_kelas',id_kelas).replace(':id_guru',id_guru) ;

                        var row = `
                            <tr>
                                <td style ="text-align : center;">${index + 1}</td>
                                <td>${item.kelas.nama_kelas}</td>
                                <td>${item.kelas.guru.nama_guru}</td>
                                <td>${item.mapels.nama_mapel}</td>
                                <td>${item.jampels.jam_mulai} - ${item.jampels.jam_selesai}</td>
                                <td style="text-align : center;">${item.jampels.hari}</td>
                                <td style="text-align : center;">
                                    <a href="${url}" class="btn btn-primary ${buttonClass}" ${buttonStatus}>
                                        Masuk <i class="fas fa-arrow-right"></i>
                                    </a>
                                </td>
                            </tr>
                        `;
                        $('#table-content').append(row); // Append the row to the table
                    });
                }
            },

            error: function(xhr, error) {
                alert('Error: ' + error); // Display error alert
            }

        });
    });
});
</script>
@stop
