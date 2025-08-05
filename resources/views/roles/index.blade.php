@extends('adminlte::page')
@section('title', 'List Role')
@section('content_header')
    <h1 class="m-0 text-dark">Daftar Role</h1>
@stop

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <a class="btn btn-primary mb-2 disabled" data-toggle="modal" data-target="#modaltambah" >
                        <i class="fas fa-plus"></i> Tambah
                    </a>
                    <table class="table table-hover table-bordered table-stripped" id="example2">
                        <thead>
                            <tr style="font-weight: bold; text-align: center">
                                <td style="width: 5%">No</td>
                                <td>Nama Role</td>
                                <td style="width: 18%">Aksi</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $key => $role)
                                <tr>
                                    <td style="text-align: center">{{ $loop->iteration }}</td>
                                    <td>{{ $role->nama_roles }}</td>
                                    <td style="text-align: center">
                                        {{-- <button class="btn btn-primary" id="editbtn"
                                                data-toggle="modal"
                                                data-target="#modaledit"
                                                data-id="{{ $role->id_roles }}"
                                                data-nama_role="{{ $role->nama_roles }}">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                        <form action="{{ route('roles.destroy', ['role' => $role->id_roles]) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                <i class="fas fa-trash"></i> Delete
                                            </button> --}}
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Tambah --}}
<!-- Modal Tambah -->
<div class="modal fade" id="modaltambah" tabindex="-1" role="dialog" aria-labelledby="modaltambah" aria-hidden="true">
    <!-- <div class="modal-dialog modal-dialog-centered" role="document"> -->
    <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modaltambah">Tambah Role</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_tambah">
                    @csrf
                    <div class="form-group">
                        <label for="nama_roles">Nama Roles:</label>
                        <input type="text" id="nama_roles" name="nama_roles" class="form-control" placeholder="Admin/Guru/Murid/Wali Murid">
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal">
                            Kembali
                        </button>
                        <button class="btn btn-primary" type="submit">
                           Simpan Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="modaledit" tabindex="-1" role="dialog" aria-labelledby="modaledit" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modaledit">Edit Role</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editform">
                    <input type="hidden" class="form-control" id="id_modaledit">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="nama_roles">Nama Roles:</label>
                        <input type="text" class="form-control" id="nama_modaledit">
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal">
                            Kembali
                        </button>
                        <button class="btn btn-primary" type="submit">
                             Simpan Data
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
    $(document).ready(function(){
        // Set CSRF token untuk semua request Ajax
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Tambah Role
        $('#form_tambah').on('submit', function(e){
            e.preventDefault();
            var nama_roles = $('#nama_roles').val();

            $.ajax({
                type: 'POST',
                url: "{{ route('roles.store') }}",
                data: {
                    nama_roles: nama_roles
                },
                success: function(response){
                    alert("Berhasil menambah data");
                    location.reload();
                },
                error: function(xhr, error){
                    console.log("Gagal", error);
                }
            });
        });

        // Edit Role - Buka modal dengan data role yang dipilih
        $('body').on('click', '#editbtn', function() {
            var id = $(this).data('id');
            var nama_role = $(this).data('nama_role');
            $('#id_modaledit').val(id);
            $('#nama_modaledit').val(nama_role);
        });

        // Update Role
        $('#editform').on('submit', function(e){
            e.preventDefault();
            var id_roles = $('#id_modaledit').val();
            var nama_roles = $('#nama_modaledit').val();

            $.ajax({
                type: 'POST', 
                url: "{{ route('roles.update', ':id_role') }}".replace(':id_role', id_roles),
                data: {
                    _method: 'PUT', 
                    nama_roles: nama_roles
                },
                success: function(response){
                    alert("Berhasil mengupdate data");
                    location.reload();
                },
                error: function(xhr, error){
                    console.log("Gagal", error);
                }
            });
        });
    });
</script>
@stop
