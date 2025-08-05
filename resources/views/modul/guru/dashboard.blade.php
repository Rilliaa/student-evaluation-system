@extends('adminlte::page')
@section('title', 'Dashboard Guru')
@section('content_header')
    <h1 class="m-0 text-dark">Dashboard Guru</h1>
@stop
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body d-flex justify-content-between">
            <div style="background-color: #f0f4f8; padding: 20px; border-radius: 10px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);">
                    <p class="mr-auto" style="font-size: 20px; color: #333; width: 1300px; text-align: justify;" >
                        Selamat Datang, <strong style="color: #ff9e2a;">{{ Auth::user()->nama_guru }}</strong>! 
                    </p>
                </div>
            </div>
        </div>

        <!-- Card Mata Pelajaran -->
        <div class="col-md-12" style="cursor: pointer;" onclick="toggleDropdown()">
            <div id="mainCard" class="card bg-primary text-white shadow" style="height: 100px;">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div style="flex: 4;">
                        <p class="card-title mb-0" style="font-size: 1.5rem; font-weight: bold;">Mata Pelajaran Yang Diampu:</p>
                    </div>
                    <div style="flex: 0; text-align: center;">
                        <p class="mb-0" style="font-size: 3rem; font-weight: bold;">{{ $mapel->count() }}</p>
                    </div>
                    <i class="fas fa-book fa-3x" style="flex: 0.2; text-align: right;"></i>
                </div>
            </div>


            <!-- Dropdown List Mata Pelajaran -->
            <div id="dropdownMapel" class="card" style="display: none; background-color: #f1f1f1; margin-top: -10px;">
                <div class="card-body p-2">
                    <ul class="list-unstyled mb-0">
                        @if($mapel->isNotEmpty())
                            @foreach($mapel as $item)
                                <li class="py-2 px-3 mb-1 bg-light rounded" style="border: 1px solid #ddd;">
                                    <i class="fas fa-book-open text-primary mr-2"></i>{{ $item->nama_mapel }}
                                </li>
                            @endforeach
                        @else
                            <li class="text-danger">Belum Ditentukan</li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript untuk menangani dropdown -->
<script>
    function toggleDropdown() {
        const dropdown = document.getElementById('dropdownMapel');
        dropdown.style.display = dropdown.style.display === "none" ? "block" : "none";
    }
</script>
@endsection
