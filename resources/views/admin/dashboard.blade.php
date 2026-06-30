@extends('layouts.app')

@section('title', 'Dashboard Admin — Instant Pickup')
@section('page-title', '📊 Dashboard Admin')

@section('content')

{{-- Stats --}}
<div class="dash-stats">
    <div class="stat-card">
        <div class="accent-bar" style="background:#F59E0B;"></div>
        <div class="stat-icon" style="background:#FEF3C7;color:#D97706;">⏳</div>
        <div>
            <div class="stat-num">{{ $totalMenunggu }}</div>
            <div class="stat-label">Menunggu Pickup</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="accent-bar" style="background:#3B82F6;"></div>
        <div class="stat-icon" style="background:#DBEAFE;color:#2563EB;">🔄</div>
        <div>
            <div class="stat-num">{{ $totalDiproses }}</div>
            <div class="stat-label">Dalam Proses</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="accent-bar" style="background:#10B981;"></div>
        <div class="stat-icon" style="background:#DCFCE7;color:#16A34A;">✅</div>
        <div>
            <div class="stat-num">{{ $totalSelesai }}</div>
            <div class="stat-label">Selesai</div>
        </div>
    </div>
</div>

{{-- Statistik Export --}}
<div style="background:var(--bg-light);border-radius:12px;padding:1rem;margin-bottom:1.5rem;display:flex;flex-wrap:wrap;gap:1rem;align-items:center;justify-content:space-between;">
    <div style="display:flex;gap:1.5rem;flex-wrap:wrap;">
        <div>
            <span style="font-size:0.8rem;color:var(--text-muted);">📅 Hari Ini</span>
            <div style="font-weight:800;font-size:1.2rem;color:var(--text);">{{ $hariIni ?? 0 }} pickup</div>
        </div>
        <div>
            <span style="font-size:0.8rem;color:var(--text-muted);">📆 Bulan Ini</span>
            <div style="font-weight:800;font-size:1.2rem;color:var(--text);">{{ $bulanIni ?? 0 }} pickup</div>
        </div>
        <div>
            <span style="font-size:0.8rem;color:var(--text-muted);">📊 Total</span>
            <div style="font-weight:800;font-size:1.2rem;color:var(--text);">{{ $totalSemua ?? 0 }} pickup</div>
        </div>
    </div>
    <div style="display:flex;gap:0.5rem;flex-wrap:wrap;align-items:center;">
        <a href="{{ route('admin.export', ['period' => 'hari_ini']) }}" class="btn btn-primary btn-sm" style="background:#10B981;border-color:#059669;">📥 Hari Ini</a>
        <a href="{{ route('admin.export', ['period' => 'bulan_ini']) }}" class="btn btn-primary btn-sm" style="background:#3B82F6;border-color:#2563EB;">📥 Bulan Ini</a>
        <a href="{{ route('admin.export', ['period' => 'semua']) }}" class="btn btn-primary btn-sm">📥 Semua</a>
    </div>
</div>

{{-- Filter Rentang Tanggal --}}
<div style="background:var(--bg);border:1px dashed var(--border);border-radius:8px;padding:0.75rem 1rem;margin-bottom:1.5rem;">
    <form method="GET" action="{{ route('admin.export') }}" style="display:flex;align-items:center;gap:0.75rem;flex-wrap:wrap;">
        <span style="font-size:0.85rem;font-weight:700;color:var(--text-muted);white-space:nowrap;">📅 Rentang Tanggal:</span>
        <input type="date" name="from" value="{{ request('from', today()->format('Y-m-d')) }}" style="padding:0.4rem 0.6rem;border:1px solid var(--border);border-radius:6px;font-size:0.85rem;">
        <span style="color:var(--text-muted);">s/d</span>
        <input type="date" name="to" value="{{ request('to', today()->format('Y-m-d')) }}" style="padding:0.4rem 0.6rem;border:1px solid var(--border);border-radius:6px;font-size:0.85rem;">
        <button type="submit" name="preview" value="1" class="btn btn-primary btn-sm" style="background:#6B7280;border-color:#4B5563;">🔍 Cek Data</button>
        <button type="submit" class="btn btn-primary btn-sm" style="background:#E84C16;border-color:#C2410C;">📥 Export Custom</button>
    </form>
</div>

