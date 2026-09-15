<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategori Bus - PURABAYA GO</title>
    <style>
        body { font-family: Arial, sans-serif; margin:0; background:#f6f3ea; color:#17211b; }
        nav { background:#071d32; color:#fff; padding:18px 24px; display:flex; justify-content:space-between; }
        nav a { color:#fff; text-decoration:none; margin-left:18px; }
        .wrap { max-width:1100px; margin:40px auto; padding:0 16px; }
        .hero { background:#fff; border-radius:16px; padding:24px; box-shadow:0 10px 25px rgba(0,0,0,.05); }
        .grid { display:grid; grid-template-columns:repeat(auto-fit, minmax(180px,1fr)); gap:18px; margin-top:24px; }
        .card { background:#fff; border-radius:14px; padding:24px; box-shadow:0 10px 25px rgba(0,0,0,.05); text-align:center; }
        .btn { display:inline-block; border-radius:12px; padding:12px 16px; text-decoration:none; font-weight:bold; }
        .active { background:#0a5d85; color:#fff; }
        .disabled { background:#e9ecef; color:#6c757d; pointer-events:none; }
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
            <h2>Purabaya → <?= esc($destination['destination_name'] ?? '') ?></h2>
            <p>Pilih Kategori Bus</p>
        </div>

        <div class="grid">
            <?php foreach ($categories as $category): ?>
                <?php if ($category['available']): ?>
                    <div class="card">
                        <a class="btn active" href="<?= site_url('search/category?destination_id=' . esc($selectedDestinationId) . '&category=' . esc($category['value'])) ?>"><?= esc($category['label']) ?></a>
                    </div>
                <?php else: ?>
                    <div class="card">
                        <span class="btn disabled">Belum tersedia</span>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
