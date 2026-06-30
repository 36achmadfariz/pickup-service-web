@extends('layouts.app')

@section('title', 'Batalkan Pickup — Instant Pickup')

@section('content')
<div class="form-page">
    <div class="form-card">
        <div class="form-header">
            <div style="font-size:2.5rem;margin-bottom:0.5rem;">⚠️</div>
            <h1>Batalkan Pickup</h1>
            <p>No. Referensi: <strong>#{{ $pickup->id }}</strong></p>
        </div>

        <div style="background:#FEF2F2;border-radius:8px;padding:1rem;margin-bottom:1.5rem;font-size:0.9rem;color:#991B1B;">
            ⚠️ Pembatalan hanya bisa dilakukan jika status pickup masih <strong>"Menunggu"</strong>. 
            Jika kurir sudah dalam perjalanan, hubungi petugas via WhatsApp.
        </div>

        <form method="POST" action="{{ route('pickup.cancel', $pickup->id) }}">
            @csrf
            @method('DELETE')
            <div class="form-group">
                <label>Nama Pengirim (verifikasi) *</label>
                <input type="text" name="nama" required placeholder="Nama yang digunakan saat request">
            </div>
            <div class="form-group">
                <label>No. HP (verifikasi) *</label>
                <input type="text" name="nomor_kontak" required placeholder="Nomor yang digunakan saat request">
            </div>
            <button type="submit" class="btn btn-danger" style="width:100%;justify-content:center;padding:0.8rem;font-size:1rem;">
                ❌ Ya, Batalkan Pickup Ini
            </button>
        </form>

        <div style="text-align:center;margin-top:1rem;">
            <a href="/" style="color:var(--text-muted);font-size:0.88rem;">← Kembali ke Beranda</a>
        </div>
    </div>
</div>
@endsection
