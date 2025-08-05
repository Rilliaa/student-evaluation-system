@extends('adminlte::page')
@section('title', 'List Admin')
@section('content_header')
    <h1 class="m-0 text-dark">Daftar Admin</h1>
@stop
@section('content')
@if (session('success_message'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success_message') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (session('error_message'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error_message') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <a href="{{route('users.create')}}" class="btn btn-primary mb-2">
                    <i class="fas fa-plus"></i>    Tambah
                    </a>
                    {{-- <table class="table table-hover table-bordered table-stripped" id="example2"> --}}
                    <table class="table table-hover table-bordered table-stripped" id="example2"> 
                        <thead>
                        <tr style="text-align : center">
                            <th>No.</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Nomor Hp</th>
                            <th>Role</th>
                            <th>Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $key => $user)
                            <tr>
                                <td style="text-align : center">{{$loop->iteration}}</td>
                                <td>{{$user->name}}</td>
                                <td>{{$user->email}}</td>
                                <td>
                                 {{$user->no_hp ? $user->no_hp : "-"}}
                                </td>
                                <td>
                                    {{$user->roles->nama_roles }}
                                </td>
                                <td style="text-align: center;">
                                    <!-- <a href="{{route('users.edit', $user)}}" class="btn btn-primary btn-xs">
                                       <i class="fas fa-edit"></i> Edit
                                    </a> -->
                                    @if ($user->id != Auth::id())
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">
                                            <i class="fas fa-trash"></i>Delete
                                        </button>
                                    </form>
                                   @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop
@section('js')
<script>
    $(document).ready(function () {

        setTimeout(function () {
            $('.alert').fadeOut('slow', function () {
                $(this).remove(); // Menghapus elemen dari DOM
            });
        }, 1000); 
    });
</script>

@endsection











