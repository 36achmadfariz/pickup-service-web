@extends('layouts.app')

@section('title', 'Kelola Kurir — Instant Pickup')
@section('page-title', '🛵 Kelola Kurir')

@section('content')

{{-- Tambah Kurir --}}
<div class="card">
    <div class="card-header">
        <h3>➕ Tambah Kurir Baru</h3>
    </div>
    <form method="POST" action="{{ route('admin.createKurir') }}">
        @csrf
        <div class="form-row">
            <div class="form-group">
                <label>Nama Kurir *</label>
                <input type="text" name="name" required placeholder="Nama lengkap">
            </div>
            <div class="form-group">
                <label>Email *</label>
                <input type="email" name="email" required placeholder="email@posindonesia.co.id">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label>Password *</label>
                <input type="password" name="password" required placeholder="Minimal 6 karakter">
            </div>
            <div class="form-group">
                <label>No. Kontak</label>
                <input type="text" name="nomor_kontak" placeholder="08xxxxxxxxxx">
            </div>
        </div>
        <button type="submit" class="btn btn-primary">➕ Buat Akun Kurir</button>
    </form>
</div>

{{-- Daftar Kurir --}}
<div class="card">
    <div class="card-header">
        <h3>👥 Daftar Kurir</h3>
    </div>
    <div style="overflow-x:auto;">
        <table>
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>No. Kontak</th>
                    <th>Tugas Aktif</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kurirList as $k)
                <tr>
                    <td style="font-weight:600;">🛵 {{ $k->name }}</td>
                    <td>{{ $k->email }}</td>
                    <td>{{ $k->nomor_kontak ?? '—' }}</td>
                    <td>
                        @php $tugas = \App\Models\Pickup::where('assigned_to', $k->id)->whereIn('status', ['diproses','dalam_perjalanan'])->count(); @endphp
                        <span class="badge {{ $tugas > 0 ? 'badge-dalam_perjalanan' : 'badge-selesai' }}">{{ $tugas }} pickup</span>
                    </td>
                    <td>
                        <form method="POST" action="{{ route('admin.deleteKurir', $k->id) }}" onsubmit="return confirm('Hapus kurir ini?')" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-outline-sm" style="color:#EF4444;border-color:#FECACA;">🗑️ Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align:center;padding:2rem;color:var(--text-muted);">
                        Belum ada kurir terdaftar.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
