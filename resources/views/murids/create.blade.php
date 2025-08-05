@extends('adminlte::page')
@section('title', 'Tambah Murid')
@section('content_header')
<h1 class="m-0 text-dark">Tambah Data Murid</h1>
@stop
@section('content')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}"/>
    <form action="{{route('murids.store')}}" method="POST">
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                            <div class="form-group">
                                <label for="exampleInputSubject">NISN:</label>
                                <input type="text" class="form-control @error('nisn') is-invalid @enderror" id="exampleInputSubject" placeholder="NISN Murid" name="nisn" value="{{ old('nisn') }}" required>
                                @error('nisn')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputName">Nama Murid:</label>
                                <input type="text" class="form-control @error('nama_murid') is-invalid @enderror" id="exampleInputName" placeholder="Nama lengkap" name="nama_murid" value="{{ old('nama_murid') }}" required>
                                @error('nama_murid')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="tanggal">Tanggal Lahir:</label>
                                <input type="date" name="tanggal_lahir" id="tanggal" class="form-control" required>
                            </div>
        
                            <div class="form-group">
                                <label for="exampleInputSubject">Jenis Kelamin:</label>
                                    <select name="jenis_kelamin" id="status" class="form-control" required>
                                    <option value="Laki-Laki">Laki-Laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                {{-- <input type="text" class="form-control @error('jenis_kelamin') is-invalid @enderror" id="exampleInputSubject" placeholder="Laki laki / Perempuan" name="jenis_kelamin" value="{{ old('jenis_kelamin') }}"> --}}
                                @error('jenis_kelamin')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                    </select>
                            </div> 
                            <div class="form-group">
                                <label for="tahunAjaran">Pilih Kode Tahun Ajaran</label>
                                <select name="id_ta" id="tahunAjaran" class="form-control" required>
                                <option value="" disabled selected>-- Pilih Tahun Ajaran --</option>
                                    @foreach($tahunAjaran as $data)
                                        <option value="{{ $data->id_ta }}">{{ $data->kode_ta}}</option>
                                    @endforeach
                                </select>
                                @error('id_ta')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            {{-- <div class="form-group">
                                <label for="id_kelas">Pilih Kelas</label>
                                <select name="id_kelas" id="id_kelas" class="form-control">
                                    @foreach($kelas as $kelas)
                                        <option value="{{ $kelas->id_kelas }}">{{ $kelas->nama_kelas }}</option>
                                    @endforeach
                                </select>
                            </div> --}}
                            <div class="form-group">
                                <label for="id_kelas">Pilih Kelas:</label>
                                <select class="form-control" id="id_kelas" name="id_kelas" required>
                                    {{-- <option value="">Pilih tahun ajaran terlebih dahulu</option> --}}
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="role">Pilih Role</label>
                                <select name="role" id="role" class="form-control" required>
                                    <option value="" selected disabled>-- Pilih Role --</option>
                                    @foreach($roles as $role)
                                    <option value="{{ $role->id_roles    }}">{{ $role->nama_roles }}</option>
                                    @endforeach
                                </select>
                            </div>
                           
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <a href="{{ route('murids.index') }}" class="btn btn-secondary">Batal</a>
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
                // url: '/murid-getkelas',
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