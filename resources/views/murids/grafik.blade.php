@extends('adminlte::page')

@section('title', 'Grafik Murid')

@section('content_header')
<h3 class="m-0 text-dark">
    Halaman Grafik Murid |  
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
<!-- Halaman ini di atur pada method MuridController / grafikshow -->

@if(session('error'))
    <div class="alert alert-danger text-center fixed-alert">
        {{ session('error') }}
    </div>
@endif

@if(session('success'))
    <div class="alert alert-success text-center fixed-alert">
        {{ session('success') }}
    </div>
@endif
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
{{-- Konten --}}
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="mb-3">
                    <a href="{{ route('murids.index') }}" class="btn btn-info">
                      <i class="fas fa-arrow-left"></i>  Kembali 
                    </a>
                </div>
                {{-- <div class="d-flex flex-wrap justify-content-center my-3"> --}}
                <div class="">
                    <button type="button" class="btn btn-success my-3 mx-2" style="width: 23%"  data-toggle="modal" data-target="#donutChartModal">
                        <i class="fas fa-chart-pie"></i> Chart Kehadiran
                    </button>
                    
                    <button type="button" class="btn btn-danger my-3 mx-2" style="width: 24%"  data-toggle="modal" data-target="#lineChartModal">
                        <i class="fas fa-chart-line"></i> Grafik Kehadiran
                    </button>
                
                    <button type="button" class="btn btn-info my-3 mx-2" style="width: 24%"  data-toggle="modal" data-target="#modalnilai">
                        <i class="fas fa-user-graduate"></i> Nilai Per Tahun Ajaran
                    </button>
                    <button type="button" class="btn btn-secondary my-3 mx-2" style="width: 23%"  data-toggle="modal" data-target="#modalgrafik">
                        <i class="fas fa-chart-bar"></i> Grafik Nilai
                    </button>
                </div>
                              
                    <div class="kehadiran-tanggal">
                        <form id="formCekKehadiran">
                            <div class="form-group mt-2">
                                <label for="tanggal">Cek Kehadiran per Tanggal</label>
                                <input type="date" id="tanggal" name="tanggal" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                Cek Kehadiran <i class="fas fa-check"></i>
                            </button>
                            <div id="alert-container" style="margin-top: 20px;"></div> <!-- Container untuk notifikasi -->
                        </form>
                    </div>

                    
                    <table class="table table-hover table-bordered table-stripped" id="tabel_kehadiran_by_sesi" style="display : none;">
                        <thead>
                            <tr style="text-align: center">
                                <th>Status</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody"> </tbody>
                    </table>
                    <table class="table table-hover table-bordered table-stripped mt-5" id="tabel_kehadiran_percentage" style="display : none; ">
                        <thead>
                            <tr style="text-align: center">
                                <th>Jumlah Hadir</th>
                                <th>Jumlah Mangkir</th>
                                <th>Jumlah Izin</th>
                                <th>Total Sesi Yang Dijalani</th>
                            </tr>
                        </thead>
                        <tbody id="tablePercentage"> </tbody>
                    </table>
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered table-stripped" id="example2" style="display: none">
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

                <div class="chart" id="chartgrafik">
                    <div id="hasil" style="margin-top: 20px display:none;" ></div>
                    <div class="card flex-fill w-100 mt-3" style="display:none" id="donutcontainer">
                        <div class="card-body">
                            {!! $chart->container() !!}
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="lineChart" style="height: 350px display:none;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- KONTEN -END --}}

