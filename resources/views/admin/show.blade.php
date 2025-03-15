@extends('layouts.app')

@section('title', 'Detail Admin')

@section('content')
<div class="container">
    <h1 class="mt-4">Detail Admin</h1>

    
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Nama: {{ $admin->nama }}</h5>
            <p class="card-text"><strong>Email:</strong> {{ $admin->email }}</p>
            <p class="card-text"><strong>Role:</strong> {{ $admin->role->name ?? 'Tidak ada role' }}</p>
            <p class="card-text"><strong>Dibuat pada:</strong> {{ $admin->created_at->format('d M Y H:i') }}</p>
            <p class="card-text"><strong>Terakhir diperbarui:</strong> {{ $admin->updated_at->format('d M Y H:i') }}</p>
            
            <!-- Tombol Aksi -->
            <a href="{{ route('admin.index') }}" class="btn btn-secondary ">Kembali</a>
            <a href="{{ route('admin.edit', $admin->id_admin) }}" class="btn btn-warning">Edit</a>

            <form action="{{ route('admin.destroy', $admin->id_admin) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
            </form>
        </div>
    </div>
</div>
@endsection
