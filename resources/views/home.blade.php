@extends('adminlte::page')

@section('title', 'Dashboard Admin')

@section('content_header')
    <h1 class="m-0 text-dark d-flex justify-content-between">Selamat Datang Di Dashboard Admin!</h1>
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


.container {
    margin-bottom: 0;
    padding-bottom: 0;
}

</style>


<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body d-flex justify-content-between">
                <div>
                    <p class="mr-auto">Selamat Datang, <strong style="color: #ff9e2a;">{{ Auth::user()->name }}</strong></p>
                    <span>Sekarang Tanggal, <strong><i>{{ $tglskrng }}</i></strong>. Semoga Anda memiliki hari yang produktif dan Selamat Bekerja!</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    @foreach([
        ['route' => 'users.index', 'color' => 'bg-info', 'icon' => 'fas fa-user-cog', 'title' => 'Jumlah Admin', 'value' => $jumlahAdmin . ' admin'],
        ['route' => 'murids.index', 'color' => 'bg-primary', 'icon' => 'fas fa-user-graduate', 'title' => 'Jumlah Murid', 'value' => $jumlahMurid . ' murid'],
        ['route' => 'gurus.index', 'color' => 'bg-warning', 'icon' => 'fas fa-chalkboard-teacher', 'title' => 'Jumlah Guru', 'value' => $jumlahGuru . ' guru'],
        ['route' => 'ortus.index', 'color' => 'bg-danger', 'icon' => 'fas fa-users', 'title' => 'Jumlah Wali Murid', 'value' => $jumlahWali . ' wali murid']
    ] as $card)
    <div class="col-md-6" onclick="window.location='{{ route($card['route']) }}'" style="cursor: pointer;">
        <div class="card {{ $card['color'] }} text-white shadow">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title">{{ $card['title'] }}</h5>
                    <p class="card-text">{{ $card['value'] }}</p>
                </div>
                <i class="{{ $card['icon'] }} fa-3x" style="margin-left: auto;"></i>
            </div>
        </div>
    </div>
    @endforeach
</div>

<div class="row-12 mt-3">
    <div class="card">
        <div class="card-body">
            <a href="{{ route('admin.cek-log') }}">
                <h4 style="font-weight: bold; color: black;">Log Aktivitas User</h4>
            </a>
            <div class="table-responsive mt-3">
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
                                <td>
                                    {{ $log->description }}
                                </td>
                                @php 
                                $datetime = \Carbon\Carbon::parse($log->created_at->format('Y-m-d') . ' ' . $log->time_stamp);
                                @endphp
                                <td style="color:red">
                                    {{-- {{ \Carbon\Carbon::parse($log->time_stamp)->timezone('Asia/Jakarta')->format('Y-m-d H:i:s') }} --}}
                                    {{-- {{ $log->time_stamp }} --}}
                                    {{ $datetime->timezone('Asia/Jakarta')->format('Y-m-d H:i:s') }}
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
</div>

{{ $logs->links() }}
@stop
