<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cari Bus | PURABAYA GO</title>
    <style>
        :root { --ink:#1d2b35; --muted:#5b6c7a; --paper:#f5f7fa; --card:#fff; --green:#0a5d85; --deep:#071d32; --light:#dfeef6; --orange:#0d8d6b; --line:#dfe7ec; --yellow:#f4b63b; }
        * { box-sizing:border-box; }
        body { min-height:100vh; margin:0; color:var(--ink); background-color:var(--paper); background-image:linear-gradient(rgba(7,29,50,.035) 1px,transparent 1px),linear-gradient(90deg,rgba(7,29,50,.035) 1px,transparent 1px); background-size:32px 32px; font-family:Arial,sans-serif; }
        nav { display:flex; justify-content:space-between; align-items:center; gap:24px; padding:18px max(24px,calc((100% - 1100px)/2)); color:#fff; background:var(--deep); }
        nav strong { color:#fff; font:800 16px Georgia,serif; letter-spacing:.08em; }
        nav div { display:flex; flex-wrap:wrap; gap:20px; justify-content:flex-end; }
        nav a { color:rgba(255,255,255,.84); text-decoration:none; font-size:13px; font-weight:700; }
        nav a:hover { color:var(--yellow); }
        .wrap { max-width:1100px; margin:0 auto; padding:58px 24px 90px; }
        .hero { position:relative; overflow:hidden; min-height:220px; padding:38px 34px; border-radius:12px; color:#fff; background:linear-gradient(120deg,rgba(7,29,50,.98),rgba(10,93,133,.94)); box-shadow:10px 10px 0 var(--yellow); }
        .hero::after { content:'PURABAYA'; position:absolute; right:28px; bottom:18px; color:rgba(244,182,59,.22); font:800 clamp(42px,9vw,100px)/1 Georgia,serif; letter-spacing:.08em; transform:rotate(-8deg); }
        .hero::before { content:''; position:absolute; width:180px; height:180px; right:125px; top:-72px; border:1px solid rgba(255,255,255,.16); border-radius:50%; box-shadow:0 0 0 24px rgba(255,255,255,.035),0 0 0 48px rgba(255,255,255,.025); }
        .hero h1 { position:relative; z-index:1; margin:0 0 10px; color:#fff; font:500 clamp(38px,6vw,66px)/.95 Georgia,serif; }
        .hero p { position:relative; z-index:1; max-width:520px; margin:0; color:rgba(255,255,255,.8); font-size:15px; line-height:1.6; }
        .search-card { margin-top:34px; padding:24px; border:1px solid var(--line); border-radius:10px; background:rgba(255,255,255,.94); box-shadow:0 12px 28px rgba(7,29,50,.1); }
        .search-card::before { content:'01 / PILIH PERJALANAN'; display:block; margin-bottom:18px; color:var(--orange); font-size:11px; font-weight:800; letter-spacing:.14em; }
        form { display:grid; grid-template-columns:1.5fr 1fr 1.2fr 1fr 1fr 1fr 1fr auto; gap:12px; align-items:end; }
        select, input { width:100%; padding:12px; border:1px solid var(--line); border-radius:6px; color:var(--ink); background:#fff; font:14px Arial,sans-serif; }
        select:focus, input:focus { outline:2px solid rgba(233,120,63,.35); border-color:var(--orange); }
        .field { min-width:0; } label { display:block; margin-bottom:7px; color:var(--muted); font-size:11px; font-weight:800; letter-spacing:.04em; text-transform:uppercase; }
        button { padding:13px 18px; border:0; border-radius:6px; color:var(--deep); background:var(--yellow); cursor:pointer; font-weight:800; white-space:nowrap; transition:transform .2s,background .2s; }
        button:hover { background:#ffd978; transform:translateY(-2px); }
        .note { margin:18px 0 0; color:var(--muted); font-size:14px; } .note a { color:var(--green); font-weight:800; }
        .feature-strip { display:grid; grid-template-columns:repeat(3,1fr); gap:12px; margin-top:28px; }
        .feature-strip div { padding:16px; border-left:3px solid var(--orange); background:var(--light); }
        .feature-strip strong { display:block; margin-bottom:5px; color:var(--green); font:700 13px Georgia,serif; }
        .feature-strip span { color:var(--muted); font-size:12px; line-height:1.4; }
        @media (max-width:1050px) { form { grid-template-columns:repeat(3,1fr); } }
        @media (max-width:600px) { nav { align-items:flex-start; flex-direction:column; } nav div { justify-content:flex-start; gap:12px; } .wrap { padding:38px 18px 70px; } .hero { padding:30px 24px; } .hero::after { font-size:42px; } .search-card { padding:18px; } form,.feature-strip { grid-template-columns:1fr; } button { width:100%; } }
    </style>
</head>
<body>
    <nav>
        <strong>PURABAYA GO</strong>
        <div>
            <a href="<?= site_url('/') ?>">Home</a>
            <a href="<?= site_url('search') ?>">Cari Bus</a>
            <a href="<?= site_url('guide') ?>">Guide</a>
            <a href="<?= site_url('about') ?>">About</a>
            <?php if (session()->get('logged_in')): ?>
                <a href="<?= site_url(session()->get('role') === 'admin' ? 'admin/dashboard' : 'user/dashboard') ?>">Dashboard</a>
                <a href="<?= site_url('logout') ?>">Logout</a>
            <?php else: ?>
                <a href="<?= site_url('login') ?>">Login</a>
            <?php endif; ?>
        </div>
    </nav>

    <div class="wrap">
        <div class="hero">
            <h1>MAU KE MANA?</h1>
            <p>Pilih tujuan keberangkatanmu dari Terminal Purabaya.</p>
        </div>

        <div class="search-card">
        <form action="<?= site_url('search') ?>" method="get">
            <div class="field"><label for="q">Cari bus atau tujuan</label><input id="q" name="q" placeholder="Cari tujuan atau nama bus..."></div><div class="field">
                <label for="from">Dari</label><input id="from" value="Terminal Purabaya" readonly>
            </div><div class="field">
                <label for="destination">Tujuan</label><select id="destination" name="destination_id" required>
                    <option value="">Pilih tujuan</option>
                    <?php foreach ($destinations as $destination): ?>
                        <option value="<?= esc($destination['id']) ?>"><?= esc($destination['destination_name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div><div class="field"><label for="category">Kelas</label><select id="category" name="category"><option value="">Semua</option><option value="ekonomi">Ekonomi</option><option value="patas">Patas</option><option value="executive">Eksekutif</option></select></div>
            <div class="field"><label for="fare">Tarif maksimal</label><input id="fare" name="fare" type="number" min="0" placeholder="Contoh 40000"></div><div class="field"><label for="time">Waktu</label><input id="time" name="time" type="time"></div><div class="field"><label for="sort">Urutkan</label><select id="sort" name="sort"><option value="shelter">Shelter terdekat</option><option value="morning">Paling pagi</option><option value="latest">Paling malam</option><option value="fare_low">Tarif termurah</option><option value="fare_high">Tarif tertinggi</option></select></div>
            <button type="submit">&#128269; Cari Bus</button>
        </form>
        </div>
        <p class="note">Belum tahu tujuan? <a href="<?= site_url('destinations') ?>">Jelajahi semua kota tujuan &rarr;</a></p>
        <div class="feature-strip" aria-label="Informasi layanan">
            <div><strong>01 / Tujuan</strong><span>Pilih kota keberangkatan dari Terminal Purabaya.</span></div>
            <div><strong>02 / Kategori</strong><span>Bandingkan Ekonomi, Patas, dan Executive.</span></div>
            <div><strong>03 / Jadwal</strong><span>Gunakan waktu, shelter, dan tarif sebagai filter.</span></div>
        </div>
    </div>
</body>
</html>
