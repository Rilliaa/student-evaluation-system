@extends('adminlte::page')

@section('title', 'Cek Log Aktivitas')

@section('content_header')
    <h1>Log Aktivitas User</h1>
@stop

@section('content')
<style>
    html, body {
    min-height: 100%;
    margin: 0;
    padding: 0;
    overflow-x: hidden;
}

.pagination {
    margin-bottom: 0;
    padding-bottom: 0;
}

.card {
    margin-bottom: 0;
}

.container {
    margin-bottom: 0;
    padding-bottom: 0;
}

</style>

<div class="col-12">
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered table-striped" id="example2">
                    <thead class="text-center font-weight-bold">
                        <tr>
                            <th>Nama User</th>
                            <th>Role User</th>
                            <th>Aksi User</th>
                            <th>Tabel Yang Dipengaruh</th>
                            {{-- <th>Data Yang Dimanipulasi</th> --}}
                            <th>Deskripsi</th>
                            <th>Time Stamp</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($logs->isNotEmpty())
                        @foreach ($logs as $log)
                            <tr>
                                <td>
                                    {{ $log->actor->name ?? $log->actor->nama_guru ?? 'Unknown' }}
                                </td>
                                <td>
                                    @if (class_basename($log->actor_type) == "User")
                                        Administrator
                                    @else
                                        Guru
                                    @endif
                                </td>
                                <td>
                                @if (ucfirst($log->action) == "Create")
                                    <button class="btn btn-success btn-sm">
                                        {{ ucfirst($log->action) }}
                                    </button>
                                @elseif (ucfirst($log->action) == "Update")
                                    <button class="btn btn-warning btn-sm">
                                        {{ ucfirst($log->action) }}
                                    </button>
                                @elseif (ucfirst($log->action) == "Transisi")
                                    <button class="btn btn-primary btn-sm">
                                        {{ ucfirst($log->action) }}
                                    </button>
                                @else
                                    <button class="btn btn-danger btn-sm">
                                        {{ ucfirst($log->action) }}
                                    </button>
                                @endif
                                
                                </td>
                                <td>
                                    {{ class_basename($log->object_type) }}
                                </td>
                                {{-- <td>
                                    @if ($log->object)
                                        @if ($log->object instanceof \App\Models\Murid)
                                            {{ $log->object->nama_murid ?? 'Tidak Ada Nama' }}
                                        @elseif ($log->object instanceof \App\Models\Guru)
                                            {{ $log->object->nama_guru ?? 'Tidak Ada Nama' }}
                                        @elseif ($log->object instanceof \App\Models\Ortu)
                                            {{ $log->object->nama_ortu ?? 'Tidak Ada Nama' }}
                                        @elseif ($log->object instanceof \App\Models\TahunAjaran)
                                        {{ $log->object->kode_ta ?? 'Tidak Ada Kode' }}

                                        @else 
                                            {{ $log->object->id ?? 'Data Tidak Diketahui' }}
                                        @endif
                                    @else
                                        Data di Hapus
                                    @endif
                                </td> --}}
                                <td>
                                    {{ $log->description }}
                                </td>
                                <td style="color:red">
                                    {{ \Carbon\Carbon::parse($log->time_stamp)->timezone('Asia/Jakarta')->format('Y-m-d H:i:s') }}
                                </td>
                            </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="7" style="text-align: center; font-weight :bold"> -- Tidak Ada Log Aktivitas -- </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {{ $logs->links() }}
</div>
@endsection
