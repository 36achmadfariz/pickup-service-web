@extends('layouts.app')

@section('title', 'Login — Instant Pickup')

@section('content')
<div class="form-page">
    <div class="form-card">
        <div class="form-header">
            <div style="font-size:3rem;margin-bottom:0.5rem;">🔐</div>
            <h1>Login Petugas</h1>
            <p>Admin & Kurir — Kantor Pos Cilegon 42400</p>
        </div>

        <form method="POST" action="{{ route('login.post') }}">
            @csrf
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" required placeholder="email@posindonesia.co.id" value="{{ old('email') }}" autofocus>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required placeholder="••••••••">
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;padding:0.8rem;font-size:1rem;">
                🔑 Masuk
            </button>
        </form>

        <div style="text-align:center;margin-top:1rem;">
            <a href="/" style="color:var(--text-muted);font-size:0.88rem;">← Kembali ke Halaman Publik</a>
        </div>
    </div>
</div>
@endsection
