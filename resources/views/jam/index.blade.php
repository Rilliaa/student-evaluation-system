@extends('adminlte::page')
@section('title', 'Jam Pelajaran')
@section('content_header')
    <h1 class="m-0 text-dark">Halaman List Jam Pelajaran</h1>
@stop
@section('content')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <a href="{{ route('jam.create') }}" class="btn btn-primary mb-3">
                <i class="fas fa-plus"></i> Tambah Hari Baru
                </a>
                <table class="table table-hover table-bordered table-stripped" id="example2">
                    <thead>
                        <tr>
                            <th scope="col" rowspan="2" style="text-align: center; vertical-align: middle;">No</th>
                            <th scope="col" rowspan="2" style="text-align: center; vertical-align: middle;">Hari</th>
                            <th scope="col" colspan="5" style="text-align: center;">Tabel Jam Pelajaran</th>
                        </tr>
                        <tr>
                            <th scope="col" style="text-align: center;">Jam Ke</th>
                            <th scope="col" style="text-align: center;">Jam Mulai</th>
                            <th scope="col" style="text-align: center;">Jam Selesai</th>
                            <th scope="col" style="text-align: center;">Keterangan</th>
                            <th scope="col" style="text-align: center; vertical-align: middle;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(!$jamPelajarans->isEmpty())
                            @php $rowIndex = 1; @endphp
                            @foreach ($jamPelajarans as $hari => $jamList)
                                @foreach ($jamList as $index => $jamPelajaran)
                                    <tr id="row_{{ $loop->parent->iteration }}_{{ $loop->iteration }}">
                                        @if ($loop->first)
                                            <td rowspan="{{ $jamList->count() }}">{{ $rowIndex }}</td> {{-- Nomor urut baris --}}
                                            <td rowspan="{{ $jamList->count() }}">{{ $hari }}</td>
                                            @php $rowIndex++; @endphp
                                        @endif
                                        <td>{{ $jamPelajaran->jam_ke }}</td>
                                        <td>{{ $jamPelajaran->jam_mulai }}</td>
                                        <td>{{ $jamPelajaran->jam_selesai }}</td>
                                        <td>{{ $jamPelajaran->keterangan }}</td>
                                        <td style="text-align:center;vertical-align:middle;">
                                            <button id="tambahBarisButton" type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal" data-hari="{{ $jamPelajaran->hari }}" data-row="{{ $loop->parent->iteration }}">
                                                <i class="fa fa-plus"></i> Tambah Jam
                                            </button>
                                            <button id="editBarisButton" type="button" class="btn btn-success btn-sm" data-id_jam="{{ $jamPelajaran->id_jam }}" data-jam_ke="{{ $jamPelajaran->jam_ke }}" data-jam_mulai="{{ $jamPelajaran->jam_mulai }}" data-jam_selesai="{{ $jamPelajaran->jam_selesai }}" data-keterangan="{{ $jamPelajaran->keterangan }}" data-toggle="modal" data-target="#editModal" data-hari="{{ $jamPelajaran->hari }}" data-row="{{ $loop->parent->iteration }}" data-id="{{ $jamPelajaran->id_jam }}">
                                                <i class="fas fa-edit"></i> Edit Jam
                                            </button>
                                            <form action="{{ route('jam.destroy', $jamPelajaran->id_jam) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                    <i class="fas fa-trash"></i> Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7" class="text-center"><strong> Tidak ada data jam pelajaran</strong></td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Modal Tambah --}}
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Tambah Jam</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="tambah-jam-form">
                    
                    <div class="form-group">
                        <label for="hari">Hari</label>
                        <input type="text" class="form-control" id="hari_modal" name="hari_modal" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="jam_ke">Jam Ke:</label>
                        <input type="number" class="form-control" id="jam_ke" placeholder="Masukkan jam ke">
                    </div>
                    <div class="form-group">
                        <label for="jam_mulai">Jam Mulai:</label>
                        <input type="time" class="form-control" id="jam_mulai">
                      
                    </div>
                    <div class="form-group">
                        <label for="jam_selesai">Jam Selesai:</label>
                        <input type="time" class="form-control" id="jam_selesai">
                       
                    </div>
                    <div class="form-group">
                        <label for="keterangan">Keterangan:</label>
                        <input type="text" class="form-control" id="keterangan" placeholder="Masukkan keterangan">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveChangesBtn"data-dismiss="modal">Save changes</button>
            </div>
        </div>
    </div>
</div>
{{-- Modal Edit --}}
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Jam</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if(!$jamPelajarans->isEmpty())
                {{-- <form id="edit-jam-form" method="POST"> --}}
                    
                {{-- <form id="edit-jam-form" action="{{ route('jam.update', ['jam' => jamPelajaran->id_jam]) }}" method="POST"> --}}
                    <form id="edit-jam-form"  method="POST">
                    @csrf
                    @method('PUT') 
                    <input type="hidden" id="id_jam_edit" name="id_jam_edit">
                    <div class="form-group">
                        <label for="hari">Hari</label>
                        <input type="text" class="form-control" id="hari_modal_edit" name="hari_modal_edit" value="" readonly>
                    </div>
                    <div class="form-group">
                        <label for="jam_ke">Jam Ke:</label>
                        <input type="number" class="form-control" id="jam_ke_edit" name="jam_ke_edit" value="" placeholder="Masukkan jam ke">
                        <input type="hidden" class="form-control" id="id_jam_ke" value="">
                    </div>
                    <div class="form-group">
                        <label for="jam_mulai">Jam Mulai:</label>
                        <input type="time" class="form-control" id="jam_mulai_edit" name="jam_mulai_edit" value="">

                    </div>
                    <div class="form-group">
                        <label for="jam_selesai">Jam Selesai:</label>
                        <input type="time" class="form-control" id="jam_selesai_edit" name="jam_selesai_edit" value="">
                    </div>
                    <div class="form-group">
                        <label for="keterangan">Keterangan:</label>
                        <input type="text" class="form-control" id="keterangan_edit" name="keterangan_edit" value="" placeholder="Masukkan keterangan">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="editChangesBtn"data-dismiss="modal">Save changes</button>
                    </div>
                </form>
                @else
                <p>Tidak ada data jam pelajaran untuk diedit.</p>
                @endif
            </div>
        </div>
    </div>
