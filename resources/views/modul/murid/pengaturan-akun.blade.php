@extends('adminlte::page')

@section('title', 'Pengaturan Akun')

@section('content_header')
    <h1>Pengaturan Akun</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Pengaturan Akun</h2>
        </div>
        <div class="card-body">
            <form>
                <div class="form-group">
                    <label for="name">Nama</label>
                    <input type="text" class="form-control" id="nama_murod" value="{{ $user->nama_murid }}" readonly>
                </div>
                <div class="form-group">
                    <label for="email">NISN</label>
                    <input type="email" class="form-control" id="nisn" value="{{ $user->nisn }}" readonly>
                </div>
                <div class="form-group">
                    <label for="no_hp">Tanggal Lahir</label>
                    <input type="text" class="form-control" id="tanggal_lahir" value="{{ $user->tanggal_lahir}}" readonly>
                </div>
                <div class="form-group">
                    <label for="no_hp">Jenis Kelamin</label>
                    <input type="text" class="form-control" id="jenis_kelamin" value="{{ $user->jenis_kelamin}}" readonly>
                </div>
                <div class="form-group">
                    <label for="role">Role</label>
                    <input type="text" class="form-control" id="role" value="{{ $user->roles->nama_roles }}" readonly>
                </div>
                <div class="form-group">
                    <button type="button" class="btn btn-primary mt-4" data-toggle="modal" data-target="#changePasswordModal">
                      <i class="fas fa-edit"></i>  Update Data
                    </button>
                </div>
            </form>
            
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changePasswordModalLabel">Edit Password</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="changePasswordForm">
                        @csrf
                        <div class="form-group">
                            <label for="name">Nama</label>
                            <input type="text" class="form-control" id="nama_murid" name="nama_murid" value="{{ $user->nama_murid }}" readonly required>
                        </div>
                        <div class="form-group">
                            <label for="nisn">NISN</label>
                            <input type="text" class="form-control" id="nisn" name="nisn" value="{{ $user->nisn }}" readonly required>
                        </div>
                        <div class="form-group">
                            <label for="current_password">Password Lama</label>
                            <input type="password" class="form-control" id="current_password" name="current_password" required>
                        </div>
                        <div class="form-group">
                            <label for="new_password">Password Baru</label>
                            <input type="password" class="form-control" id="new_password" name="new_password" required>
                        </div>
                        {{-- <div class="form-group">
                            <label for="new_password_confirmation">Konfirmasi Password Baru</label>
                            <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required>
                        </div> --}}
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal">
                            Tutup
                        </button>
                        <button type="submit" class="btn btn-primary">
                            Ubah Password <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                    </form>
                    
                </div>
                
            </div>
        </div>
    </div>
@stop

@section('js')
<script>
    $(document).ready(function() {
        $('#changePasswordForm').on('submit', function(event) {
            event.preventDefault();
            $.ajax({
                url: "{{ route('modul.murid.password.update') }}",
                method: "POST",
                data: $(this).serialize(),
                success: function(response) {
                    if (response.success) {
                        alert(response.message);
                        $('#changePasswordModal').modal('hide');
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
