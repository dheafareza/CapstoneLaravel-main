@extends('layouts.app')

@section('title', 'Edit Admin')

@section('content')
<div class="container">
    <h1 class="mt-4">Edit Admin</h1>

    <!-- Tampilkan pesan error jika ada -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form Edit Admin -->
    <form action="{{ route('admin.update', $admin->id_admin) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama', $admin->nama) }}" required>
        </div>
        
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $admin->email) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label" for="role_id">Role</label>
            <select class="form-control" id="role_id" name="role_id" required>
                <option value="" disabled selected>Pilih Role</option>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}" {{ old('role_id', $admin->role_id) == $role->id ? 'selected' : '' }}>
                        {{ $role->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password (Kosongkan jika tidak ingin mengubah)</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>
        
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
        </div>
        
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="{{ route('admin.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
