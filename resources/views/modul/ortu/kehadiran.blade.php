@extends('adminlte::page')

@section('title', 'Grafik Murid')

@section('content_header')
<h3 class="m-0 text-dark">
    Rincian Kehadiran | 
    <button class="btn btn-success">{{ $murid->nama_murid }}</button>
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

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
    
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#donutChartModal">
                     <i class="fas fa-chart-pie"></i>   Chart Kehadiran 
                    </button>

                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#lineChartModal">
                        <i class="fas fa-chart-line"></i> Grafik Kehadiran 
                    </button>
                    
                    <div class="kehadiran-tanggal">
                        <form id="formCekKehadiran">
                            <div class="form-group mt-5">
                                <label for="tanggal">Pilih Tanggal</label>
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
                    <table class="table table-hover table-bordered table-stripped mt-5" id="tabel_kehadiran_percentage" style="display : none;">
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
<!-- Modal Donut Chart -->
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
                            <option value="" selected disabled> -- Pilih Tahun Ajaran -- </option>
                            @foreach($tahunAjaran as $ta)
                                <option value="{{ $ta->id_ta }}">{{ $ta->kode_ta }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal">
                            Tutup
                        </button>
                        <button type="submit" class="btn btn-primary">
                        Cek Chart  <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
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
                            <option value="" selected disabled> -- Pilih Tahun Awal -- </option>
                            @foreach($tahunAjaran as $ta)
                                <option value="{{ $ta->id_ta }}">{{ $ta->kode_ta }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="taAkhir">Tahun Ajaran Akhir</label>
                        <select id="taAkhir" name="taAkhir" class="form-control" required>
                            <option value="" selected disabled> -- Pilih Tahun Akhir -- </option>
                            @foreach($tahunAjaran as $ta)
                                <option value="{{ $ta->id_ta }}">{{ $ta->kode_ta }}</option>
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


    // Jquery untuk form donut chart --Start

    $('#formFilterTahunAjaran').on('submit', function(event) {

        // Sembunyikan tabel cek kehadiran per tanggal
        $('#tabel_kehadiran_by_sesi').hide();
        $('#lineChart').hide();
        $('#donutcontainer').hide();
        $('#tabel_kehadiran_percentage').show();

        event.preventDefault();
        $('#donutChartModal').modal('hide');
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
        $('#tabel_kehadiran_by_sesi').hide();
        $('#tabel_kehadiran_percentage').hide();

        
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

            // ngehide tabel, dan chart chart lain yang tidak di butuhkan di tampilan
            $('#tabel_kehadiran_by_sesi').show();
            $('#tabel_kehadiran_percentage').hide();
            $('#donutcontainer').hide();
            $('#lineChart').hide();

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


});

</script>
@endsection
