@extends('adminlte::page')
@section('title', 'Tambah Data Wali Murid')
@section('content_header')
    <h1 class="m-0 text-dark">Tambah Data Wali Murid</h1>
@stop
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" defer></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">


    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('ortus.store') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputName">Nama Wali Murid:</label>
                            <input type="text" class="form-control @error('nama_ortu') is-invalid @enderror" id="exampleInputName" placeholder="Nama lengkap" name="nama_ortu" required>
                            @error('nama_ortu')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="tanggal_lahir">Tanggal Lahir:</label>
                            <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control" required>
                            @error('tanggal_lahir')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="jenis_kelamin">Jenis Kelamin:</label>
                            <select name="jenis_kelamin" id="jenis_kelamin" class="form-control" required>
                                <option value="Laki-Laki">Laki-Laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                            @error('jenis_kelamin')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat:</label>
                            <input type="text" class="form-control @error('alamat') is-invalid @enderror" id="alamat" placeholder="Alamat" name="alamat" required>
                            @error('alamat')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Email Wali" name="email">
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="no_hp">Nomor Hp:</label>
                            <input type="text" class="form-control @error('no_hp') is-invalid @enderror" id="no_hp" placeholder="Nomor Hp Wali Murid" name="no_hp"  required>
                            @error('no_hp')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="role">Pilih Role:</label>
                            <select name="role" id="role" class="form-control" required>
                                <option value="" selected disabled>Pilih Role</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id_roles }}">{{ $role->nama_roles }}</option>
                                @endforeach
                            </select>
                            @error('role')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        {{-- <div class="form-group">
                            <label for="id_murid">Nama Anak:</label>
                            <select name="id_murid" id="id_murid" class="form-control">
                                @foreach($murids as $murid)
                                    <option value="{{ $murid->id_murid }}">{{ $murid->nama_murid }}</option>
                                @endforeach
                            </select>
                        </div> --}}
                        <div class="form-group">
                            <label for="nama_murid">Nama Siswa:</label>
                            <select class="form-control" id="nama_siswa_modal" name="nama_siswa_modal" required>
                            </select>
                            <input type="hidden" class="form-control" id="id_murid" name="id_murid">
                        </div>
                        <div class="form-group">
                            <label for="nama_murid">Tahun Ajaran:</label>
                            <input type="text" class="form-control" id="tahunAjaran" name="Tahun Ajaran" readonly>
                        </div>
                        <div class="form-group">
                            <label for="nama_kelas">Kelas:</label>
                            <input type="text" class="form-control" id="kelas_murid" name="kelas" readonly>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ route('ortus.index') }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function() {
        $('#nama_siswa_modal').select2({
            placeholder: 'Pilih Nama Siswa',
            ajax: {
                url: '{{ route("murids.search") }}',
                dataType: 'json',
                delay: 250,
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                id: item.id_murid,
                                text: item.nama_murid,
                            };
                        })
                    };
                },
                cache: true
            }
        });

        $('#nama_siswa_modal').on('change', function() {
            let selectedValue = $(this).val();
            $('#id_murid').val(selectedValue);
            console.log("Id Murid yang dipilih adalah :", selectedValue);
            $.ajax({
                type : 'POST',
                url : "{{ route('gettahun') }}",
                data: {id_nama: selectedValue},
                cache: false,
                success : function (msg) {
                    console.log('Sukses Besar : ', msg);
                    $('#tahunAjaran').val(msg);
                },
                error : function(data) {
                    console.log('error: ', data);
                },
            });
        });
        $('#nama_siswa_modal').on('change', function() {
            let selectedValue = $(this).val();
            $('#id_murid').val(selectedValue);
            console.log("Id Murid yang dipilih adalah :", selectedValue);
            $.ajax({
                type : 'POST',
                url : "{{ route('getkelas') }}",
                data: {id_nama: selectedValue},
                cache: false,
                success : function (msg) {
                    console.log('Sukses Besar : ', msg);
                    $('#kelas_murid').val(msg);
                },
                error : function(data) {
                    console.log('error: ', data);
                },
            });
        });
        


    });

</script>
@endsection
