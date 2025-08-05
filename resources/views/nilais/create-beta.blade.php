@extends('adminlte::page')
@section('title', 'Tambah Nilai Siswa')
@section('content_header')
<h1 class="m-0 text-dark">Tambah Nilai Murid</h1>
@stop
@section('content')
    <form action="{{route('nilais.store')}}" method="post">
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="id_murid">Nama Anak:</label>
                            <select name="id_murid" id="id_murid" class="form-control">
                                @foreach($murids as $murid)
                                    <option value="{{ $murid->id_murid }}">{{ $murid->nama_murid }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="id_mapel">Pilih Mapel:</label>
                            <select name="id_mapel" id="id_mapel" class="form-control">
                                @foreach($mapels as $mapel)
                                    <option value="{{ $mapel->id_mapel }}">{{ $mapel->nama_mapel }}</option>
                                @endforeach
                            </select>
                        </div>
                            <div class="form-group">
                                <label for="exampleInputSubject">Nilai:</label>
                                <input type="text" class="form-control @error('nilai') is-invalid @enderror" id="exampleInputSubject" placeholder="Nilai" name="nilai" value="{{ old('nilai') }}">
                                @error('nilai')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div> 
                            <div class="form-group">
                                <label for="semester">Semester:</label>
                                <select name="semester" id="semester" class="form-control">
                                    <option value="10 Ganjil" @if(old('semester') == '10 Ganjil') selected @endif>10 Ganjil</option>
                                    <option value="10 Genap" @if(old('semester') == '10 Genap') selected @endif>10 Genap</option>
                                    <option value="11 Ganjil" @if(old('semester') == '11 Ganjil') selected @endif>11 Ganjil</option>
                                    <option value="11 Genap" @if(old('semester') == '11 Genap') selected @endif>11 Genap</option>
                                    <option value="12 Ganjil" @if(old('semester') == '12 Ganjil') selected @endif>12 Ganjil</option>
                                    <option value="12 Genap" @if(old('semester') == '12 Genap') selected @endif>12 Genap</option>
                                </select>
                                @error('jenis_kelamin')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <a href="{{ route('nilais.index') }}" class="btn btn-secondary">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
