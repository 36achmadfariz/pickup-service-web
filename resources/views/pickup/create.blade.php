@extends('layouts.app')
@section('title', 'Request Pickup')

@section('content')
<div class="brand">
    <h1>📦 Instant Pickup</h1>
    <p>Request penjemputan barang cepat, tanpa registrasi</p>
</div>

<div class="card" style="box-shadow:var(--shadow-lg);">
    <h2 style="margin-bottom:0.3rem;">Form Pickup Barang</h2>
    <p style="color:var(--text-muted); margin-bottom:1.5rem; font-size:0.9rem;">Isi data di bawah, tim kami akan segera menjemput.</p>
    
    <form action="{{ route('pickup.store') }}" method="POST">
        @csrf
        <div class="form-row">
            <div class="form-group"><label>Nama Lengkap *</label><input type="text" name="nama" required placeholder="Nama Anda"></div>
            <div class="form-group"><label>Nomor Kontak *</label><input type="text" name="nomor_kontak" required placeholder="08xxxxxxxx"></div>
        </div>
        <div class="form-group"><label>Alamat Pickup *</label><textarea name="alamat_pickup" required rows="2" placeholder="Alamat lengkap penjemputan"></textarea></div>
        <div class="form-group"><label>Alamat Tujuan *</label><textarea name="alamat_tujuan" required rows="2" placeholder="Alamat tujuan pengiriman"></textarea></div>
        <div class="form-group"><label>Deskripsi Barang *</label><textarea name="deskripsi_barang" required rows="2" placeholder="Jelaskan barang yang akan di-pickup"></textarea></div>
        <div class="form-group"><label>Estimasi Berat (kg)</label><input type="number" name="berat_kg" step="0.1" min="0" placeholder="Opsional"></div>
        <button type="submit" class="btn btn-primary" style="width:100%; padding:0.8rem; font-size:1rem;">🚀 Kirim Request Pickup</button>
    </form>
</div>
<div style="text-align:center; margin-top:1rem;">
    <a href="{{ route('login') }}" style="color:var(--text-muted); font-size:0.85rem;">🔐 Login Admin / Kurir</a>
</div>
@endsection
