<?= $this->extend('admin/layouts/base') ?>

<?= $this->section('content') ?>

<style>
    .dashboard-intro { display:flex; justify-content:space-between; align-items:flex-end; gap:24px; margin-bottom:24px; padding:30px 32px; border-radius:14px; color:#fff; background:linear-gradient(135deg,#071d32,#0a5d85); box-shadow:10px 10px 0 var(--yellow); }
    .dashboard-intro-kicker { color:var(--yellow); font-size:11px; font-weight:800; letter-spacing:.14em; text-transform:uppercase; }
    .dashboard-intro h1 { margin:10px 0 8px; font:500 clamp(28px,4vw,46px)/1 Georgia,serif; }
    .dashboard-intro p { max-width:600px; margin:0; color:rgba(255,255,255,.78); font-size:14px; line-height:1.55; }
    .dashboard-intro-actions { display:flex; flex-wrap:wrap; gap:10px; }
    .dashboard-intro-actions a { padding:11px 14px; border-radius:7px; color:#071d32; background:var(--yellow); font-size:12px; font-weight:800; text-decoration:none; }
    .dashboard-intro-actions a.secondary { color:#fff; border:1px solid rgba(255,255,255,.35); background:transparent; }
    .stats-grid { grid-template-columns:repeat(5,minmax(140px,1fr)); gap:14px; margin:28px 0; }
    .stat-card { min-height:120px; padding:18px; border-radius:12px; border-left-width:4px; box-shadow:0 8px 18px rgba(23,76,58,.08); }
    .stat-card h4 { display:flex; align-items:center; gap:8px; margin-bottom:14px; font-size:12px; }
    .stat-card h4 i { color:var(--orange); }
    .stat-card .value { font-size:30px; }
    .content-row { display:grid; grid-template-columns:1.25fr .75fr; gap:18px; margin-bottom:18px; }
    .chart-card { min-width:0; padding:22px; border:1px solid var(--line); border-radius:12px; background:var(--card); box-shadow:0 8px 18px rgba(23,76,58,.07); }
    .chart-heading { display:flex; justify-content:space-between; align-items:flex-start; gap:12px; margin-bottom:20px; }
    .chart-card h3 { margin:0; color:var(--green-deep); font-size:16px; }
    .chart-heading p { margin:4px 0 0; color:var(--muted); font-size:12px; }
    .chart-total { color:var(--blue,#0a5d85); font-size:20px; font-weight:800; }
    .bar-chart { display:grid; gap:13px; }
    .bar-row { display:grid; grid-template-columns:minmax(90px,.7fr) 2fr 34px; align-items:center; gap:10px; font-size:12px; }
    .bar-label { overflow:hidden; color:var(--ink); text-overflow:ellipsis; white-space:nowrap; }
    .bar-track { height:9px; overflow:hidden; border-radius:99px; background:var(--green-light); }
    .bar-fill { height:100%; min-width:4px; border-radius:inherit; background:linear-gradient(90deg,#0a5d85,#f4b63b); }
    .bar-value { color:var(--green-deep); font-weight:800; text-align:right; }
    .empty-chart { padding:22px 0; color:var(--muted); font-size:13px; }
    .log-table { width:100%; border-collapse:collapse; }
    .log-table th { padding:11px 12px; color:var(--muted); background:var(--green-light); text-align:left; font-size:11px; letter-spacing:.04em; text-transform:uppercase; }
    .log-table td { padding:12px; border-bottom:1px solid var(--line); font-size:13px; }
    .log-table tr:hover { background:#f5f8f0; }
    .log-action { display:inline-block; padding:4px 8px; border-radius:99px; color:#0a5d85; background:#dfeef6; font-size:11px; font-weight:800; }
    .log-time { color:var(--muted); white-space:nowrap; }
    @media (max-width:1050px) { .stats-grid { grid-template-columns:repeat(3,1fr); } .content-row { grid-template-columns:1fr; } }
    @media (max-width:650px) { .dashboard-intro { display:block; padding:24px; box-shadow:6px 6px 0 var(--yellow); } .dashboard-intro-actions { margin-top:20px; } .stats-grid { grid-template-columns:repeat(2,1fr); } .stat-card { min-height:105px; } .stat-card .value { font-size:26px; } .chart-card { padding:18px; overflow:hidden; } .bar-row { grid-template-columns:85px minmax(100px,1fr) 25px; gap:7px; } .log-table { min-width:620px; } .chart-card:has(.log-table) { overflow-x:auto; } }
</style>

<?php
    $destinationMax = max(array_map(static fn (array $item): int => (int) $item['count'], $busPerDestination ?: [ ['count' => 0] ]));
    $categoryMax = max(array_map(static fn (array $item): int => (int) $item['count'], $busPerCategory ?: [ ['count' => 0] ]));
    $totalCategories = array_sum(array_map(static fn (array $item): int => (int) $item['count'], $busPerCategory));
?>

<section class="dashboard-intro">
    <div>
        <span class="dashboard-intro-kicker">Ringkasan operasional</span>
        <h1>Admin Dashboard</h1>
        <p>Pantau data bus, tujuan, pengguna, dan aktivitas terbaru PURABAYA GO dari satu halaman.</p>
    </div>
    <div class="dashboard-intro-actions">
        <a href="<?= site_url('admin/bus/create') ?>">+ Tambah Bus</a>
        <a class="secondary" href="<?= site_url('admin/destination/create') ?>">+ Tambah Tujuan</a>
    </div>
</section>

<div class="stats-grid">
    <div class="stat-card"><h4><i class="fas fa-bus"></i> Total Bus</h4><div class="value"><?= $stats['total_bus'] ?? 0 ?></div></div>
    <div class="stat-card" style="border-left-color:var(--green);"><h4><i class="fas fa-map-marker-alt"></i> Total Tujuan</h4><div class="value"><?= $stats['total_destination'] ?? 0 ?></div></div>
    <div class="stat-card" style="border-left-color:var(--yellow);"><h4><i class="fas fa-users"></i> Total Users</h4><div class="value"><?= $stats['total_users'] ?? 0 ?></div></div>
    <div class="stat-card" style="border-left-color:var(--orange);"><h4><i class="fas fa-user-shield"></i> Admin</h4><div class="value"><?= $stats['total_admins'] ?? 0 ?></div></div>
</div>

<div class="content-row">
    <div class="chart-card">
        <div class="chart-heading"><div><h3>Bus per Tujuan</h3><p>Distribusi layanan berdasarkan kota</p></div><span class="chart-total"><?= count($busPerDestination) ?></span></div>
        <?php if ($busPerDestination): ?><div class="bar-chart">
            <?php foreach ($busPerDestination as $item): ?><div class="bar-row"><span class="bar-label" title="<?= esc($item['destination_name'] ?? 'Unknown') ?>"><?= esc($item['destination_name'] ?? 'Unknown') ?></span><div class="bar-track"><div class="bar-fill" style="width:<?= $destinationMax ? (int) round(((int) $item['count'] / $destinationMax) * 100) : 0 ?>%;"></div></div><span class="bar-value"><?= (int) $item['count'] ?></span></div><?php endforeach; ?>
        </div><?php else: ?><p class="empty-chart">Belum ada data tujuan.</p><?php endif; ?>
    </div>

    <div class="chart-card">
        <div class="chart-heading"><div><h3>Bus per Kategori</h3><p>Komposisi kelas bus</p></div><span class="chart-total"><?= $totalCategories ?></span></div>
        <?php if ($busPerCategory): ?><div class="bar-chart">
            <?php foreach ($busPerCategory as $item): ?><div class="bar-row"><span class="bar-label"><?= esc(ucfirst($item['bus_class'])) ?></span><div class="bar-track"><div class="bar-fill" style="width:<?= $categoryMax ? (int) round(((int) $item['count'] / $categoryMax) * 100) : 0 ?>%;"></div></div><span class="bar-value"><?= (int) $item['count'] ?></span></div><?php endforeach; ?>
        </div><?php else: ?><p class="empty-chart">Belum ada data kategori.</p><?php endif; ?>
    </div>
</div>

<div class="chart-card">
    <div class="chart-heading"><div><h3>Aktivitas Terbaru</h3><p>Lima aktivitas terakhir di panel admin</p></div><a href="<?= site_url('admin/logs') ?>" style="color:var(--blue,#0a5d85);font-size:12px;font-weight:800;text-decoration:none;">Lihat semua &rarr;</a></div>
    <table class="log-table">
        <tr>
            <th>User</th>
            <th>Aksi</th>
            <th>Deskripsi</th>
            <th>Waktu</th>
        </tr>
        <?php foreach ($recentLogs as $log): ?>
            <tr>
                <td><?= esc($log['nama_lengkap'] ?? $log['username'] ?? '-') ?></td>
                <td><span class="log-action"><?= esc($log['action']) ?></span></td>
                <td><?= esc($log['description'] ?? '-') ?></td>
                <td class="log-time"><?= date('d M Y H:i', strtotime($log['created_at'])) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>

<?= $this->endSection() ?>
