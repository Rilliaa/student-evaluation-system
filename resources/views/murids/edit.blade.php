@extends('adminlte::page')

@section('title', 'Edit Murid')

@section('content_header')
    <h1 class="m-0 text-dark">Edit Data Murid</h1>
@stop

@section('content')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<meta name="csrf-token" content="{{ csrf_token() }}"/>
    <form action="{{ route('murids.update', $murid) }}" method="post">
        @method('PUT')
        @csrf
        <div class="form-group">
            <label for="exampleInputName">Nama Murid:</label>
            <input type="text" class="form-control @error('nama_murid') is-invalid @enderror" id="exampleInputName" placeholder="Nama lengkap" name="nama_murid" value="{{ old('nama_murid', $murid->nama_murid) }}" required>
            @error('nama_murid')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="tanggal">Tanggal Lahir:</label>
            <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control @error('tanggal_lahir') is-invalid @enderror" placeholder="Tanggal Lahir" value="{{ old('tanggal_lahir', $murid->tanggal_lahir) }}" required>
            @error('tanggal_lahir')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="exampleInputSubject">NISN:</label>
            <input type="text" class="form-control @error('nisn') is-invalid @enderror" id="exampleInputSubject" placeholder="NISN Murid" name="nisn" value="{{ old('nisn', $murid->nisn) }}"required>
            @error('nisn')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="exampleInputSubject">Jenis Kelamin:</label>
            <select name="jenis_kelamin" id="status" class="form-control" required>
                <option value="Laki-Laki" @if(old('jenis_kelamin', $murid->jenis_kelamin) == 'Laki-Laki') selected @endif>Laki-Laki</option>
                <option value="Perempuan" @if(old('jenis_kelamin', $murid->jenis_kelamin) == 'Perempuan') selected @endif>Perempuan</option>
            </select>
            @error('jenis_kelamin')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="tahunAjaran">Pilih Kode Tahun Ajaran</label>
            <select name="id_ta" id="tahunAjaran" class="form-control" required>
                <option value="" disabled selected>-- Pilih Tahun Ajaran --</option>
                @foreach($tahunAjaran as $data)
                    <option value="{{ $data->id_ta }}" @if(old('id_ta', $murid->id_ta) == $data->id_ta) selected @endif>{{ $data->kode_ta }}</option>
                @endforeach
            </select>
            @error('id_ta')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="id_kelas">Pilih Kelas:</label>
            <select class="form-control" id="id_kelas" name="id_kelas" required>
                {{-- <option value="">Pilih tahun ajaran terlebih dahulu</option> --}}
            </select>
        </div>

        
        <div class="form-group">
            <label for="role">Pilih Role</label>
            <select name="role" id="role" class="form-control" required>
                @foreach($roles as $role)
                    <option value="{{ $role->id_roles }}" @if(old('role', $murid->role) == $role->id_roles) selected @endif>{{ $role->nama_roles }}</option>
                @endforeach
            </select>
            @error('role')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('murids.index') }}" class="btn btn-default">Batal</a>
        </div>
    </form>
@endsection

@section('js')
<script>
    $(function () {
        $.ajaxSetup({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
        });
    
        $('#tahunAjaran').on('change', function () {
            let id_ta = $(this).val();
            console.log("Id ta :", id_ta);
    
            $.ajax({
                type: 'POST',
                url: "{{ route('murid.getkelas') }}",
                data: {
                    // _method : 'POST',
                    id_ta: id_ta
                },
                cache: false,
                success: function (response) {
                    console.log('Response dari server:', response);
                    $('#id_kelas').html(response);
                },
                error: function (data) {
                    console.log('Error: ', data);
                },
            })
        });
    });
    </script>
@endsection
