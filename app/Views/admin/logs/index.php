<?= $this->extend('admin/layouts/base') ?>

<?= $this->section('content') ?>

<style>
    .table-card { background: white; border-radius: 14px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,.05); }
    .data-table { width: 100%; border-collapse: collapse; }
    .data-table th { background: #f8f9fa; padding: 14px; text-align: left; border-bottom: 2px solid #dee2e6; font-size: 13px; }
    .data-table td { padding: 14px; border-bottom: 1px solid #dee2e6; }
    .data-table tr:hover { background: #f8f9fa; }
    .pagination { padding: 16px; text-align: center; }
    .pagination a, .pagination span { margin: 0 4px; padding: 6px 10px; border: 1px solid #dee2e6; text-decoration: none; color: #0d6efd; border-radius: 4px; }
    .pagination .active { background: #0d6efd; color: white; border-color: #0d6efd; }
    .badge { display: inline-block; padding: 4px 8px; border-radius: 4px; font-size: 11px; font-weight: 500; background: #e8f1ff; color: #0d6efd; }
</style>

<h2 style="margin-bottom: 24px;">Activity Logs</h2>

<div class="table-card">
    <table class="data-table">
        <thead>
            <tr>
                <th>User</th>
                <th>Aksi</th>
                <th>Deskripsi</th>
                <th>IP Address</th>
                <th>Waktu</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($logs)): ?>
                <tr>
                    <td colspan="5" style="text-align: center; padding: 40px;">Belum ada activity logs.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($logs as $log): ?>
                    <tr>
                        <td>
                            <strong><?= esc($log['nama_lengkap'] ?? $log['username'] ?? '-') ?></strong><br>
                            <span style="font-size: 12px; color: #999;">@<?= esc($log['username'] ?? '-') ?></span>
                        </td>
                        <td><span class="badge"><?= esc($log['action']) ?></span></td>
                        <td><?= esc($log['description'] ?? '-') ?></td>
                        <td style="font-size: 12px;"><?= esc($log['ip_address'] ?? '-') ?></td>
                        <td style="font-size: 12px; color: #999;">
                            <?= date('d M Y', strtotime($log['created_at'])) ?><br>
                            <?= date('H:i:s', strtotime($log['created_at'])) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php if ($pager): ?>
    <div class="pagination">
        <?= $pager->links() ?>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>
