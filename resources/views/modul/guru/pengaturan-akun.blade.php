@extends('adminlte::page')
@section('title','Halaman Guru | Pengaturan Akun')
@section('content_header')
<h1> Halaman Pengaturan Akun</h1>
@endsection

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form id="form-akun">
                    <div class="form-group">
                        <label for="nama_guru">Nama Guru: </label><br>
                        <input type="text" class="form-control" value="{{$guru->nama_guru}}" readonly disabled>
                    </div>
                    <div class="form-group">
                        <label for="nip">NIP: </label><br>
                        <input type="text" class="form-control" value="{{$guru->nip}}" readonly disabled>
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat: </label><br>
                        <input type="text" class="form-control" value="{{$guru->alamat}}" readonly disabled>
                    </div>
                    <div class="form-group">
                        <label for="email">Email Guru: </label><br>
                        <input type="text" class="form-control" value="{{$guru->email}}" readonly disabled>
                    </div>
                    <div class="form-group">
                        <label for="email">Role: </label><br>
                        <input type="text" class="form-control" value="{{$guru->roles->nama_roles}}" readonly disabled>
                    </div>
                </form>
                <div class="mb-3 mt-3">
                    <button class="btn btn-primary"  data-toggle="modal" data-target="#modalEdit">
                        <i class="fas fa-edit"></i> Edit Akun
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEdit">Edit Password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formEdit">
                    @csrf
                    <div class="form-group">
                        <label for="nama_guru_label">Nama Guru: </label><br>
                        <input type="text" class="form-control" name="nama_guru" value="{{ $guru->nama_guru }}" disabled>
                        <input type="hidden" class="form-control" name="id_guru" value="{{ $guru->id_guru }}">
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat: </label><br>
                        <input type="text" class="form-control" name="alamat" value="{{ $guru->alamat }}">
                    </div>
                    <div class="form-group">
                        <label for="email">Email Guru: </label><br>
                        <input type="email" class="form-control" name="email" value="{{ $guru->email }}">
                    </div>
                    <div class="form-group">
                        <label for="current_password">Password Lama</label>
                        <input type="password" class="form-control" id="current_password" name="current_password">
                    </div>
                    <div class="form-group">
                        <label for="new_password">Password Baru</label>
                        <input type="password" class="form-control" id="new_password" name="new_password">
                    </div>
                    {{-- <div class="form-group">
                        <label for="new_password_confirmation">Konfirmasi Password Baru</label>
                        <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation">
                    </div> --}}
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal">
                            Tutup
                        </button>
                        <button type="submit" class="btn btn-primary">
                            Simpan Perubahan <i class="fas fa-arrow-right"></i>
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
    $(document).ready(function() {
        $('#formEdit').on('submit', function(event) {
            event.preventDefault();
            $.ajax({
                url: "{{ route('modul.guru.password.update') }}",
                method: "POST",
                data: $(this).serialize(),
                success: function(response) {
                    if (response.success) {
                        alert(response.message);
                        $('#modalEdit').modal('hide');
                        location.reload();
                    } else {
                        alert(response.message);
                    }
                }
            });
        });
    });
</script>
@stop