<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard - PURABAYA GO</title>
    <style>
        body { font-family: Arial, sans-serif; margin:0; background:#f5f7fb; }
        nav { background:#0d1b2a; color:#fff; padding:18px 24px; display:flex; justify-content:space-between; }
        nav a { color:#fff; text-decoration:none; margin-left:18px; }
        .wrap { max-width:1080px; margin:40px auto; padding:0 16px; }
        .card { background:#fff; border-radius:14px; padding:24px; box-shadow:0 15px 30px rgba(0,0,0,.06); }
        .alert { margin-bottom:16px; padding:10px 12px; border-radius:8px; }
        .alert.success { background:#dfeef6; color:#071d32; }
        .ticket-purchase-section { margin-top:32px; padding:32px; border:1px solid #dfe7ec; border-radius:16px; background:#fffdf7; box-shadow:0 15px 30px rgba(7,29,50,.08); }
        .ticket-purchase-heading { display:flex; justify-content:space-between; align-items:flex-end; gap:28px; margin-bottom:24px; }
        .ticket-purchase-eyebrow { color:#e9783f; font:700 12px Arial,sans-serif; letter-spacing:.14em; text-transform:uppercase; }
        .ticket-purchase-heading h2 { margin:10px 0 0; color:#0a5d85; font:500 clamp(30px,4vw,46px)/1 Georgia,serif; }
        .ticket-purchase-heading p { max-width:360px; margin:0; color:#5b6c7a; font:15px/1.55 Arial,sans-serif; }
        .ticket-purchase-layout { display:grid; grid-template-columns:.8fr 1.2fr; gap:24px; align-items:stretch; }
        .trip-summary { padding:24px; border-radius:12px; color:#fff; background:#0a5d85; }
        .trip-summary h3 { margin:0 0 20px; color:#f5c95d; font:700 12px Arial,sans-serif; letter-spacing:.12em; text-transform:uppercase; }
        .trip-summary p { margin:11px 0; color:rgba(255,255,255,.88); font:14px/1.45 Arial,sans-serif; }
        .ticket-platforms { display:grid; grid-template-columns:1fr 1fr; gap:14px; }
        .ticket-platform { display:flex; min-height:230px; flex-direction:column; justify-content:space-between; padding:24px; border:1px solid #dfe7ec; border-radius:12px; background:#fff; transition:transform .2s ease, box-shadow .2s ease; }
        .ticket-platform:hover { transform:translateY(-5px); box-shadow:0 12px 22px rgba(7,29,50,.12); }
        .ticket-platform-logo { display:block; width:64px; height:64px; object-fit:contain; margin-bottom:22px; }
        .ticket-platform-logo.redbus-logo { width:100px; height:66px; }
        .ticket-platform h3 { margin:0 0 8px; color:#0a5d85; font:500 28px Georgia,serif; }
        .ticket-platform p { margin:0; color:#5b6c7a; font:14px/1.55 Arial,sans-serif; }
        .ticket-platform a { display:flex; justify-content:space-between; align-items:center; margin-top:22px; padding:13px 14px; border-radius:6px; color:#071d32; background:#f5c95d; font:700 13px Arial,sans-serif; text-decoration:none; transition:background .2s ease; }
        .ticket-platform a:hover, .ticket-platform a:focus-visible { background:#ffd978; }
        .ticket-note { margin:22px 0 0; padding:15px 18px; border-left:4px solid #e9783f; color:#0a5d85; background:#dfeef6; font:13px/1.6 Arial,sans-serif; }
        .dashboard-nav { background:#071d32; color:#fff; }
        .dashboard-nav-inner { max-width:1180px; margin:0 auto; padding:16px 24px; display:flex; justify-content:space-between; align-items:center; gap:24px; }
        .dashboard-brand { display:flex; align-items:center; gap:10px; color:#fff; font:800 15px Arial,sans-serif; letter-spacing:.08em; text-decoration:none; }
        .dashboard-brand-mark { display:grid; place-items:center; width:34px; height:34px; border-radius:8px; background:#f5c95d; }
        .dashboard-brand-mark svg { width:22px; fill:none; stroke:#071d32; stroke-linecap:round; stroke-linejoin:round; stroke-width:2; }
        .dashboard-brand-logo { width:34px; height:34px; padding:4px; border-radius:8px; object-fit:contain; background:#fff; }
        .dashboard-links { display:flex; gap:20px; align-items:center; }
        .dashboard-links a { color:rgba(255,255,255,.82); font:700 13px Arial,sans-serif; text-decoration:none; }
        .dashboard-links a:hover,.dashboard-links a.active { color:#f5c95d; }
        .dashboard-main { max-width:1180px; margin:0 auto; padding:48px 24px 80px; }
        .dashboard-alert { margin-bottom:22px; padding:13px 16px; border-left:4px solid #e9783f; color:#0a5d85; background:#dfeef6; font:14px Arial,sans-serif; }
        .dashboard-hero { min-height:320px; display:flex; align-items:flex-end; padding:42px; border-radius:12px; color:#fff; background:linear-gradient(135deg,rgba(7,29,50,.96),rgba(10,93,133,.86)),linear-gradient(135deg,#0a5d85,#071d32); box-shadow:12px 12px 0 #f5c95d; }
        .dashboard-hero-content { max-width:720px; }
        .dashboard-eyebrow { color:#e9783f; font:700 11px Arial,sans-serif; letter-spacing:.15em; text-transform:uppercase; }
        .dashboard-hero h1 { margin:14px 0 16px; font:500 clamp(38px,6vw,72px)/.95 Georgia,serif; }
        .dashboard-hero p { max-width:620px; color:rgba(255,255,255,.82); font:15px/1.6 Arial,sans-serif; }
        .dashboard-actions { display:flex; flex-wrap:wrap; gap:10px; margin-top:24px; }
        .dashboard-button { padding:13px 16px; border-radius:5px; font:700 13px Arial,sans-serif; text-decoration:none; }
        .dashboard-button.primary { color:#071d32; background:#f5c95d; }
        .dashboard-button.secondary { color:#fff; border:1px solid rgba(255,255,255,.35); }
        .quick-section { padding:64px 0 10px; }
        .quick-heading { display:flex; justify-content:space-between; gap:28px; align-items:end; margin-bottom:24px; }
        .quick-heading h2 { margin:10px 0 0; color:#0a5d85; font:500 clamp(30px,4vw,46px)/1 Georgia,serif; }
        .quick-heading p { max-width:340px; margin:0; color:#5b6c7a; font:14px/1.6 Arial,sans-serif; }
        .quick-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:14px; }
        .quick-card { padding:24px; border:1px solid #dfe7ec; border-radius:9px; color:#1d2b35; background:#fffdf7; text-decoration:none; transition:transform .2s,box-shadow .2s; }
        .quick-card:hover { transform:translateY(-5px); box-shadow:0 12px 0 #dfeef6; }
        .quick-icon { display:block; width:30px; height:30px; margin-bottom:24px; }
        .quick-icon svg { width:100%; height:100%; fill:none; stroke:#e9783f; stroke-linecap:round; stroke-linejoin:round; stroke-width:1.8; }
        .quick-card h3 { margin:0 0 8px; color:#0a5d85; font:500 25px Georgia,serif; }
        .quick-card p { margin:0; color:#5b6c7a; font:14px/1.5 Arial,sans-serif; }
        .data-section { padding:64px 0 0; }
        .data-section-head { display:flex; justify-content:space-between; align-items:end; gap:24px; margin-bottom:22px; }
        .data-section-head h2 { margin:10px 0 0; color:#0a5d85; font:500 clamp(30px,4vw,46px)/1 Georgia,serif; }
        .data-section-head a { color:#0a5d85; font:700 13px Arial,sans-serif; text-decoration:none; }
        .destination-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:14px; }
        .destination-card { padding:22px; border:1px solid #dfe7ec; border-radius:9px; color:#1d2b35; background:#fffdf7; text-decoration:none; transition:transform .2s,box-shadow .2s; }
        .destination-card:hover { transform:translateY(-5px); box-shadow:0 12px 0 #dfeef6; }
        .destination-card .city-chip { display:grid; place-items:center; width:38px; height:38px; margin-bottom:20px; border-radius:50%; color:#071d32; background:#f5c95d; font:800 12px Arial,sans-serif; }
        .destination-card h3 { margin:0 0 7px; color:#0a5d85; font:500 24px Georgia,serif; }
        .destination-card p { margin:0; color:#5b6c7a; font:13px/1.5 Arial,sans-serif; }
        .schedule-wrap { overflow-x:auto; border:1px solid #dfe7ec; border-radius:9px; background:#fffdf7; }
        .schedule-table { width:100%; border-collapse:collapse; min-width:560px; }
        .schedule-table th { padding:13px 16px; color:#071d32; background:#dfeef6; text-align:left; font:700 12px Arial,sans-serif; }
        .schedule-table td { padding:13px 16px; border-top:1px solid #dfe7ec; color:#5b6c7a; font:14px Arial,sans-serif; }
        .schedule-table td strong { color:#0a5d85; }
        @media (max-width:760px) { .dashboard-nav-inner { padding:14px 18px; } .dashboard-links { gap:10px; } .dashboard-links a { font-size:11px; } .dashboard-main { padding:32px 18px 60px; } .dashboard-hero { min-height:360px; padding:28px; box-shadow:7px 7px 0 #f5c95d; } .quick-heading,.data-section-head { display:block; } .quick-heading p { margin-top:16px; } .data-section-head a { display:inline-block; margin-top:16px; } .quick-grid,.destination-grid { grid-template-columns:1fr; } .ticket-purchase-section { padding:22px; } .ticket-purchase-heading { display:block; } .ticket-purchase-heading p { margin-top:18px; } .ticket-purchase-layout,.ticket-platforms { grid-template-columns:1fr; } .ticket-platform { min-height:200px; } }
    </style>
</head>
<body>
    <header class="dashboard-nav">
        <div class="dashboard-nav-inner">
            <a class="dashboard-brand" href="/PurabayaGo/public/index.php/" aria-label="PURABAYA GO Home">
                <?php if (!empty($logoImage)): ?><img class="dashboard-brand-logo" src="<?= base_url('uploads/homepage/' . rawurlencode($logoImage) . '?v=' . time()) ?>" alt="<?= esc($logoAlt) ?>"><?php else: ?><span class="dashboard-brand-mark" aria-hidden="true">
                    <svg viewBox="0 0 48 48"><path d="M9 31V17c0-3 2-5 5-5h20c3 0 5 2 5 5v14M7 31h34M12 31v4M36 31v4M14 18h20M17 23h5M26 23h5"/><circle cx="14" cy="32" r="3"/><circle cx="34" cy="32" r="3"/></svg>
                </span><?php endif; ?>
                <span>PURABAYA GO</span>
            </a>
            <nav class="dashboard-links" aria-label="Navigasi pengguna">
                <a class="active" href="/PurabayaGo/public/index.php/user/dashboard">Dashboard</a>
                <a href="/PurabayaGo/public/index.php/user/profile">Profile</a>
                <a href="/PurabayaGo/public/index.php/destinations">Tujuan</a>
                <a href="/PurabayaGo/public/index.php/guide">Guide</a>
                <a href="/PurabayaGo/public/index.php/about">About</a>
                <a href="/PurabayaGo/public/index.php/logout">Logout</a>
            </nav>
        </div>
    </header>

    <main class="dashboard-main">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="dashboard-alert"><?= esc(session()->getFlashdata('success')) ?></div>
        <?php endif; ?>

        <section class="dashboard-hero">
            <div class="dashboard-hero-content">
                <span class="dashboard-eyebrow">Terminal Purabaya / Bungurasih</span>
                <h1>Temukan Busmu.<br>Mulai Perjalananmu.</h1>
                <p>Selamat datang, <?= esc($user['nama_lengkap'] ?? session()->get('username')) ?>. Temukan informasi keberangkatan bus dari Terminal Purabaya berdasarkan tujuan, jadwal, dan estimasi tarif.</p>
                <div class="dashboard-actions">
                    <a class="dashboard-button primary" href="/PurabayaGo/public/index.php/search">Cari Bus</a>
                    <a class="dashboard-button secondary" href="/PurabayaGo/public/index.php/destinations">Jelajahi Tujuan</a>
                </div>
            </div>
        </section>

        <section class="quick-section" aria-labelledby="quick-heading">
            <div class="quick-heading">
                <div>
                    <span class="dashboard-eyebrow">Akses cepat</span>
                    <h2 id="quick-heading">Rencanakan perjalananmu</h2>
                </div>
                <p>Semua informasi penting untuk memulai perjalanan dari Terminal Purabaya tersedia di satu tempat.</p>
            </div>

            <div class="quick-grid">
                <a class="quick-card" href="/PurabayaGo/public/index.php/search">
                    <span class="quick-icon" aria-hidden="true"><svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="5"/><path d="m16 16 5 5"/></svg></span>
                    <h3>Cari Bus</h3>
                    <p>Temukan bus berdasarkan kota tujuan.</p>
                </a>
                <a class="quick-card" href="/PurabayaGo/public/index.php/destinations">
                    <span class="quick-icon" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M12 21s6-5.4 6-10a6 6 0 1 0-12 0c0 4.6 6 10 6 10Zm0-8.5a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5Z"/></svg></span>
                    <h3>Tujuan</h3>
                    <p>Lihat kota dan rute yang tersedia.</p>
                </a>
                <a class="quick-card" href="/PurabayaGo/public/index.php/guide">
                    <span class="quick-icon" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M4 5.5A2.5 2.5 0 0 1 6.5 3H20v16H6.5A2.5 2.5 0 0 0 4 21V5.5Z"/><path d="M4 5.5V21M8 7h8M8 11h8"/></svg></span>
                    <h3>Guide</h3>
                    <p>Pelajari cara menggunakan portal.</p>
                </a>
            </div>
        </section>

        <section class="data-section" aria-labelledby="destination-heading">
            <div class="data-section-head">
                <div>
                    <span class="dashboard-eyebrow">Data perjalanan</span>
                    <h2 id="destination-heading">Tujuan Populer</h2>
                </div>
                <a href="/PurabayaGo/public/index.php/destinations">Lihat semua tujuan</a>
            </div>
            <div class="destination-grid">
                <?php foreach ($featuredDestinations as $destination): ?>
                    <a class="destination-card" href="/PurabayaGo/public/index.php/search/destination?destination_id=<?= esc($destination['id']) ?>">
                        <span class="city-chip"><?= esc(strtoupper(substr($destination['destination_name'], 0, 2))) ?></span>
                        <h3><?= esc($destination['destination_name']) ?></h3>
                        <p><?= $destination['bus_count'] ?> bus<?php if ($destination['min_fare'] !== null): ?> · Mulai Rp<?= number_format((float) $destination['min_fare'], 0, ',', '.') ?><?php endif; ?></p>
                    </a>
                <?php endforeach; ?>
            </div>
        </section>

        <section class="ticket-purchase-section" aria-labelledby="ticket-purchase-heading">
            <div class="ticket-purchase-heading">
                <div>
                    <span class="ticket-purchase-eyebrow">Pembelian tiket</span>
                    <h2 id="ticket-purchase-heading">🎫 Beli Tiket Bus</h2>
                </div>
                <p>Sudah menemukan bus dan tujuanmu?<br>Lanjutkan pembelian tiket melalui platform resmi berikut.</p>
            </div>

            <div class="ticket-purchase-layout">
                <aside class="trip-summary" aria-label="Ringkasan perjalanan">
                    <h3>Perjalananmu</h3>
                    <p>📍 Dari: Terminal Purabaya</p>
                    <p>📍 Tujuan: Belum dipilih</p>
                    <p>🚌 Bus: Belum dipilih</p>
                    <p>🏢 Shelter: Belum dipilih</p>
                    <p>💰 Estimasi tarif: Belum tersedia</p>
                </aside>

                <div class="ticket-platforms">
                    <article class="ticket-platform">
                        <div>
                            <img class="ticket-platform-logo redbus-logo" src="<?= base_url('images/redbus-logo.png') ?>" alt="Logo RedBus" width="100" height="66">
                            <h3>RedBus</h3>
                            <p>Pesan tiket bus secara online melalui RedBus.</p>
                        </div>
                        <a href="https://www.redbus.id/" target="_blank" rel="noopener noreferrer" aria-label="Beli tiket di RedBus, membuka tab baru">Beli Tiket di RedBus <span aria-hidden="true">→</span></a>
                    </article>
                    <article class="ticket-platform">
                        <div>
                            <img class="ticket-platform-logo" src="https://www.google.com/s2/favicons?domain=traveloka.com&sz=128" alt="Logo Traveloka" width="64" height="64">
                            <h3>Traveloka</h3>
                            <p>Temukan dan pesan tiket bus melalui Traveloka.</p>
                        </div>
                        <a href="https://www.traveloka.com/id-id/bus-and-shuttle" target="_blank" rel="noopener noreferrer" aria-label="Beli tiket di Traveloka, membuka tab baru">Beli Tiket di Traveloka <span aria-hidden="true">→</span></a>
                    </article>
                </div>
            </div>

            <p class="ticket-note">ℹ️ PURABAYA GO tidak melayani pembelian tiket dan tidak memproses pembayaran. Tiket dapat dibeli melalui RedBus, Traveloka, atau langsung di loket/tempat pembelian tiket di terminal.<br><br>Pastikan memeriksa kembali tujuan, jadwal, tarif, dan ketentuan sebelum melakukan transaksi.</p>
        </section>
    </main>
</body>
</html>
