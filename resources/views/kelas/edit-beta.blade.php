@extends('adminlte::page')
@section('title', 'Edit Kelas')
@section('content_header')
<h1 class="m-0 text-dark">Edit Data Kelas</h1>
@stop
@section('content')
<p>ga pake lagi</p>
    {{-- <form action="{{route('kelas.update', $kelas)}}" method="post">
        @method('PUT')
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                            <div class="form-group">
                                <label for="exampleInputSubject">Nama Kelas:</label>                                           
                                <input type="text" class="form-control @error('nama_kelas') is-invalid @enderror" id="exampleInputSubject" placeholder="Nama Kelas" name="nama_kelas" value="{{  old('nama_kelas', $kelas->nama_kelas) }}">
                                @error('nama_kelas')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="id_guru">Pilih Guru</label>
                                <select name="id_guru" id="id_guru" class="form-control">
                                    @foreach($guru as $g)
                                        <option value="{{ $g->id_guru }}" {{ $kelas->id_guru == $g->id_guru ? 'selected' : '' }}>{{ $g->nama_guru }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <a href="{{ route('kelas.index') }}" class="btn btn-secondary">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
@endsection
