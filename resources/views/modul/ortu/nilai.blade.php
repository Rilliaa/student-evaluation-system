@extends('adminlte::page')
@section('title', 'Wali Murid | Rincian Nilai ')
@section('content_header')
    <h3 class="m-0 text-dark">
        Halaman Detail Nilai |
        <button class="btn btn-success">{{ $murid->nama_murid }}</button>
        <strong class="ml-2"></strong>

    </h3>
    <div class="d-flex justify-content-between mt-2">
        <div>
            <h3 class="d-inline-block"></h3>
        </div>
        <div>
            <h3 class="d-inline-block">
                Tahun Ajaran saat ini : <button class="btn btn-primary">{{$murid->kelas->tahunAjaran->kode_ta}}</button>
            </h3>
        </div>
    </div>
@stop
@section('content')
{{-- Style untuk nilai belum ditentukan --}}
<style>
    .label-danger {
    color: #f64e60;
    background-color: #ffe2e5;
    padding: 5px 8px;
    border-radius: 5px;
    text-align: center
}
</style>

<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

{{-- Halaman ini di atur dalam MuridController/method modul nilai --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
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
                                        <td>Tahun Ajaran</td>
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
                    <div class="btn-nilai">
                        <button class="btn btn-danger" data-target="#modalgrafik" data-toggle="modal">
                            <i class="fas fa-chart-bar"></i> Grafik Nilai
                        </button>
                        <button class="btn btn-success" data-target="#modalnilai" data-toggle="modal">
                            <i class="fas fa-user-graduate"></i> Nilai Per Tahun Ajaran
                        </button>

                    </div>
                                               
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered table-stripped mt-5" id="example2" style="display: none">
                            <thead>
                                <th colspan="4" style="text-align: center">Data Diambil Dari Jadwal Pelajaran <span id="text_value"></span></th>
                                <tr>
                                    <th scope="col" style="text-align: center">No</th>
                                    <th scope="col" style="text-align: center">Nama Mata Pelajaran</th>
                                    <th scope="col" style="text-align: center">Kode Mapel</th>
                                    <th scope="col" style="text-align: center">Nilai</th>
                                </tr>
                            </thead>
                            <tbody id="tablebody">
                            </tbody>
                        </table>
                    </div>
                    <div class="card" id="chartNilai">
                        <div class="card-body">
                            <div id="lineChart" style="height: 350px display:none;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<div class="modal fade" id="modalgrafik" tabindex="-1" aria-labelledby="modalgrafik" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_grafik">Grafik Nilai</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formGrafikNilai" >
                    <div class="form-group">
                        <label for="taAwal">Tahun Ajaran Awal</label>
                        <select id="taAwal" name="taAwal" class="form-control" required>
                            <option value="" selected disabled> -- Pilih Tahun Awal -- </option>
                            @foreach($kode as $ta)
                            <option value="{{$ta->id_ta}}">{{$ta->kode_ta}}</option>
                        @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="taAkhir">Tahun Ajaran Akhir</label>
                        <select id="taAkhir" name="taAkhir" class="form-control" required>
                            <option value="" selected disabled> -- Pilih Tahun Akhir -- </option>
                            @foreach($kode as $ta)
                                <option value="{{$ta->id_ta}}">{{$ta->kode_ta}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal">
                            Tutup
                        </button>
                        <button type="submit" class="btn btn-primary">
                          Cek Grafik <i class="fas fa-arrow-right"></i>  
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalnilai" tabindex="-1" aria-labelledby="modalnilai" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_nilai">Nilai per Tahun Ajaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" id="form_kode_ta">
                    <div class="form-group">
                        <label for="kode_ta">Pilih Tahun Ajaran</label> <br>
                        <select name="" id="kode_ta" class="form-control" required>
                            <option value="" selected disabled> -- Pilih Kode TA -- </option>
                            @foreach($kode as $ta)
                                <option value="{{$ta->id_ta}}">{{$ta->kode_ta}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal">
                            Tutup
                        </button>
                        <button type="submit" class="btn btn-primary">
                            Cek Nilai <i class="fas fa-arrow-right"></i>
                         </button>
                    </div>
                </form> 
            </div>
        </div>
    </div>
</div>




@endsection

@section('js')
<script>
    $(document).ready(function(){
        var lineChart;


    $('#form_kode_ta').on('submit', function(e){
        e.preventDefault();  // Mencegah reload halaman
        var id_ta = $('#kode_ta').val();  // Mengambil nilai tahun ajaran dari form
        var id_murid = {{$murid->id_murid}};  // Mendapatkan ID murid dari server-side rendering
        var tablebody = document.getElementById('tablebody');  // Mendapatkan elemen tbody dari tabel
        var table = document.getElementById('example2');  // Mendapatkan elemen tbody dari tabel
        var kode_ta =  $('#kode_ta option:selected').text();
        $('#text_value').text(kode_ta);
        $('#lineChart').hide();
        
        // Pastikan id_ta ada sebelum request
        if(id_ta) {
            $.ajax({
                url: "{{ route('modul.get.nilai', ['id' => ':id', 'id_murid' => ':id_murid']) }}" 
                        .replace(':id', id_ta)
                        .replace(':id_murid', id_murid), //controller nya di muridcontroller
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id_murid: id_murid,
                    id_ta: id_ta
                },
                success: function(response) {
                    console.log(response);
                    tablebody.innerHTML = '';  

                    if(response.jadwal.length === 0) {
                        tablebody.innerHTML = `<tr><td colspan="4" style="text-align:center;color:#f64e60;">Data Jadwal Tidak Ada Atau Belum Di Buat</td></tr>`;
                    } else {

                        var totalNilai = 0;
                        var qtyNilai = 0;
                        response.jadwal.forEach(function(item, index) {
                            if(item.nilai !== null){
                                totalNilai += parseFloat(item.nilai);
                                qtyNilai++
                            }
                            var row = `
                                <tr>
                                    <td style="text-align: center">${index + 1}</td>
                                    <td>${item.mapel.nama_mapel}</td>
                                    <td>${item.mapel.kode_mapel}</td>
                                    <td style="text-align: center">
                                        ${item.nilai !== null 
                                            ? item.nilai 
                                            : '<span class="label label-danger">Belum ditentukan</span>'
                                        }
                                    </td>
                                </tr>
                            `;
                            tablebody.innerHTML += row;
                        });

                        // var totalNilai = response.jadwal.reduce((sum,item) => sum + (item.nilai ? parseFloat(item.nilai) : 0),0);
                        // var rata = totalNilai / response.jadwal.length;
                        var rata = qtyNilai > 0 ? totalNilai / qtyNilai : 0 ;
                        console.log(rata,totalNilai);


                        var summaryRow = `
                            <tr>
                                <td colspan="3" style="text-align: right;"><strong>Total Nilai:</strong></td>
                                <td style="text-align: center;"><strong>${totalNilai.toFixed(2)}</strong></td>
                            </tr>
                            <tr>
                                <td colspan="3" style="text-align: right;"><strong>Rata-rata:</strong></td>
                                <td style="text-align: center;"><strong>${rata.toFixed(2)}</strong></td>
                            </tr>
                        `;
                        tablebody.innerHTML += summaryRow;
                        table.style.display = '';

                    }
                    $('#modalnilai').modal('hide');
                },
                error: function(xhr, status, error) {
                    alert("Gagal Mengambil Data");
                }
            });
        }
    });

    $('#formGrafikNilai').on('submit', function(event) {
        
        // Menghapus LineChart jika ada --Start
          if (lineChart) {
            lineChart.destroy();
        }
        // Menghapus LineChart jika ada --End

    event.preventDefault();
    $('#example2').hide();

    var taAwal = $('#taAwal').val();
    var taAkhir = $('#taAkhir').val();
    var id_murid = {{ $murid->id_murid }};  // Mendapatkan ID murid

    $.ajax({
        url: "{{ route('murids.grafik-nilai', ['id_murid' => ':id_murid']) }}".replace(':id_murid', id_murid), 
        method: 'GET',
        data: {
            taAwal: taAwal,
            taAkhir: taAkhir
        },
        success: function(response) {
            document.getElementById('lineChart').style.display = 'block';

            // Memetakan kode tahun ajaran dan rata-rata nilai
            var categories = response.length > 0 ? response.map(item => item.kode_ta) : ['No Data'];
            var data = response.length > 0 ? response.map(item => item.rata_nilai) : [0]; // Menggunakan rata-rata nilai

            // Konfigurasi grafik
            var options = {
                chart: {
                    type: 'line',
                    height: 350
                },
                series: [{
                    name: 'Rata-rata Nilai',
                    data: data
                }],
                xaxis: {
                    categories: categories,
                    // tick : cat
                },
                yaxis: {
                    max: 100,  // set max sumbu
                    min: 0,
                    tick: 20,  // untuk interval
                    labels: {
                        formatter: function (val) {
                            return parseFloat(val).toFixed(0);  
                        }
                    },
                    title: {
                        text: 'Rata-rata Nilai'
                    }
                }
            };

            // Render grafik
            var lineChart = new ApexCharts(document.querySelector("#lineChart"), options);
            lineChart.render();
            $('#modalgrafik').modal('hide');
        },
        error: function(xhr, error) {
            console.error('Error:', xhr);
        }
    });
});


});

</script>
@stop
