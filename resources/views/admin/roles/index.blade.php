@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ $title }}</h5>
                    <a href="{{ route('admin.roles.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah User Baru
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Role Saat Ini</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $index => $user)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <span class="badge bg-{{ $user->hasRole('lurah') ? 'success' : 'info' }}">
                                            {{ ucfirst($user->getRoleNameAttribute()) }}
                                        </span>
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.roles.assign', $user->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <select name="role" class="form-select form-select-sm d-inline-block w-auto me-2" onchange="this.form.submit()">
                                                <option value="">Ubah Role</option>
                                                <option value="lurah" {{ $user->hasRole('lurah') ? 'selected' : '' }}>Lurah</option>
                                                <option value="petugas" {{ $user->hasRole('petugas') ? 'selected' : '' }}>Petugas</option>
                                            </select>
                                        </form>
                                        
                                        <form action="{{ route('admin.roles.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
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
    </div>
</div>
@endsection
