<?= $this->extend('admin/layouts/base') ?>

<?= $this->section('content') ?>

<style>
    .content-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
    .table-card { background: white; border-radius: 14px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,.05); }
    .data-table { width: 100%; border-collapse: collapse; }
    .data-table th { background: #f8f9fa; padding: 14px; text-align: left; border-bottom: 2px solid #dee2e6; }
    .data-table td { padding: 14px; border-bottom: 1px solid #dee2e6; }
    .data-table tr:hover { background: #f8f9fa; }
    .btn-small { padding: 6px 12px; font-size: 12px; }
    .pagination { padding: 16px; text-align: center; }
    .pagination a, .pagination span { margin: 0 4px; padding: 6px 10px; border: 1px solid #dee2e6; text-decoration: none; color: #0d6efd; border-radius: 4px; }
    .pagination .active { background: #0d6efd; color: white; border-color: #0d6efd; }
</style>

<div class="content-header">
    <h2>Kelola Tujuan</h2>
    <a href="<?= site_url('admin/destination/create') ?>" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Tujuan</a>
</div>

<div class="table-card">
    <table class="data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Foto</th>
                <th>Nama Tujuan</th>
                <th>Deskripsi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($destinations)): ?>
                <tr>
                    <td colspan="5" style="text-align: center; padding: 40px;">Belum ada tujuan.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($destinations as $dest): ?>
                    <tr>
                        <td><?= $dest['id'] ?></td>
                        <td><?php if (!empty($dest['photo'])): ?><img src="<?= base_url('uploads/destinations/' . rawurlencode($dest['photo'])) ?>" alt="<?= esc($dest['photo_alt'] ?? 'Foto ' . $dest['destination_name']) ?>" style="width: 64px; height: 42px; object-fit: cover; border-radius: 6px;"><?php else: ?><span style="color: #6c757d; font-size: 11px;">Belum ada</span><?php endif; ?></td>
                        <td><strong><?= esc($dest['destination_name']) ?></strong></td>
                        <td><?= esc(substr($dest['description'] ?? '', 0, 50)) ?>...</td>
                        <td>
                            <a href="<?= site_url('admin/destination/edit/' . $dest['id']) . '?page=' . $page ?>" class="btn btn-primary btn-small">Edit</a>
                            <a href="<?= site_url('admin/destination/delete/' . $dest['id']) ?>" class="btn btn-danger btn-small" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
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
