<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instant Pickup Barang — Cilegon 42400</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --orange: #E84C16;
            --orange-dark: #C53D0E;
            --orange-light: #FFF5F0;
            --delft: #1B3A5C;
            --delft-light: #264F78;
            --white: #FFFFFF;
            --text: #1E293B;
            --text-muted: #475569;
            --border: #E2E8F0;
            --bg-light: #F8FAFC;
            --shadow: 0 1px 3px rgba(0,0,0,0.08), 0 1px 2px rgba(0,0,0,0.04);
            --shadow-md: 0 4px 12px rgba(0,0,0,0.10);
            --radius: 12px;
            --radius-sm: 8px;
            --radius-pill: 9999px;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background: var(--white);
            color: var(--text);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }

        /* ===== NAVBAR — clean white ===== */
        .nav {
            position: sticky; top: 0; z-index: 100;
            background: rgba(255,255,255,0.97); backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border);
            padding: 0 2rem; height: 68px;
            display: flex; align-items: center; justify-content: space-between;
        }
        .nav-left { display: flex; align-items: center; gap: 0.75rem; }
        .nav-logo-posind { height: 56px; width: auto; object-fit: contain; }
        .nav-logo-danantara { height: 156px; width: auto; object-fit: contain; }
        .nav-divider { width: 1px; height: 24px; background: var(--border); }
        .nav-text { font-size: 0.9rem; font-weight: 700; color: var(--text-muted); letter-spacing: 0.08em; }
        .nav-links { display: flex; align-items: center; gap: 0.5rem; }
        .nav-links a { text-decoration: none; color: var(--text-muted); font-size: 0.85rem; font-weight: 500; padding: 0.4rem 0.8rem; border-radius: 6px; transition: all 0.2s; }
        .nav-links a:hover { color: var(--text); background: var(--bg-light); }
        .btn-nav { padding: 0.5rem 1.2rem; border-radius: var(--radius-sm); font-size: 0.85rem; font-weight: 600; text-decoration: none; background: var(--orange); color: #fff; transition: all 0.2s; margin-left: 0.5rem; }
        .btn-nav:hover { background: var(--orange-dark); }

        .container { max-width: 800px; margin: 0 auto; padding: 0 1.5rem; }

        /* ===== HEADER — full photo bg + orange overlay ===== */
        .header {
            position: relative; background: url('/images/kantor-pos-cilegon-bg.jpg') center/contain no-repeat;
            padding: 5rem 0; text-align: center;
        }
        .header::after {
            content: ''; position: absolute; inset: 0;
            background: linear-gradient(135deg, rgba(15,43,69,0.78) 0%, rgba(27,58,92,0.78) 50%, rgba(38,79,120,0.78) 100%);
        }
        .header-content { position: relative; z-index: 1; }
        .header-badge {
            display: inline-block; background: rgba(255,255,255,0.2); color: #fff;
            padding: 0.3rem 1rem; border-radius: var(--radius-pill); font-size: 0.8rem;
            font-weight: 700; margin-bottom: 1.5rem; letter-spacing: 0.05em;
            border: 1px solid rgba(255,255,255,0.3);
        }
        .header h1 {
            font-size: clamp(2rem, 6vw, 3.2rem); font-weight: 900;
            color: #fff; letter-spacing: -0.03em; line-height: 1.15;
            margin-bottom: 0.4rem;
        }
        .header-sub {
            font-size: 1rem; font-weight: 700; color: rgba(255,255,255,0.9);
            letter-spacing: 0.12em; margin-bottom: 1rem; text-transform: uppercase;
        }
        .header-benefit {
            font-size: 1.05rem; font-weight: 700; color: #fff;
            margin-bottom: 0.3rem;
        }
        .header-benefit-sub {
            font-size: 0.95rem; font-weight: 500; color: rgba(255,255,255,0.85);
            letter-spacing: 0.02em; margin-bottom: 1rem;
        }
        .header-pills {
            display: flex; justify-content: center; gap: 0.6rem; flex-wrap: wrap;
            margin-bottom: 2rem;
        }
        .header-pill {
            display: inline-flex; align-items: center; gap: 0.35rem;
            padding: 0.4rem 1rem; border-radius: var(--radius-pill);
            font-size: 0.82rem; font-weight: 600; color: #fff;
            background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.25);
        }
        .header-pill .dot { color: #4ADE80; font-weight: 800; }
        .header-cta { display: flex; justify-content: center; gap: 1rem; flex-wrap: wrap; }

        /* Buttons */
        .btn {
            display: inline-flex; align-items: center; gap: 0.5rem;
            padding: 0.85rem 2rem; border-radius: var(--radius-sm); font-size: 0.95rem;
            font-weight: 700; text-decoration: none; border: none; cursor: pointer;
            font-family: inherit; transition: all 0.25s;
        }
        .btn-primary { background: #fff; color: var(--orange); }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(0,0,0,0.2); }
        .btn-ghost { background: rgba(255,255,255,0.15); color: #fff; border: 1.5px solid rgba(255,255,255,0.4); }
        .btn-ghost:hover { background: rgba(255,255,255,0.25); transform: translateY(-2px); }
        .btn-wa { background: #25D366; color: #fff; border-radius: var(--radius-pill); }
        .btn-wa:hover { filter: brightness(1.1); transform: translateY(-2px); }
        .btn-orange { background: var(--orange); color: #fff; width: 100%; justify-content: center; font-size: 1rem; padding: 0.9rem; }
        .btn-orange:hover { background: var(--orange-dark); transform: translateY(-1px); box-shadow: 0 4px 16px rgba(232,76,22,0.35); }

        /* ===== SECTION ===== */
        .section { padding: 3rem 0; }
        .section-header { text-align: center; margin-bottom: 2rem; }
        .section-header h2 { font-size: 1.5rem; font-weight: 800; color: var(--text); margin-bottom: 0.3rem; }
        .section-header p { color: var(--text-muted); font-size: 0.95rem; }

        /* ===== FORM ===== */
        .form-card {
            background: #fff; border-radius: var(--radius); padding: 1.8rem;
            box-shadow: var(--shadow-md); border: 1px solid var(--border);
        }
        .form-group { margin-bottom: 1rem; }
        .form-group label { display: block; font-weight: 600; font-size: 0.82rem; margin-bottom: 0.3rem; color: var(--text); }
        .form-group input, .form-group textarea {
            width: 100%; padding: 0.7rem 0.9rem; border: 1.5px solid var(--border);
            border-radius: var(--radius-sm); font-size: 0.9rem; font-family: inherit;
            background: var(--bg-light); transition: all 0.2s; color: var(--text);
        }
        .form-group input:focus, .form-group textarea:focus {
            border-color: var(--orange); outline: none;
            box-shadow: 0 0 0 3px rgba(232,76,22,0.1); background: #fff;
        }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 0.8rem; }

        /* ===== MARKETPLACE ===== */
        .offer-section {
            background: linear-gradient(135deg, #FEF2F2 0%, #FFF7ED 100%);
            border-radius: var(--radius); padding: 2rem;
            border: 1px solid #FECACA; margin-bottom: 1rem;
        }
        .offer-section h3 { font-size: 1.15rem; font-weight: 800; color: #B91C1C; margin-bottom: 0.25rem; }
        .offer-section .offer-desc { font-size: 0.9rem; color: var(--text-muted); margin-bottom: 1.2rem; }
        .mkt-grid { display: flex; flex-wrap: wrap; gap: 0.6rem; margin-bottom: 1.2rem; }
        .mkt-badge {
            display: inline-flex; align-items: center; gap: 0.5rem;
            padding: 0.5rem 1rem 0.5rem 0.75rem; border-radius: 8px;
            font-size: 0.82rem; font-weight: 700; text-decoration: none;
            border: none; transition: all 0.2s; color: #fff;
        }
        .mkt-badge:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.15); }
        .mkt-badge .mkt-bar {
            width: 4px; height: 18px; border-radius: 2px; flex-shrink: 0;
        }
        .mkt-badge.shopee { background: #FFF; color: #EE4D2D; border: 1.5px solid #EE4D2D; }
        .mkt-badge.tokped { background: #03AC0E; }
        .mkt-badge.tiktok { background: #111; }
        .mkt-badge.lazada { background: #0F1468; }
        .mkt-badge.umkm { background: #E84C16; }
        .mkt-badge.reseller { background: #B45309; }
        .mkt-logo { height: 22px; width: auto; object-fit: contain; flex-shrink: 0; }

        .drop-banner {
            background: #fff; border: 1.5px dashed #FCA5A5; border-radius: var(--radius-sm);
            padding: 1rem 1.3rem; display: flex; align-items: center; gap: 0.8rem;
            font-size: 0.88rem; color: #991B1B; font-weight: 600;
        }

        /* ===== FOOTER ===== */
        .footer {
            background: var(--delft); color: #CBD5E1;
            padding: 2.5rem 0 1.5rem; text-align: center;
        }
        .f-brand { font-size: 0.95rem; font-weight: 700; color: #fff; margin-bottom: 0.3rem; }
        .f-line { font-size: 0.82rem; color: #94A3B8; margin-bottom: 0.2rem; }
        .f-locs { display: flex; justify-content: center; gap: 1rem; flex-wrap: wrap; margin: 1rem 0; }
        .f-locs a { color: #94A3B8; font-size: 0.75rem; text-decoration: none; font-weight: 500; transition: color 0.2s; }
        .f-locs a:hover { color: #fff; }
        .f-copy { font-size: 0.7rem; color: #64748B; margin-top: 1rem; padding-top: 1rem; border-top: 1px solid #334155; }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .nav { padding: 0 1rem; height: 60px; }
            .nav-logo-posind { height: 45px; }
            .nav-logo-danantara { height: 120px; }
            .nav-text { font-size: 0.78rem; }
            .nav-links a:not(.btn-nav) { display: none; }
            .header { padding: 3rem 0; }
            .header h1 { font-size: 1.7rem; }
            .form-row { grid-template-columns: 1fr; }
            .section { padding: 2rem 0; }
        }
        @media (max-width: 480px) {
            .header h1 { font-size: 1.5rem; }
            .header-pills { gap: 0.4rem; }
            .header-pill { font-size: 0.72rem; padding: 0.3rem 0.7rem; }
        }
    </style>
</head>
<body>

{{-- NAVBAR — Clean white --}}
<nav class="nav">
    <div class="nav-left">
        <a href="/" class="nav-brand">
            <img src="/images/logo_posind.png" alt="POSIND" class="nav-logo-posind">
        </a>
        <span class="nav-divider"></span>
        <img src="/images/danantara-removebg-preview.png" alt="Danantara" class="nav-logo-danantara">
        <span class="nav-divider"></span>
        <span class="nav-text">42400</span>
    </div>
    <div class="nav-links">
        <a href="https://www.posindonesia.co.id/id/tracking" target="_blank">🔍 Tracking</a>
        <a href="https://www.posindonesia.co.id/en" target="_blank">💰 Tarif</a>
        <a href="{{ route('login') }}" class="btn-nav">🔑 Login</a>
    </div>
</nav>

{{-- HEADER — Full photo background --}}
<header class="header">
    <div class="header-content">
        <div class="header-badge">🚀 Layanan Pickup KC Cilegon</div>
        <h1>Instant Pickup Barang</h1>
        <p class="header-sub">Bersama PT Pos Indonesia KC Cilegon</p>
        <p class="header-benefit">Kirim Paket dari Rumah — Gratis, Kami Jemput.</p>
        <p class="header-benefit-sub">Tanpa minimum, tanpa biaya pickup, seluruh Kota Cilegon.</p>
        <div class="header-pills">
            <span class="header-pill"><span class="dot">✓</span> Gratis</span>
            <span class="header-pill"><span class="dot">✓</span> Tanpa Minimum</span>
            <span class="header-pill"><span class="dot">✓</span> Seluruh Kota Cilegon</span>
        </div>
        <div class="header-cta">
            <a href="#form" class="btn btn-primary">📦 Ajukan Pickup Sekarang</a>
            <a href="https://wa.me/628990752617" target="_blank" class="btn btn-wa">💬 WhatsApp</a>
        </div>
    </div>
</header>

{{-- FORM PICKUP — langsung di bawah header --}}
<section class="section" id="form" style="background: var(--bg-light); scroll-margin-top: 84px;">
    <div class="container">
        <div class="section-header">
            <h2>📝 Ajukan Pickup — Tanpa Login</h2>
            <p>Isi form di bawah, petugas kami akan menjemput kiriman Anda.</p>
        </div>

        <div class="form-card">
            @if(session('success'))
                <div style="background:#ECFDF5;color:#065F46;padding:0.8rem 1rem;border-radius:8px;margin-bottom:1.2rem;font-weight:600;">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div style="background:#FEF2F2;color:#991B1B;padding:0.8rem 1rem;border-radius:8px;margin-bottom:1.2rem;font-weight:600;">{{ session('error') }}</div>
            @endif
            @if($errors->any())
                <div style="background:#FEF2F2;color:#991B1B;padding:0.8rem 1rem;border-radius:8px;margin-bottom:1.2rem;font-weight:600;">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('pickup.store') }}" id="pickup-form">
                @csrf

                {{-- HONEYPOT — hidden from humans, bots will fill --}}
                <div style="position:absolute;left:-9999px;" aria-hidden="true">
                    <input type="text" name="website" tabindex="-1" autocomplete="off">
                </div>

                {{-- reCAPTCHA v3 token --}}
                <input type="hidden" name="g-recaptcha-response" id="recaptcha-token">
                <div class="form-row">
                    <div class="form-group">
                        <label>Nama Pengirim *</label>
                        <input type="text" name="nama" required placeholder="Nama lengkap Anda" value="{{ old('nama') }}">
                    </div>
                    <div class="form-group">
                        <label>Email *</label>
                        <input type="email" name="email" required placeholder="email@anda.com" value="{{ old('email') }}">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>No. HP / WhatsApp *</label>
                        <input type="tel" name="nomor_kontak" required placeholder="08xxxxxxxxxx" value="{{ old('nomor_kontak') }}">
                    </div>
                    <div class="form-group">
                        <label>Tujuan Kiriman *</label>
                        <input type="text" name="alamat_tujuan" required placeholder="Kota / alamat tujuan" value="{{ old('alamat_tujuan') }}">
                    </div>
                </div>
                <div class="form-group">
                    <label>Alamat Penjemputan *</label>
                    <textarea name="alamat_pickup" required rows="2" placeholder="Alamat lengkap — pastikan mudah ditemukan">{{ old('alamat_pickup') }}</textarea>
                </div>
                <div class="form-group">
                    <label>Jumlah & Deskripsi Barang *</label>
                    <textarea name="deskripsi_barang" required rows="2" placeholder="Contoh: 3 paket — dokumen, pakaian, elektronik">{{ old('deskripsi_barang') }}</textarea>
                </div>
                <button type="submit" class="btn btn-orange">🚀 Kirim Permintaan Pickup</button>
            </form>
        </div>
    </div>
</section>

{{-- SPECIAL OFFER — Marketplace + DropPoint --}}
<section class="section">
    <div class="container">
        <div class="section-header">
            <h2>🛒 Penawaran Spesial untuk Seller & UMKM</h2>
            <p>Dapatkan layanan pickup prioritas + peluang cuan tambahan.</p>
        </div>

        <div class="offer-section">
            <h3>Marketplace Seller</h3>
            <p class="offer-desc">Khusus penjual marketplace — kirim banyak paket setiap hari, kami jemput gratis.</p>
            <div class="mkt-grid">
                <span class="mkt-badge shopee">
                    <img src="/images/shopee.png" alt="Shopee" class="mkt-logo"> Shopee
                </span>
                <span class="mkt-badge tokped">
                    <img src="/images/tokopedia.png" alt="Tokopedia" class="mkt-logo"> Tokopedia
                </span>
                <span class="mkt-badge tiktok">
                    <img src="/images/tiktok.png" alt="TikTok Shop" class="mkt-logo"> TikTok Shop
                </span>
                <span class="mkt-badge lazada">
                    <img src="/images/lazada.png" alt="Lazada" class="mkt-logo"> Lazada
                </span>
                <span class="mkt-badge umkm">
                    <span class="mkt-bar" style="background:#fff;opacity:0.5;"></span> 🏪 UMKM
                </span>
                <span class="mkt-badge reseller">
                    <span class="mkt-bar" style="background:#fff;opacity:0.5;"></span> Reseller & Dropshipper
                </span>
            </div>

            <div class="drop-banner">
                <span style="font-size:1.5rem;">💰</span>
                <span><strong>Cuan tambahan dengan kemitraan Droppoint!</strong> — Jadikan lokasi Anda sebagai titik penjemputan resmi. Setiap paket = komisi untuk Anda. Hubungi PIC kami untuk info.</span>
            </div>
        </div>
    </div>
</section>

{{-- FOOTER --}}
<footer class="footer">
    <div class="container">
        <div class="f-brand">📮 Layanan pickup oleh PT Pos Indonesia (Persero) KC Cilegon 42400</div>
        <div class="f-line">Layanan Pickup Seluruh Wilayah Kota Cilegon</div>
        <div class="f-line">Layanan penjemputan kiriman tanpa minimum — praktis, gratis, terpercaya.</div>

        <div class="f-locs">
            <a href="https://maps.app.goo.gl/gqmhzHAFYfcAaAug8" target="_blank">📍 KC Cilegon 42400</a>
            <span style="color:#475569;">•</span>
            <a href="https://maps.app.goo.gl/nWjQwc3gJdw2ca3h7" target="_blank">📍 KCP Krakatau Steel 42435A</a>
            <span style="color:#475569;">•</span>
            <a href="https://maps.app.goo.gl/KUbXeqfLxgc6tnU47" target="_blank">📍 KCP Merak 42438A</a>
            <span style="color:#475569;">•</span>
            <a href="https://maps.app.goo.gl/usjK2pZCqCzKVt2S7" target="_blank">📍 KCP Bojonegara 42454</a>
            <span style="color:#475569;">•</span>
            <a href="https://maps.app.goo.gl/MqJf86MznB6FDoGGA" target="_blank">📍 KCP Anyerlor 42166</a>
        </div>

        <div class="f-line">📞 PIC: Achmad Fariz S — 08990752617</div>
        <div class="f-copy">© {{ date('Y') }} Instant Pickup Barang. Created by Achmad Fariz S.</div>
    </div>
</footer>

{{-- reCAPTCHA v3 --}}
<script src="https://www.google.com/recaptcha/api.js?render={{ env('RECAPTCHA_SITE_KEY') }}"></script>
<script>
    document.getElementById('pickup-form').addEventListener('submit', function(e) {
        e.preventDefault();
        grecaptcha.ready(function() {
            grecaptcha.execute('{{ env('RECAPTCHA_SITE_KEY') }}', {action: 'pickup'}).then(function(token) {
                document.getElementById('recaptcha-token').value = token;
                e.target.submit();
            });
        });
    });
</script>
</body>
</html>
