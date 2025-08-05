@extends('adminlte::page')
@section('title', 'List Orang Tua')
@section('content_header')

    <!-- <h1 class="m-0 text-dark">Halaman Edit Data Wali Murid : <button class="btn btn-success">{{$ortu->nama_ortu}}</button></h1>
<div class="d-flex justify-content-between mt-2">
    <div>
        <h1 class="d-inline-block mt-3">Halaman Edit Data Wali Murid | <span style="font-weight:bold ; color:#ff9e2a">{{ $ortu->nama_ortu }}</span></h1>
    </div>
    <div>
        <h3 class="d-inline-block mt-3">Nama Anak : <button class="btn btn-info">{{$ortu->murids->nama_murid}}</button></h3>
    </div>
</div> -->
<table>
    <tr>
            <td> <h3>Halaman Edit Data Wali Murid </h3></td>
            <td> <h3>: <button class="btn btn-success"> {{$ortu->nama_ortu}}</button></h3></td> 
    </tr>
    <tr>
            <td> <h3>Nama Anak</h3></td>
            <td> <h3>:  <button class="btn btn-info">{{$ortu->murids->nama_murid}}</button></h3> </td>
    </tr> 
</table>




@stop
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" defer></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">

<form action="{{route('ortus.update',$ortu)}}" method="post">
    @method('PUT')
    @csrf
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label for="exampleInputName">Nama Wali Murid:</label>
                        <input type="text" class="form-control @error('nama_ortu') is-invalid @enderror" id="exampleInputName" placeholder="Nama lengkap" name="nama_ortu" value="{{ old('nama_ortu', $ortu->nama_ortu) }}">
                        @error('nama_ortu')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="tanggal">Tanggal Lahir:</label>
                        <input type="date" name="tanggal_lahir" id="tanggal" class="form-control" value="{{ old('tanggal_lahir', $ortu->tanggal_lahir) }}">
                        @error('tanggal_lahir')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputSubject">Jenis Kelamin:</label>
                            <select name="jenis_kelamin" id="status" class="form-control">
                            <option value="Laki-Laki">Pria</option>
                            <option value="Perempuan">Wanita</option>
                        @error('jenis_kelamin')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                            </select>
                    </div> 
                    <div class="form-group">
                        <label for="exampleInputSubject">Alamat:</label>
                        <input type="text" class="form-control @error('alamat') is-invalid @enderror" id="exampleInputSubject" placeholder="Alamat" name="alamat" value="{{ old('alamat', $ortu->alamat) }}">
                        @error('alamat')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div> 
                    <div class="form-group">
                        <label for="exampleInputSubject">Email:</label>
                        <input type="text" class="form-control @error('email') is-invalid @enderror" id="exampleInputSubject" placeholder="Alamat" name="email" value="{{ $ortu->email ?? '-'}}">
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div> 
                    <div class="form-group">
                        <label for="exampleInputSubject">Nomor Hp:</label>
                        <input type="text" class="form-control @error('no_hp') is-invalid @enderror" id="exampleInputSubject" placeholder="Nomor Hp Wali Murid" name="no_hp" value="{{ old('no_hp', $ortu->no_hp) }}">
                        @error('no_hp')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div> 
                    <div class="form-group">
                        <label for="role">Pilih Role</label>
                        <select name="role" id="role" class="form-control">
                            @foreach($roles as $role)
                                <option value="{{ $role->id_roles }}" @if($role->id_roles == old('role', $ortu->role)) selected @endif>{{ $role->nama_roles }}</option>
                            @endforeach
                        </select>
                        @error('role')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    {{-- <div class="form-group">
                        <label for="id_murid">Nama Anak :</label>
                        <!-- Options for students -->
                        <select name="id_murid" id="id_murid" class="form-control">
                            @foreach($murids as $murid)
                                <option value="{{ $murid->id_murid }}" @if($murid->id_murid == old('id_murid',$ortu->id_murid)) selected @endif>{{ $murid->nama_murid }}</option>
                            @endforeach
                        </select>
                    </div>             --}}
                    <div class="form-group">
                        <label for="nama_murid">Nama Siswa:</label>
                        <select class="form-control" id="nama_siswa_modal" name="nama_siswa_modal" required>
                        </select>
                        <input type="hidden" class="form-control" id="id_murid" name="id_murid" value="{{ old('id_murid', $ortu->id_murid) }}">
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
                            <button type="submit" class="btn btn-primary" onclick="return confirm('Apakah anda yakin mengubah data yang ada ?')">Simpan</button>
                            <a href="{{ route('ortus.index') }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
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
    // Inisialisasi Select2 untuk Nama Siswa
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


    // Event listener saat murid dipilih
    $('#nama_siswa_modal').on('change', function() {
        let selectedValue = $(this).val();
        $('#id_murid').val(selectedValue);
        
        // Ajax request untuk mendapatkan Tahun Ajaran
        $.ajax({
            type: 'POST',
            url: "{{ route('gettahun') }}",
            data: { id_nama: selectedValue },
            cache: false,
            success: function(msg) {
                $('#tahunAjaran').val(msg);
            },
            error: function(data) {
                console.log('error:', data);
            }
        });

        // Ajax request untuk mendapatkan Kelas
        $.ajax({
            type: 'POST',
            url: "{{ route('getkelas') }}",
            data: { id_nama: selectedValue },
            cache: false,
            success: function(msg) {
                $('#kelas_murid').val(msg);
            },
            error: function(data) {
                console.log('error:', data);
            }
        });
    });
});

</script>
@endsection