</div>



@endsection

@section('js')
<script>

</script>


<script>
$(document).ready(function() {
    // Fungsi untuk menampilkan modal tambah
    $('#myModal').on('shown.bs.modal', function () {
        $('#jam_ke').focus(); // Fokuskan input "jam_ke"
    });

    // Fungsi untuk menutup modal tambah
    $('#myModal').on('hidden.bs.modal', function () {
        $(this).find('form').trigger('reset'); // Mereset formulir di dalam modal
    });

    // Fungsi untuk menyimpan data baru atau mengupdate data
    $('#saveChangesBtn').click(function() {
        simpan();
    });

    // Fungsi untuk menampilkan modal edit
    $('#editModal').on('shown.bs.modal', function () {
        $('#jam_ke_edit').focus(); // Fokuskan input "jam_ke_edit"
    });

    // Fungsi untuk menutup modal edit
    $('#editModal').on('hidden.bs.modal', function () {
        $(this).find('form').trigger('reset'); // Mereset formulir di dalam modal
    });

    // Fungsi untuk mengedit data
    $('#editChangesBtn').click(function() {
        edit();
    });

    $('body').on('click', '#tambahBarisButton', function() {
    var hari_modal = $(this).data('hari');
    document.getElementById("hari_modal").value = hari_modal;
    });

    $('body').on('click', '#editBarisButton', function() {
        var id_jam = $(this).data('id_jam');
        var hari = $(this).data('hari');
        var jam_ke = $(this).data('jam_ke');
        var jam_mulai = $(this).data('jam_mulai');
        var jam_selesai = $(this).data('jam_selesai');
        var keterangan = $(this).data('keterangan');
        var id_jam_edit = $(this).data('id_jam');

        document.getElementById("id_jam_edit").value = id_jam_edit;
        document.getElementById("id_jam_ke").value = id_jam;
        document.getElementById("hari_modal_edit").value = hari;
        document.getElementById("jam_ke_edit").value = jam_ke;
        document.getElementById("jam_mulai_edit").value = jam_mulai;
        document.getElementById("jam_selesai_edit").value = jam_selesai;
        document.getElementById("keterangan_edit").value = keterangan;
        console.log('id jam: ' + id_jam);
    });

    // Fungsi untuk menyimpan data baru atau mengupdate data
    function simpan(id_jam = '') {
        var var_url = id_jam ? '{{ route("jam.update", ":id") }}' : '{{ route("jam.store") }}';
        var var_type = id_jam ? 'PUT' : 'POST';

        // Jika id_jam tidak kosong, ganti placeholder ":id" dengan ID jam aktual
        if (id_jam) {
            var_url = var_url.replace(':id', id_jam);
        }

        var hari = $('#hari_modal').val();
        var jamKe = $('#jam_ke').val();
        var jamMulai = $('#jam_mulai').val();
        var jamSelesai = $('#jam_selesai').val();
        var keterangan = $('#keterangan').val();
        
        $.ajax({
            url: var_url,
            type: var_type,
            data: {
                jam_ke: jamKe,
                jam_mulai: jamMulai,
                jam_selesai: jamSelesai,
                keterangan: keterangan,
                hari: hari,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                console.log(response);
                $('#myModal').modal('hide'); // Menutup modal setelah data berhasil disimpan
                location.reload();
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }

    // Fungsi untuk mengedit data
    function edit() {
        // Retrieve values from input fields
        var hari = $('#hari_modal_edit').val();
        var jamKe = $('#jam_ke_edit').val();
        var jamMulai = $('#jam_mulai_edit').val();
        var jamSelesai = $('#jam_selesai_edit').val();
        var keterangan = $('#keterangan_edit').val();
        // var actionUrl = $('#edit-jam-form').attr('action');
        var id_jam_edit = $('#id_jam_edit').val();

        action="{{ route('jam.update', ['jam' => $jamPelajaran->id_jam]) }}"        

        // Construct data object with specific fields
        var formData = {
            jam_ke_edit: jamKe,
            jam_mulai_edit: jamMulai,
            jam_selesai_edit: jamSelesai,
            keterangan_edit: keterangan,
            hari_modal_edit: hari,
            _token: '{{ csrf_token() }}',
            _method: 'PUT'
        };

        // Send AJAX request to update data
        $.ajax({
            url: '{{ route("jam.update",[":jam"])}}'.replace(":jam",id_jam_edit),
            type: 'POST',
            data: formData,
            success: function(response) {
                console.log('Sukses MengeditData :',response);
                $('#editModal').modal('hide');
                location.reload();
            },
            error: function(xhr, status, error) {
                console.error('Error nya di :',xhr.responseText);
            }
        });
    }
});
</script>
@stop


