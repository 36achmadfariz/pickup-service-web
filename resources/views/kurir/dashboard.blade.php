@extends('layouts.app')

@section('title', 'Dashboard Kurir — Instant Pickup')
@section('page-title', '🛵 Tugas Saya')

@section('content')

@php
$tugasAktif = $pickups->whereIn('status', ['diproses', 'dalam_perjalanan'])->count();
$selesai = $pickups->where('status', 'selesai')->count();
@endphp

<div class="dash-stats">
    <div class="stat-card">
        <div class="accent-bar" style="background:#3B82F6;"></div>
        <div class="stat-icon" style="background:#DBEAFE;color:#2563EB;">🔄</div>
        <div>
            <div class="stat-num">{{ $tugasAktif }}</div>
            <div class="stat-label">Tugas Aktif</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="accent-bar" style="background:#10B981;"></div>
        <div class="stat-icon" style="background:#DCFCE7;color:#16A34A;">✅</div>
        <div>
            <div class="stat-num">{{ $selesai }}</div>
            <div class="stat-label">Selesai Hari Ini</div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3>📦 Daftar Tugas Pickup</h3>
    </div>
    <div style="overflow-x:auto;">
        <table>
            <thead>
                <tr>
                    <th>#ID</th>
                    <th>Pengirim</th>
                    <th>Email</th>
                    <th>Kontak</th>
                    <th>Alamat Pickup</th>
                    <th>Tujuan</th>
                    <th>Barang</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pickups as $p)
                <tr>
                    <td style="font-weight:600;">#{{ $p->id }}</td>
                    <td>{{ $p->nama }}</td>
                    <td style="font-size:0.8rem;">{{ $p->email ?? '—' }}</td>
                    <td>{{ $p->nomor_kontak }}</td>
                    <td style="max-width:150px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;" title="{{ $p->alamat_pickup }}">{{ $p->alamat_pickup }}</td>
                    <td>{{ $p->alamat_tujuan }}</td>
                    <td>{{ Str::limit($p->deskripsi_barang, 30) }}</td>
                    <td>
                        @php
                            $badgeClass = match($p->status) {
                                'menunggu' => 'badge-menunggu',
                                'diproses', 'dalam_perjalanan' => 'badge-dalam_perjalanan',
                                'selesai' => 'badge-selesai',
                                default => 'badge-menunggu'
                            };
                            $statusText = match($p->status) {
                                'menunggu' => 'Menunggu',
                                'diproses' => 'Diproses',
                                'dalam_perjalanan' => 'Dalam Perjalanan',
                                'selesai' => 'Selesai',
                                default => ucfirst($p->status)
                            };
                        @endphp
                        <span class="badge {{ $badgeClass }}">{{ $statusText }}</span>
                    </td>
                    <td>
                        @if($p->status === 'diproses')
                            <form method="POST" action="{{ route('kurir.updateStatus', $p->id) }}" style="display:inline;">
                                @csrf
                                <input type="hidden" name="status" value="dalam_perjalanan">
                                <button type="submit" class="btn btn-primary btn-sm">🚀 Berangkat</button>
                            </form>
                        @elseif($p->status === 'dalam_perjalanan')
                            <form method="POST" action="{{ route('kurir.updateStatus', $p->id) }}" style="display:inline;">
                                @csrf
                                <input type="hidden" name="status" value="selesai">
                                <button type="submit" class="btn btn-success btn-sm">✅ Selesai</button>
                            </form>
                        @elseif($p->status === 'selesai')
                            <span style="font-size:0.8rem;color:var(--success);">✓ Selesai</span>
                        @else
                            <span style="font-size:0.8rem;color:var(--text-muted);">Menunggu assign</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" style="text-align:center;padding:3rem;color:var(--text-muted);">
                        🎉 Belum ada tugas pickup untuk Anda.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
