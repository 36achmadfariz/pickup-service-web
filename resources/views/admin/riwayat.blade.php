@extends('layouts.app')

@section('title', 'Riwayat Pickup — Instant Pickup')
@section('page-title', '📋 Riwayat Pickup Selesai')

@section('content')

<div class="card">
    <div style="overflow-x:auto;">
        <table>
            <thead>
                <tr>
                    <th style="width:50px;">No</th>
                    <th>#ID</th>
                    <th>Pengirim</th>
                    <th>Email</th>
                    <th>No HP</th>
                    <th>Alamat Pickup</th>
                    <th>Tujuan</th>
                    <th>Barang</th>
                    <th>Kurir</th>
                    <th>Waktu Selesai</th>
                    <th>Dibuat</th>
                </tr>
            </thead>
            <tbody>
                @forelse($riwayat as $r)
                <tr>
                    <td style="color:var(--text-dim);font-size:0.82rem;">{{ $riwayat->firstItem() + $loop->index }}</td>
                    <td style="font-weight:600;">#{{ $r->id }}</td>
                    <td>{{ $r->nama }}</td>
                    <td style="font-size:0.78rem;">{{ $r->email ?? '—' }}</td>
                    <td>{{ $r->nomor_kontak }}</td>
                    <td style="max-width:130px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;" title="{{ $r->alamat_pickup }}">{{ $r->alamat_pickup }}</td>
                    <td>{{ $r->alamat_tujuan }}</td>
                    <td>{{ Str::limit($r->deskripsi_barang, 30) }}</td>
                    <td style="font-size:0.8rem;">{{ $r->kurir?->name ?? '—' }}</td>
                    <td style="font-size:0.8rem;color:var(--text-muted);">{{ $r->pickup_time ?? '—' }}</td>
                    <td style="font-size:0.78rem;color:var(--text-dim);">{{ $r->created_at instanceof \Carbon\Carbon ? $r->created_at->format('d/m/Y H:i') : $r->created_at }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="11" style="text-align:center;padding:3rem;color:var(--text-muted);">
                        📭 Belum ada pickup selesai.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($riwayat->hasPages())
    <div style="margin-top:1rem;text-align:center;">
        {{ $riwayat->links('pagination::dark') }}
    </div>
    @endif
</div>

@endsection
