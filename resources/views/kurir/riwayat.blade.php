@extends('layouts.app')

@section('title', 'Riwayat Tugas — Instant Pickup')
@section('page-title', '📋 Riwayat Tugas Selesai')

@section('content')

<div class="card">
    <div style="overflow-x:auto;">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>#ID</th>
                    <th>Pengirim</th>
                    <th>Alamat Pickup</th>
                    <th>Tujuan</th>
                    <th>Barang</th>
                    <th>Waktu Selesai</th>
                </tr>
            </thead>
            <tbody>
                @forelse($riwayat as $index => $r)
                <tr>
                    <td style="color:var(--text-dim);text-align:center;">{{ $riwayat->firstItem() + $index }}</td>
                    <td style="font-weight:600;">#{{ $r->id }}</td>
                    <td>{{ $r->nama }}</td>
                    <td style="max-width:150px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;" title="{{ $r->alamat_pickup }}">{{ $r->alamat_pickup }}</td>
                    <td>{{ $r->alamat_tujuan }}</td>
                    <td>{{ Str::limit($r->deskripsi_barang, 30) }}</td>
                    <td style="font-size:0.8rem;color:var(--text-muted);">{{ $r->pickup_time ?? '—' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align:center;padding:3rem;color:var(--text-muted);">
                        📭 Belum ada tugas selesai.
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
