@extends('layouts.app')

@section('title', 'Pickup Berhasil — Instant Pickup')

@section('content')
<div class="form-page">
    <div class="form-card" style="text-align:center;">
        <div style="font-size:3rem;margin-bottom:1rem;">✅</div>
        <h1 style="font-size:1.5rem;font-weight:700;margin-bottom:0.5rem;">Request Pickup Berhasil!</h1>
        <p style="color:var(--text-muted);margin-bottom:0.5rem;">
            No. Referensi: <strong>#{{ $pickup->id }}</strong>
        </p>
        <p style="color:var(--text-muted);margin-bottom:1.5rem;">
            Petugas kami akan segera menghubungi Anda melalui nomor yang terdaftar.<br>
            Mohon pastikan WhatsApp/telepon Anda aktif.
        </p>

        <div style="background:#F8FAFC;border-radius:8px;padding:1rem;margin-bottom:1.5rem;text-align:left;">
            <div style="font-weight:600;margin-bottom:0.5rem;">📋 Detail Pickup:</div>
            <div style="font-size:0.85rem;color:var(--text-muted);line-height:1.7;">
                <div>👤 <strong>{{ $pickup->nama }}</strong></div>
                @if($pickup->email)<div>📧 {{ $pickup->email }}</div>@endif
                <div>📱 {{ $pickup->nomor_kontak }}</div>
                <div>📍 {{ $pickup->alamat_pickup }}</div>
                <div>📦 {{ $pickup->alamat_tujuan }} — {{ $pickup->deskripsi_barang }}</div>
            </div>
        </div>

        <div style="display:flex;gap:0.8rem;justify-content:center;flex-wrap:wrap;">
            <a href="/" class="btn btn-primary">🏠 Kembali ke Beranda</a>
            <a href="{{ route('pickup.cancelForm', $pickup->id) }}" class="btn btn-outline" style="color:#EF4444;border-color:#EF4444;">❌ Batalkan Pickup</a>
        </div>

        <p style="margin-top:1rem;font-size:0.8rem;color:var(--text-muted);">
            Simpan No. Referensi <strong>#{{ $pickup->id }}</strong> untuk tracking dan pembatalan.
        </p>
    </div>
</div>
@endsection
