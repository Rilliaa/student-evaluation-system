@extends('adminlte::page')

@section('title', 'Transisi Tahun Ajaran')

@section('content_header')
    <h1>Transisi Tahun Ajaran</h1>
@stop

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">

    {{-- Halaman ini diatur oleh method transisi di TahunAjaranController --}}
    <div class="row">
        <!-- <div class="col-md-6"> -->
        <div class="col-12">
            <form id="form_tahun_ajaran" method="POST">
                <div class="form-group">
                    <label for="kode_ta_lama">Tahun Ajaran Lama</label><br>
                    <select id="kode_ta_lama" name="kode_ta_lama" class="form-control select2" required style="width:100%;">
                        <option value="" selected disabled>-- Pilih Tahun Ajaran Lama --</option>
                        @foreach($tahunAjaran as $ta)
                            <option value="{{ $ta->id_ta }}">{{ $ta->kode_ta }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="kode_ta_baru">Tahun Ajaran Baru</label>
                    <select id="kode_ta_baru" name="kode_ta_baru" class="form-control select2" required style="width:100%;">
                    <option value="" selected disabled>-- Pilih Tahun Ajaran Lama --</option>
                        @foreach($tahunAjaran as $ta)
                            <option value="{{ $ta->id_ta }}">{{ $ta->kode_ta }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group mt-2">
                    <button type="submit" class="btn btn-primary" id="submitTahunAjaran">
                        Tampilkan Kelas <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <br>

    <div class="row">
        <div class="col-md-12" id="table-content" style="display: none;">
            <table id="kelasTable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kelas Tahun Ajaran Lama</th>
                        <th>Wali Kelas Lama</th>
                        <th>Kelas Tahun Ajaran Baru</th>
                        <th>Wali Kelas Baru</th>
                    </tr>
                </thead>
                <tbody id="kelasTableBody"></tbody>
            </table>
            <button id="konfirmasiTransisi" class="btn btn-success mt-3 mb-3" style="display: none;" onclick="return confirm('Apakah Anda Yakin Ingin Melakukan Transisi?')">
                Konfirmasi Transisi
            </button>
        </div>
    </div>
@endsection


@section('js')
<script>
    $(document).ready(function () {
    
        $('.select2').select2();
        $('#table-content').hide();
        $('#konfirmasiTransisi').hide();

        // Jquery dan ajax untuk mengampilkan seluruh data kelas dari ta lama dan baru --Start
        $('#form_tahun_ajaran').on('submit', function (e) {
            e.preventDefault();  
        
            // Ngambil value id_ta dari form pemilhan kode tahun ajaran lama dan baru --Start
            var id_ta_lama = $('#kode_ta_lama').val();
            var id_ta_baru = $('#kode_ta_baru').val();
            // Ngambil value id_ta dari form pemilhan kode tahun ajaran lama dan baru --End

            if (id_ta_lama && id_ta_baru) {
                $.ajax({
                    url: "{{ route('getKelasLama') }}",
                    type: "POST",
                    data: {
                        kode_ta_lama: id_ta_lama,
                        kode_ta_baru: id_ta_baru,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        var tablebody = $('#kelasTableBody');
                        tablebody.empty(); 

                        if (response.length === 0) {
         
                            $('#table-content').hide();
                            $('#konfirmasiTransisi').hide();
                            alert("Tidak ada data kelas di salah satu tahun ajaran")
                            
                        } else {
                            // Tampilkan data kelas
                            $('#table-content').show(); 
                            $('#konfirmasiTransisi').show(); 
                            response.forEach(function(kelas, index) {
                                var row = `
                                    <tr>
                                        <td>${index + 1}</td>
                                        <td>${kelas.nama_kelas}</td>
                                        <td>${kelas.nama_guru}</td>
                                        <td style="width: 20%;">
                                            <select class="form-control select2-kelas-baru" data-id_kelas="${kelas.id_kelas}" data-index="${index}">
                                            </select>
                                            <input type="hidden" id="id_kelas_baru_${index}" name="id_kelas_baru_${index}" readonly class="form-control mt-2">
                                        </td>
                                        <td>
                                            <input type="text" id="nama_wali_${index}" name="nama_wali_${index}" readonly class="form-control mt-2">
                                        </td>
                                    </tr>`;
                                tablebody.append(row);

                                // Inisialisasi Select2 untuk dropdown kelas baru
                                $('.select2-kelas-baru').each(function() {
                                    var selectElement = $(this);
                                    var idTahunAjaranBaru = $('#kode_ta_baru').val();
                                    selectElement.select2({
                                        placeholder: 'Pilih Kelas',
                                        ajax: {
                                            url: '{{ route("kelas.search", ":id_ta") }}'.replace(':id_ta', idTahunAjaranBaru),
                                            dataType: 'json',
                                            width: '100%',
                                            delay: 250,
                                            cache: false,
                                            processResults: function(data) {
                                                return {
                                                    results: $.map(data, function(item) {
                                                        return {
                                                            id: item.id_kelas, 
                                                            text: item.nama_kelas,  
                                                            wali: item.guru.nama_guru,
                                                        };
                                                    })
                                                };
                                            }
                                        },
                                    });

                                    selectElement.on('select2:select', function(e) {
                                        var index = $(this).data('index');
                                        var selectedKelasId = e.params.data.id;
                                        var nama_wali_kelas = e.params.data.wali;

                                        $('#id_kelas_baru_' + index).val(selectedKelasId);
                                        $('#nama_wali_' + index).val(nama_wali_kelas);
                                    });
                                });
                            });
                        }
                    }
                });

            } else {
                alert("Pilih Tahun Ajaran Lama dan Baru");
            }
        });
        // Jquery dan ajax untuk mengampilkan seluruh data kelas dari ta lama dan baru --End


        // Jquery untuk transisi tahun ajaran --Start
        
        $('#konfirmasiTransisi').on('click', function () {
            var kelasBaru = []; // string kosong untuk meletakkan id_kelas lama dan baru
            

            // prepare data untuk transisi
            $('#kelasTableBody tr').each(function () {
                var idKelasBaru = $(this).find('.select2-kelas-baru').val(); //ngambil id_kelas baru yang saat ini sedang di iterasi
                var idKelasLama = $(this).find('.select2-kelas-baru').data('id_kelas'); //ngambil id_kelas lama dari data-id_kelas bedasarkan row yang di iterasi
                var index = $(this).find('.select2-kelas-baru').data('index');
                
                
                if(idKelasBaru) {
                    kelasBaru.push({ 
                        // dengan method push maka string kosong tadi berisi id_kelas lama dan baru
                        id_kelas_lama: idKelasLama,
                        id_kelas_baru: idKelasBaru
                    });
                }
            });

            // cek string apakah lebih dari 0
            if (kelasBaru.length > 0) {
                $.ajax({
                    url: "{{ route('prosesTransisi') }}",
                    type: "POST",
                    data: {
                        kelasBaru: kelasBaru,
                        kode_ta_lama: $('#kode_ta_lama').val(),
                        kode_ta_baru: $('#kode_ta_baru').val(),
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        alert(response.message);
                        location.reload();
                    }
                });
            } else {
                alert("Pilih setidaknya satu kelas baru untuk melanjutkan.");
            }
        });
        // Jquery untuk transisi tahun ajaran --End


     
    });
</script>
@stop