<!-- Modal  KEHADIRAN --START -->
<div class="modal fade" id="donutChartModal" tabindex="-1" aria-labelledby="donutChartModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="donutChartModalLabel">Chart Kehadiran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formFilterTahunAjaran">
                    <div class="form-group">
                        <label for="tahunAjaran">Pilih Tahun Ajaran</label>
                        <select id="tahunAjaran" name="tahunAjaran" class="form-control" required>
                            <option value="" selected disabled>Pilih Tahun Ajaran</option>
                            @foreach($tahunAjaran as $ta)
                                <option value="{{ $ta->id_ta }}">{{ $ta->kode_ta }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        Cek Diagram <i class="fas fa-arrow-right"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Line Chart -->
<div class="modal fade" id="lineChartModal" tabindex="-1" aria-labelledby="lineChartModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="lineChartModalLabel">Grafik Kehadiran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formFilterTanggal">
                    <div class="form-group">
                        <label for="taAwal">Tahun Ajaran Awal</label>
                        <select id="taAwal" name="taAwal" class="form-control" required>
                            <option value="" selected disabled>Pilih Tahun Awal</option>
                            @foreach($tahunAjaran as $ta)
                                <option value="{{ $ta->id_ta }}">{{ $ta->kode_ta }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="taAkhir">Tahun Ajaran Akhir</label>
                        <select id="taAkhir" name="taAkhir" class="form-control" required>
                            <option value="" selected disabled>Pilih Tahun Akhir</option>
                            @foreach($tahunAjaran as $ta)
                                <option value="{{ $ta->id_ta }}">{{ $ta->kode_ta }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        Cek Grafik <i class="fas fa-arrow-right"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal  KEHADIRAN --END -->

<!-- Modal  Nilai --START -->

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
                <form id="formGrafikNilai" class="">
                    <div class="form-group">
                        <label for="taAwal">Tahun Ajaran Awal</label>
                        <select id="taAwal_nilai" name="taAwal_nilai" class="form-control" required>
                            <option value="" selected disabled>Pilih Tahun Awal</option>
                            @foreach($kode as $ta)
                            <option value="{{$ta->id_ta}}">{{$ta->kode_ta}}</option>
                        @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="taAkhir">Tahun Ajaran Akhir</label>
                        <select id="taAkhir_nilai" name="taAkhir_nilai" class="form-control" required>
                            <option value="" selected disabled>Pilih Tahun Akhir</option>
                            @foreach($kode as $ta)
                                <option value="{{$ta->id_ta}}">{{$ta->kode_ta}}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Cek Grafik</button>
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
                        <label for="kode_ta">Pilih Nilai per Tahun Ajaran</label> <br>
                        <select name="" id="kode_ta" class="form-control" required>
                            <option value="" selected disabled>Pilih Kode TA</option>
                            @foreach($kode as $ta)
                                <option value="{{$ta->id_ta}}">{{$ta->kode_ta}}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        Pilih Nilai Semester <i class="fas fa-arrow-right"></i>
                    </button>
                </form> 
            </div>
        </div>
    </div>
</div>
<!-- Modal  Nilai --END -->
@endsection


@section('js')
{{-- Untuk render donut chart --}}
{{ $chart->script() }}

<script>
$(document).ready(function() {
  
    var chart; 
    var lineChart;

    // Isi default value untuk donut chart --Start
    chart = new ApexCharts(document.querySelector("#{{ $chart->id }}"), {
        chart: {
            type: 'donut',
            height: 350
        },
        series: [0, 0, 0],  
        labels: ['Hadir', 'Izin', 'Mangkir']
    });
    // Isi default value untuk donut chart --End
    chart.render();  // render  untuk default valie


// AJAX DAN JQUERY UNTUK KEHADIRAN --Start


    // Jquery untuk form donut chart --Start
    $('#formFilterTahunAjaran').on('submit', function(event) {
        $('#tabel_kehadiran_by_sesi').hide();
        $('#lineChart').hide();
        $('#example2').hide();
        $('#donutcontainer').hide();
        $('#donutChartModal').modal('hide');
        $('#tabel_kehadiran_percentage').show();
        
        event.preventDefault();
        var id_ta = $('#tahunAjaran').val();
        var id_murid = {{ $murid->id_murid }};  
        var tablePercentage = document.getElementById('tablePercentage');
        tablePercentage.innerHTML = '';

        $.ajax({
            url: "{{ route('murids.grafik-kehadiran', ['id' => ':id', 'id_murid' => ':id_murid']) }}"
                .replace(':id', id_ta)
                .replace(':id_murid', id_murid), //method grafikkehadiran di murid controller
            method: 'GET',
            success: function(response) {

                // Menampilkan display untuk container --Start
                document.getElementById('hasil').style.display = 'block';
                document.getElementById('donutcontainer').style.display = 'block';
                document.getElementById('tabel_kehadiran_percentage').style.display = '';
                // Menampilkan display untuk container --End

                // Menghitung jumlah hadir, izin, mangkir dan total sesi yang telah di jalani --Start
                var hadir = response.kehadiran.jumlah_hadir || 0;
                var izin = response.kehadiran.jumlah_izin || 0;
                var mangkir = response.kehadiran.jumlah_mangkir || 0;
                var total = response.total || 0;
                // Menghitung jumlah hadir, izin, mangkir dan total sesi yang telah di jalani --End

                // Persentase keterangan --Start
                var hadirPercentage = (total !== 0) ? (hadir / total) * 100 : 0;
                var izinPercentage = (total !== 0) ? (izin / total) * 100 : 0;
                var mangkirPercentage = (total !== 0) ? (mangkir / total) * 100 : 0;
                
                let remainingPercentage = 100 - (hadirPercentage + izinPercentage + mangkirPercentage);
                if (remainingPercentage !== 0) {
                    mangkirPercentage += remainingPercentage;
                }
                
                chart.updateSeries([hadirPercentage, izinPercentage, mangkirPercentage]);
                // Persentase keterangan --End

                let row = `
                    <tr style="text-align :center;">
                        <td> ${hadir} (${hadirPercentage.toFixed(2)}%)</td>
                        <td> ${mangkir} (${mangkirPercentage.toFixed(2)}%)</td>
                        <td> ${izin} (${izinPercentage.toFixed(2)}%)</td>
                        <td> ${total}</td>
                    </tr>
                `;
                tablePercentage.innerHTML = row;                       
            },
            error: function(xhr, error) {
                console.error('Error:', xhr);
            }
        });
    });
    // Jquery untuk form donut chart --End


    // Jquery untuk line chart --Start
    
    $('#formFilterTanggal').on('submit', function(event) {
        event.preventDefault();
        $('#donutcontainer').hide();
        $('#lineChart').hide();
        $('#tabel_kehadiran_by_sesi').hide();
        $('#tabel_kehadiran_percentage').hide();
        $('#example2').hide();

        var taAwal = $('#taAwal').val();
        var taAkhir = $('#taAkhir').val();
        var id_murid = {{ $murid->id_murid }};  

        // Menghapus LineChart jika ada --Start
        if (lineChart) {
            lineChart.destroy();
        }
        // Menghapus LineChart jika ada --End

        $.ajax({
            url: "{{ route('murids.grafik-line', ['id_murid' => ':id_murid']) }}".replace(':id_murid', id_murid), //method grafikline di muridcontroller
            method: 'GET',
            data: {
                taAwal: taAwal,
                taAkhir: taAkhir
            },
            success: function(response) {
                document.getElementById('lineChart').style.display = 'block';

                // Mapping untuk kode ta(categories) sebagai sumbu X dan persentase(data) sebagai sumbu y --Start 
                var categories = response.length > 0 ? response.map(item => item.kode_ta) : ['No Data'];
                var data = response.length > 0 ? response.map(item => item.persentase_hadir) : [0];
                // Mapping untuk kode ta(categories) sebagai sumbu X dan persentase(data) sebagai sumbu y --End 

                // Linechart handler --Start
                var options = {
                    chart: {
                        type: 'line',
                        height: 350
                    },
                    series: [{
                        title: {
                            text: 'Tahun Ajaran'
                        },
                        data: data,
                        // name: 'Persentase Kehadiran',
                    }],
                    xaxis: {
                        categories: categories
                    },
                    yaxis: {
                        max: 100,  // set max sumbu
                        min: 0,
                        tick: 20,  // untuk interval
                        labels: {
                            formatter: function (val) {
                                return parseFloat(val).toFixed(0);  //untuk fix bilangan bulat
                            }
                        },
                        title: {
                            text: 'Persentase Kehadiran (%)'
                        }
                    }
                };
                // Linechart handler --End

                // render new chart 
                lineChart = new ApexCharts(document.querySelector("#lineChart"), options);
                lineChart.render();
                $('#lineChartModal').modal('hide');    
            },
            error: function(xhr, error) {
                console.error('Error:', xhr);
            }
        });
    });
    // Jquery untuk line chart --End


    $('#formCekKehadiran').on('submit', function(event) {
            event.preventDefault();
            
            $('#tabel_kehadiran_by_sesi').show();
            $('#tabel_kehadiran_percentage').hide();
            $('#donutcontainer').hide();
            $('#lineChart').hide();
            $('#example2').hide();

            var tanggal = $('#tanggal').val();
            var id_murid = {{ $murid->id_murid }};  
            var tableBody = document.getElementById('tableBody');
            tableBody.innerHTML = '';

        $.ajax({
            url: "{{ route('murids.kehadiranbysesi') }}",
            method: 'GET',
            data: {
                tanggal: tanggal,
                id_murid: id_murid
            },
            success: function(response) {
                document.getElementById('tabel_kehadiran_by_sesi').style.display = '';
                var row = `
                    <tr style="text-align: center;">
                        <td>${response.status}</td>
                        <td>${response.keterangan}</td>
                    </tr>
                `;
                tableBody.innerHTML = row;
            },
            error: function(xhr) {
                if (xhr.status === 404) {
                    // Tampilkan alert di dalam container yang sesuai
                    $('#alert-container').html(`
                        <div class="alert alert-danger text-center">
                            Tanggal Sesi tidak valid
                        </div>
                    `);
                    document.getElementById('tabel_kehadiran_by_sesi').style.display = '';
                    var row = `
                        <tr style="text-align: center;">
                            <td colspan="2">
                            <strong>    Tanggal Sesi Tidak ada Atau Tidak Valid </strong>
                            </td>
                        </tr>
                    `;
                    tableBody.innerHTML = row;

                    // Hilangkan alert setelah 3 detik
                    setTimeout(function() {
                        $('#alert-container .alert').fadeOut('slow', function() {
                            $(this).remove();
                        });
                    }, 3000);
                }

            }
        });

});
// AJAX DAN JQUERY UNTUK KEHADIRAN --END


// AJAX DAN JQUERY UNTUK NILAI --Start

$('#form_kode_ta').on('submit', function(e){
        e.preventDefault();  
        var id_ta = $('#kode_ta').val();  // untuk ngambil id tahun ajaran dari form
        var id_murid = {{$murid->id_murid}};  

        var tablebody = document.getElementById('tablebody');  //dapatein id untuk tabel
        var table = document.getElementById('example2');  

        var kode_ta =  $('#kode_ta option:selected').text(); //text kode ta untuk judul tabel
        $('#text_value').text(kode_ta);
        
        // jika id_ta = true atau tidak null
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
                                            : '<span class="label label-lg label-light-danger label-inline" style="color: #f64e60;background-color: #ffe2e5; border-radius: 5px; padding: 3px 8px; text-align: center;">Belum Ditentukan</span>'
                                        }
                                    </td>
                                </tr>
                            `;
                            tablebody.innerHTML += row;
                        });

                        
                        // var totalNilai = response.jadwal.reduce((sum,item) => sum + (item.nilai ? parsefloat(item.nilai) :0) ,0);
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
                    $('#tabel_kehadiran_by_sesi').hide();
                    $('#lineChart').hide();
                    $('#donutcontainer').hide();
                    $('#donutChartModal').modal('hide');
                    $('#tabel_kehadiran_percentage').hide();
                },
                error: function(xhr, status, error) {
                    alert("Gagal Mengambil Data");
                }
            });
        }
    });

    $('#formGrafikNilai').on('submit', function(event) {
        event.preventDefault();
        $('#example2').hide();

        // Menghapus LineChart jika ada --Start
          if (lineChart) {
            lineChart.destroy();
        }
        // Menghapus LineChart jika ada --End

        var taAwal = $('#taAwal_nilai').val();
        var taAkhir = $('#taAkhir_nilai').val();
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
                var lineChart = new ApexCharts(document.querySelector("#lineChart"), options);
                lineChart.render();
                $('#modalgrafik').modal('hide');
                $('#tabel_kehadiran_by_sesi').hide();
                $('#tabel_kehadiran_percentage').hide();
            },
            error: function(xhr, error) {
                console.error('Error:', xhr);
            }
        });
    });
// AJAX DAN JQUERY UNTUK NILAI --END
});

</script>
@endsection