{{-- PREVIEW EXPORT — muncul setelah klik Cek --}}
@if(session('preview_data'))
@php $previewPickups = session('preview_data'); @endphp
<div class="card" style="border-left: 4px solid #F59E0B;background:#FFFBEB;">
    <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:0.5rem;margin-bottom:1rem;">
        <div>
            <h3 style="margin:0;font-size:1rem;">📋 Preview: {{ session('preview_label') }}</h3>
            <span style="font-size:0.8rem;color:var(--text-muted);">{{ session('preview_count') }} data siap ekspor — klik <strong>Export Custom</strong> di atas untuk download.</span>
        </div>
    </div>
    <div style="overflow-x:auto;max-height:400px;overflow-y:auto;">
        <table>
            <thead>
                <tr>
                    <th>#ID</th><th>Nama</th><th>Email</th><th>No HP</th><th>Alamat</th><th>Tujuan</th><th>Barang</th><th>Status</th><th>Kurir</th><th>Tgl</th>
                </tr>
            </thead>
            <tbody>
                @forelse($previewPickups as $p)
                <tr>
                    <td style="font-weight:600;">#{{ $p->id }}</td>
                    <td>{{ $p->nama }}</td>
                    <td style="font-size:0.78rem;">{{ $p->email ?? '—' }}</td>
                    <td>{{ $p->nomor_kontak }}</td>
                    <td style="max-width:120px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;" title="{{ $p->alamat_pickup }}">{{ $p->alamat_pickup }}</td>
                    <td>{{ $p->alamat_tujuan }}</td>
                    <td>{{ Str::limit($p->deskripsi_barang, 25) }}</td>
                    <td><span class="badge {{ $p->status === 'selesai' ? 'badge-selesai' : ($p->status === 'menunggu' ? 'badge-menunggu' : 'badge-dalam_perjalanan') }}">{{ ucfirst($p->status) }}</span></td>
                    <td style="font-size:0.8rem;">{{ $p->kurir?->name ?? '—' }}</td>
                    <td style="font-size:0.78rem;">{{ $p->created_at instanceof \Carbon\Carbon ? $p->created_at->format('d/m') : '' }}</td>
                </tr>
                @empty
                <tr><td colspan="10" style="text-align:center;padding:2rem;color:var(--text-muted);">📭 Tidak ada data untuk filter ini.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endif

{{-- Search --}}
<div class="card">
    <form method="GET" action="{{ route('admin.search') }}" class="search-bar">
        <input type="text" name="q" placeholder="🔍 Cari pickup — nama, nomor, alamat..." value="{{ $query ?? '' }}">
        <button type="submit" class="btn btn-primary btn-sm">Cari</button>
    </form>
</div>

{{-- Pickup List + Assign Kurir --}}
<div class="card">
    <div class="card-header">
        <h3>📦 Daftar Pickup</h3>
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
                    <th>Kurir</th>
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
                    <td>{{ Str::limit($p->deskripsi_barang, 40) }}</td>
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
                        @if($p->kurir)
                            <span style="font-size:0.8rem;">🛵 {{ $p->kurir->name }}</span>
                        @elseif($p->status === 'menunggu')
                            <form method="POST" action="{{ route('admin.assign') }}" style="display:flex;gap:0.3rem;align-items:center;">
                                @csrf
                                <input type="hidden" name="pickup_id" value="{{ $p->id }}">
                                <select name="kurir_id" style="font-size:0.75rem;padding:0.25rem;border:1px solid var(--border);border-radius:4px;">
                                    <option value="">— Pilih —</option>
                                    @foreach($kurirList as $k)
                                        <option value="{{ $k->id }}">{{ $k->name }}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="btn btn-primary btn-sm">Assign</button>
                            </form>
                        @else
                            <span style="font-size:0.8rem;color:var(--text-muted);">—</span>
                        @endif
                    </td>
                    <td>
                        <form method="POST" action="{{ route('admin.deletePickup', $p->id) }}" onsubmit="return confirm('Hapus pickup ini?')" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-outline-sm" style="color:#EF4444;border-color:#FECACA;">🗑️</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" style="text-align:center;padding:3rem;color:var(--text-muted);">
                        📭 Belum ada data pickup.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($pickups->hasPages())
    <div style="margin-top:1rem;text-align:center;">
        {{ $pickups->links('pagination::dark') }}
    </div>
    @endif
</div>

@endsection
