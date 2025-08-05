@extends('adminlte::page')

@section('title', 'Pengaturan Akun')

@section('content_header')
    <h1>Pengaturan Akun</h1>
@stop

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Pengaturan Akun</h2>
            </div>
            <div class="card-body">
                <form>
                    <div class="form-group">
                        <label for="nama_ortu">Nama</label>
                        <input type="text" class="form-control" id="nama_ortu" value="{{ $user->nama_ortu }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="nisn_murid">NISN Anak</label>
                        <input type="text" class="form-control" id="nisn_murid" value="{{ $user->murids->nisn }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="tanggal_lahir">Tanggal Lahir</label>
                        <input type="text" class="form-control" id="tanggal_lahir" value="{{ $user->tanggal_lahir }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <input type="text" class="form-control" id="alamat" value="{{ $user->alamat }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="no_hp">No. HP</label>
                        <input type="text" class="form-control" id="no_hp" value="{{ $user->no_hp }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="jenis_kelamin">Jenis Kelamin</label>
                        <input type="text" class="form-control" id="jenis_kelamin" value="{{ $user->jenis_kelamin }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="role">Role</label>
                        <input type="text" class="form-control" id="role" value="{{ $user->roles->nama_roles }}" readonly>
                    </div>
                    <div class="form-group">
                        <button type="button" class="btn btn-primary mt-4" data-toggle="modal" data-target="#changePasswordModal">
                            <i class="fas fa-edit"></i> Update Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
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
                            <label for="nama_ortu">Nama</label>
                            <input type="text" class="form-control" id="nama_ortu" name="nama_ortu" value="{{ $user->nama_ortu }}">
                        </div>
                        <!-- <div class="form-group">
                            <label for="nisn_murid">NISN Anak</label>
                            <input type="text" class="form-control" id="nisn_murid" name="nisn_murid" value="{{ $user->murids->nisn }}" readonly>
                        </div> -->
                        <div class="form-group">
                            <label for="tanggal_lahir">Tanggal Lahir</label>
                            <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="{{ $user->tanggal_lahir }}">
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <input type="text" class="form-control" id="alamat" name="alamat" value="{{ $user->alamat }}">
                        </div>
                        <div class="form-group">
                            <label for="no_hp">No. HP</label>
                            <input type="text" class="form-control" id="no_hp" name="no_hp" value="{{ $user->no_hp }}">
                        </div>
                        <div class="form-group">
                            <label for="jenis_kelamin">Jenis Kelamin</label>
                            <select name="jenis_kelamin" id="jenis_kelamin" name="jenis_kelamin" class="form-control">
                                <option value="Laki-Laki" {{ $user->jenis_kelamin == 'Laki-Laki' ? 'selected' : '' }}>Laki-Laki</option>
                                <option value="Perempuan" {{ $user->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                        <!-- <div class="form-group">
                            <label for="role">Role</label>
                            <input type="text" class="form-control" id="role" name="jenis_kelamin" value="{{ $user->roles->nama_roles }}" readonly>
                        </div> -->
                        <div class="form-group">
                            <label for="current_password">Password Lama</label>
                            <input type="password" class="form-control" id="current_password" name="current_password" required>
                        </div>
                        <div class="form-group">
                            <label for="new_password">Password Baru</label>
                            <input type="password" class="form-control" id="new_password" name="new_password" required>
                        </div>
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
                url: "{{ route('modul.wali-murid.password.update') }}",
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
