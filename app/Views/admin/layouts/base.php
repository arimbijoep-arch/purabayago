<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - PURABAYA GO</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --ink: #17211b;
            --muted: #68736b;
            --paper: #f6f3ea;
            --card: #fffdf7;
            --green: #174c3a;
            --green-deep: #0c3027;
            --green-light: #dce9d8;
            --orange: #e9783f;
            --line: #d9ded4;
            --yellow: #f5c95d;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            color: var(--ink);
            background-color: var(--paper);
            background-image: linear-gradient(rgba(23,76,58,.035) 1px, transparent 1px), linear-gradient(90deg, rgba(23,76,58,.035) 1px, transparent 1px);
            background-size: 32px 32px;
            font-family: 'Manrope', Arial, sans-serif;
        }
        
        .admin-container { display: flex; min-height: 100vh; }
        
        .admin-sidebar {
            width: 260px;
            background: var(--green-deep);
            color: white;
            padding: 24px 16px;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
        }
        
        .admin-sidebar h3 {
            margin-bottom: 24px;
            font-size: 18px;
            font-weight: bold;
            text-align: center;
            padding-bottom: 16px;
            border-bottom: 1px solid rgba(255,255,255,.18);
        }
        
        .admin-sidebar ul { list-style: none; }
        .admin-sidebar li { margin-bottom: 12px; }
        .admin-sidebar a {
            display: flex;
            align-items: center;
            padding: 12px 16px;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            transition: background 0.2s, transform 0.2s;
        }
        
        .admin-sidebar a:hover,
        .admin-sidebar a.active {
            color: var(--green-deep);
            background: var(--yellow);
            transform: translateX(3px);
        }
        
        .admin-sidebar a i { margin-right: 12px; width: 20px; }
        
        .admin-main {
            margin-left: 260px;
            flex: 1;
            padding: 24px;
            max-width: 1400px;
        }
        
        .admin-header {
            background: var(--card);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 8px 18px rgba(23,76,58,.08);
            margin-bottom: 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .admin-header h2 { color: var(--green-deep); }
        .admin-header .user-info { text-align: right; }
        .admin-header .user-info p { font-size: 14px; color: var(--muted); }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 24px;
        }
        
        .stat-card {
            background: var(--card);
            padding: 24px;
            border-radius: 10px;
            box-shadow: 0 8px 18px rgba(23,76,58,.08);
            border-left: 4px solid var(--orange);
        }
        
        .stat-card h4 { color: var(--muted); font-size: 14px; margin-bottom: 8px; }
        .stat-card .value { font-size: 32px; font-weight: bold; color: var(--green-deep); }
        
        .btn { display: inline-block; padding: 10px 16px; border-radius: 10px; text-decoration: none; cursor: pointer; border: none; }
        .btn-primary { background: var(--green); color: white; }
        .btn-primary:hover { background: var(--green-deep); }
        .btn-danger { background: var(--orange); color: white; }
        .btn-success { background: var(--green); color: white; }
        
        .alert {
            padding: 16px;
            border-radius: 6px;
            margin-bottom: 20px;
        }
        
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-danger { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }

        .pager-nav { display: flex; justify-content: space-between; align-items: center; gap: 16px; margin-top: 18px; padding: 14px 16px; border: 1px solid var(--line); border-radius: 12px; background: rgba(255,253,247,.92); box-shadow: 0 8px 18px rgba(23,76,58,.06); }
        .pager-summary { color: var(--muted); font-size: 13px; white-space: nowrap; }
        .pager-list { display: flex; flex-wrap: wrap; justify-content: flex-end; gap: 6px; align-items: center; margin: 0; padding: 0; list-style: none; }
        .pager-link { display: inline-flex; min-width: 36px; min-height: 34px; align-items: center; justify-content: center; padding: 7px 11px; border: 1px solid var(--line); border-radius: 8px; color: var(--green); background: #fff; font-size: 13px; line-height: 1; text-decoration: none; transition: background .2s, color .2s, border-color .2s; }
        .pager-arrow { font-size: 20px; font-weight: 700; }
        a.pager-link:hover { color: var(--green-deep); border-color: var(--green); background: var(--green-light); }
        .pager-list .is-active .pager-link { color: #fff; border-color: var(--green); background: var(--green); font-weight: 800; }


        @media (max-width: 760px) {
            .admin-sidebar { width: 76px; padding: 18px 10px; }
            .admin-sidebar h3 { font-size: 0; }
            .admin-sidebar h3 i { font-size: 18px; }
            .admin-sidebar a { justify-content: center; padding: 12px 8px; }
            .admin-sidebar a i { margin-right: 0; }
            .admin-sidebar a { font-size: 0; }
            .admin-main { margin-left: 76px; padding: 16px; }
            .admin-header { align-items: flex-start; gap: 16px; flex-direction: column; }
            .admin-header .user-info { text-align: left; }
            .pager-nav { align-items: stretch; flex-direction: column; }
            .pager-list { justify-content: flex-start; }
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <?php $adminSettings = new \App\Models\SettingModel(); $adminLogo = $adminSettings->getValue('logo_image'); $adminLogoAlt = $adminSettings->getValue('logo_alt', 'PURABAYA GO'); ?>
        <!-- Sidebar -->
        <aside class="admin-sidebar">
            <h3><?php if ($adminLogo): ?><img src="<?= base_url('uploads/homepage/' . rawurlencode($adminLogo)) ?>" alt="<?= esc($adminLogoAlt) ?>" style="max-width: 130px; max-height: 42px; object-fit: contain; vertical-align: middle;"><?php else: ?><i class="fas fa-cogs"></i> Admin Panel<?php endif; ?></h3>
            <ul>
                <li><a href="<?= site_url('admin/dashboard') ?>" class="<?= (uri_string() == 'admin/dashboard') ? 'active' : '' ?>"><i class="fas fa-chart-line"></i> Dashboard</a></li>
                <li><a href="<?= site_url('admin/destination') ?>" class="<?= (strpos(uri_string(), 'admin/destination') === 0) ? 'active' : '' ?>"><i class="fas fa-map-marker-alt"></i> Tujuan</a></li>
                <li><a href="<?= site_url('admin/bus') ?>" class="<?= (strpos(uri_string(), 'admin/bus') === 0) ? 'active' : '' ?>"><i class="fas fa-bus"></i> Bus</a></li>
                <li><a href="<?= site_url('admin/users') ?>" class="<?= (strpos(uri_string(), 'admin/users') === 0) ? 'active' : '' ?>"><i class="fas fa-users"></i> Users</a></li>
                <li><a href="<?= site_url('admin/logs') ?>" class="<?= (strpos(uri_string(), 'admin/logs') === 0) ? 'active' : '' ?>"><i class="fas fa-history"></i> Activity Logs</a></li>
                <li><a href="<?= site_url('admin/settings/homepage') ?>" class="<?= (strpos(uri_string(), 'admin/settings') === 0) ? 'active' : '' ?>"><i class="fas fa-images"></i> Pengaturan Homepage</a></li>
                <li><a href="<?= site_url('logout') ?>"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="admin-main">
            <div class="admin-header">
                <?php if (!empty($title)): ?><h2><?= esc($title) ?></h2><?php endif; ?>
                <div class="user-info">
                    <p>Masuk sebagai: <strong><?= esc(session()->get('username') ?? 'Admin') ?></strong></p>
                    <p style="font-size: 12px; margin-top: 4px; color: #999;"><?= date('d M Y H:i') ?> WIB</p>
                </div>
            </div>

            <?php if (session()->has('success')): ?>
                <div class="alert alert-success"><?= session('success') ?></div>
            <?php endif; ?>

            <?php if (session()->has('error')): ?>
                <div class="alert alert-danger"><?= session('error') ?></div>
            <?php endif; ?>

            <?= $this->renderSection('content') ?>
        </main>
    </div>
</body>
</html>
