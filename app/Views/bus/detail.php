<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Bus - PURABAYA GO</title>
    <style>
        :root { --navy:#071d32; --blue:#0a5d85; --blue-soft:#e8f1f8; --cream:#f6f3ea; --ink:#17211b; --muted:#567080; --line:#d9e2e8; --yellow:#f4c542; }
        * { box-sizing:border-box; }
        body { font-family:Arial, sans-serif; margin:0; background:var(--cream); color:var(--ink); }
        nav { background:var(--navy); color:#fff; padding:18px 24px; display:flex; justify-content:space-between; align-items:center; gap:20px; }
        nav a { color:#fff; text-decoration:none; margin-left:18px; }
        nav a:hover, nav a:focus-visible { color:var(--yellow); }
        .wrap { max-width:940px; margin:40px auto; padding:0 16px 48px; }
        .card { background:#fff; border:1px solid rgba(10,93,133,.08); border-radius:20px; padding:32px; box-shadow:0 18px 42px rgba(7,29,50,.10); }
        .category-heading { color:var(--muted); font-size:12px; font-weight:700; letter-spacing:.12em; margin:0 0 12px; text-transform:uppercase; }
        .category-list { display:flex; flex-wrap:wrap; gap:10px; margin-bottom:26px; }
        .category-link { background:var(--blue-soft); border:1px solid transparent; border-radius:999px; color:var(--blue); font-size:13px; font-weight:700; padding:10px 16px; text-decoration:none; transition:background .2s ease, border-color .2s ease, transform .2s ease; }
        .category-link:hover, .category-link:focus-visible { border-color:var(--blue); transform:translateY(-1px); }
        .category-link.active { background:var(--navy); color:#fff; box-shadow:0 5px 12px rgba(7,29,50,.16); }
        .eyebrow { color:var(--blue); font-size:13px; font-weight:700; letter-spacing:.08em; text-transform:uppercase; }
        h1 { color:var(--navy); font-size:clamp(32px, 5vw, 48px); line-height:1; margin:10px 0 18px; }
        .route { color:#425b69; font-size:16px; margin:0 0 14px; }
        .bus-photo { display:block; width:100%; max-height:360px; object-fit:cover; border-radius:14px; margin:18px 0 8px; }
        .photo-placeholder { display:grid; min-height:190px; place-items:center; margin:18px 0; border:1px dashed #b8ccd8; border-radius:14px; color:var(--muted); background:var(--blue-soft); text-align:center; }
        .photo-placeholder strong { display:block; color:var(--navy); font-size:18px; margin-bottom:5px; }
        .photo-caption { color:var(--muted); font-size:13px; margin:0 0 18px; }
        .operator-gallery { display:grid; grid-template-columns:repeat(auto-fit,minmax(180px,1fr)); gap:14px; margin:18px 0 24px; }
        .operator-photo-card { overflow:hidden; border:1px solid var(--line); border-radius:12px; background:#fff; }
        .operator-photo-card img, .operator-photo-empty { display:grid; width:100%; height:140px; place-items:center; object-fit:cover; background:var(--blue-soft); color:var(--muted); font-size:12px; text-align:center; }
        .operator-photo-name { display:block; padding:10px 12px; color:var(--navy); font-size:13px; font-weight:700; }
        .shelter { color:var(--muted); font-weight:bold; }
        .row { display:grid; grid-template-columns:1fr 1fr; gap:28px; margin-top:24px; }
        .detail-panel { border-top:1px solid var(--line); padding-top:14px; }
        .detail-panel p { line-height:1.5; margin:10px 0; }
        .operators { padding-left:20px; line-height:1.8; }
        .schedule-box { background:var(--blue-soft); border-left:4px solid var(--blue); border-radius:12px; padding:18px; margin-top:22px; }
        .schedule-box strong { color:var(--navy); }
        .schedule-times { display:flex; flex-wrap:wrap; gap:8px; margin-top:12px; }
        .schedule-time { background:#fff; border:1px solid #d7e4ec; border-radius:8px; padding:8px 10px; color:var(--blue); font-weight:bold; }
        .schedule-note { color:#607080; margin-bottom:0; }
        .btn { display:inline-block; margin-top:22px; background:var(--blue); color:#fff; padding:13px 18px; border-radius:8px; text-decoration:none; font-weight:bold; }
        .btn:hover, .btn:focus-visible { background:var(--navy); }
        @media (max-width:700px) { nav { align-items:flex-start; flex-direction:column; } nav div { display:flex; flex-wrap:wrap; gap:10px; } nav a { margin-left:0; } .card { padding:22px; } .row { grid-template-columns:1fr; gap:8px; } }
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
        <div class="card">
            <?php
                $busCategories = [
                    'ekonomi' => 'Ekonomi',
                    'patas' => 'Patas',
                    'executive' => 'Executive',
                ];
                $activeCategory = strtolower((string) ($bus['bus_class'] ?? ''));
            ?>
            <p class="category-heading">Pilih jenis bus</p>
            <div class="category-list" aria-label="Jenis bus yang tersedia">
                <?php foreach ($busCategories as $categoryValue => $categoryLabel): ?>
                    <a class="category-link<?= $activeCategory === $categoryValue ? ' active' : '' ?>" href="<?= site_url('search/category?destination_id=' . (int) ($bus['destination_id'] ?? 0) . '&category=' . rawurlencode($categoryValue)) ?>"<?= $activeCategory === $categoryValue ? ' aria-current="page"' : '' ?>><?= esc($categoryLabel) ?></a>
                <?php endforeach; ?>
            </div>
            <div class="eyebrow">Detail keberangkatan</div>
            <?php $operatorServices = $bus['operator_services'] ?? []; ?>
            <?php if (count($operatorServices) > 1): ?><div class="operator-gallery" aria-label="Foto bus setiap operator"><?php foreach ($operatorServices as $service): ?><div class="operator-photo-card"><?php if (!empty($service['photo'])): ?><img src="<?= base_url('uploads/bus/' . rawurlencode($service['photo'])) ?>" alt="<?= esc($service['photo_alt'] ?? 'Foto bus ' . $service['operator']) ?>"><?php else: ?><div class="operator-photo-empty">Foto belum tersedia</div><?php endif; ?><span class="operator-photo-name"><?= esc($service['operator']) ?></span></div><?php endforeach; ?></div><?php elseif (!empty($bus['photo'])): ?><img class="bus-photo" src="<?= base_url('uploads/bus/' . rawurlencode($bus['photo']) . '?v=' . strtotime($bus['updated_at'] ?? 'now')) ?>" alt="<?= esc($bus['photo_alt'] ?? 'Foto ' . ($bus['operator'] ?? 'bus')) ?>"><?php if (!empty($bus['photo_caption'])): ?><p class="photo-caption"><?= esc($bus['photo_caption']) ?></p><?php endif; ?><?php else: ?><div class="photo-placeholder" role="status"><div><strong>Foto bus belum tersedia</strong><span>Informasi layanan tetap dapat dilihat di bawah.</span></div></div><?php endif; ?>
            <h1>Informasi Bus</h1>
            <p class="route"><strong>Tujuan:</strong> <?= esc($bus['destination_name'] ?? '-') ?></p>
            <p class="shelter">&#128205; Shelter <?= esc($bus['shelter_number'] ?? '-') ?></p>
            <?php $scheduleRows = $bus['schedules'] ?? []; $firstSchedule = $scheduleRows[0] ?? []; $statusLabels = ['available' => 'Jadwal tersedia', 'estimated' => 'Perkiraan jadwal', 'flexible' => 'Operasional fleksibel']; ?><div class="schedule-box"><strong>&#128336; <?= esc($statusLabels[$firstSchedule['schedule_status'] ?? 'estimated']) ?></strong><div class="schedule-times"><?php foreach ($scheduleRows as $schedule): ?><?php if (!empty($schedule['departure_time'])): ?><span class="schedule-time"><?= esc(substr($schedule['departure_time'], 0, 5)) ?></span><?php endif; ?><?php endforeach; ?></div><?php if (!empty($firstSchedule['frequency']) || !empty($firstSchedule['note'])): ?><p class="schedule-note"><?= esc(trim(($firstSchedule['frequency'] ?? '') . (($firstSchedule['frequency'] ?? '') && ($firstSchedule['note'] ?? '') ? ' · ' : '') . ($firstSchedule['note'] ?? ''))) ?></p><?php endif; ?></div>

            <div class="row">
                <div class="detail-panel">
                    <p><strong>Jam berangkat:</strong> <?= esc($bus['departure_time'] ?? '-') ?></p>
                    <p><strong>Perkiraan tarif:</strong> Rp <?= esc(number_format((float) ($bus['fare_min'] ?? $bus['fare'] ?? 0), 0, ',', '.')) ?><?php if (($bus['fare_max'] ?? $bus['fare']) > ($bus['fare_min'] ?? $bus['fare'])): ?> - Rp <?= esc(number_format((float) $bus['fare_max'], 0, ',', '.')) ?><?php endif; ?></p>
                    <p><strong>Area keberangkatan:</strong> <?= esc($bus['departure_area'] ?? '-') ?></p>
                </div>
                <div class="detail-panel">
                    <p><strong>Informasi tiket:</strong> <?= esc($bus['ticket_information'] ?? '-') ?></p>
                    <p><strong>Terakhir diperbarui:</strong> <?= esc($bus['last_updated'] ?? '-') ?></p>
                </div>
            </div>

            <p><strong>Deskripsi:</strong> <?= esc($bus['description'] ?? '-') ?></p>
            <a class="btn" href="<?= site_url('search') ?>">Kembali ke pencarian</a>
        </div>
    </div>
</body>
</html>
