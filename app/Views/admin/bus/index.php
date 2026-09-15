<?= $this->extend('admin/layouts/base') ?>

<?= $this->section('content') ?>

<style>
    .content-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
    .table-card { background: white; border-radius: 14px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,.05); }
    .data-table { width: 100%; border-collapse: collapse; }
    .data-table th { background: #f8f9fa; padding: 14px; text-align: left; border-bottom: 2px solid #dee2e6; font-size: 13px; }
    .data-table td { padding: 14px; border-bottom: 1px solid #dee2e6; }
    .data-table tr:hover { background: #f8f9fa; }
    .btn-small { padding: 6px 12px; font-size: 12px; }
    .pagination { padding: 16px; text-align: center; }
    .pagination a, .pagination span { margin: 0 4px; padding: 6px 10px; border: 1px solid #dee2e6; text-decoration: none; color: #0d6efd; border-radius: 4px; }
    .pagination .active { background: #0d6efd; color: white; border-color: #0d6efd; }
    .badge { display: inline-block; padding: 4px 8px; border-radius: 4px; font-size: 11px; font-weight: 500; }
    .badge-ekonomi { background: #e3f2fd; color: #1565c0; }
    .badge-patas { background: #fff3e0; color: #e65100; }
    .badge-executive { background: #f3e5f5; color: #6a1b9a; }
    .badge-aktif { background: #d4edda; color: #155724; }
    .badge-nonaktif { background: #f8f9fa; color: #666; }
    .bus-thumb { width: 64px; height: 42px; object-fit: cover; border-radius: 6px; display: block; }
    .bus-thumb-empty { color: #6c757d; font-size: 11px; }
</style>

<div class="content-header">
    <h2>Kelola Bus</h2>
    <a href="<?= site_url('admin/bus/create') ?>" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Bus</a>
</div>

<div class="table-card">
    <table class="data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Foto</th>
                <th>Operator</th>
                <th>Tujuan</th>
                <th>Kategori</th>
                <th>Jam</th>
                <th>Tarif</th>
                <th>Jumlah</th>
                <th>Kapasitas</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($buses)): ?>
                <tr>
                    <td colspan="11" style="text-align: center; padding: 40px;">Belum ada bus.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($buses as $bus): ?>
                    <tr>
                        <td><?= $bus['id'] ?></td>
                        <td><?php if (!empty($bus['photo'])): ?><img class="bus-thumb" src="<?= base_url('uploads/bus/' . rawurlencode($bus['photo'])) ?>" alt="Foto <?= esc($bus['operator']) ?>"><?php else: ?><span class="bus-thumb-empty">Belum ada</span><?php endif; ?></td>
                        <td><strong><?= esc($bus['operator']) ?></strong></td>
                        <td><?= esc($bus['destination_name'] ?? '-') ?></td>
                        <td><span class="badge badge-<?= $bus['bus_class'] ?>"><?= ucfirst($bus['bus_class']) ?></span></td>
                        <td><?= $bus['departure_time'] ?></td>
                        <td>Rp <?= number_format($bus['fare'], 0, ',', '.') ?></td>
                        <td><strong><?= $bus['quantity'] ?? 1 ?></strong></td>
                        <td><?= $bus['capacity'] ?? 40 ?> kursi</td>
                        <td><span class="badge badge-<?= $bus['status'] ?? 'aktif' ?>"><?= ucfirst($bus['status'] ?? 'aktif') ?></span></td>
                        <td>
                            <a href="<?= site_url('admin/bus/edit/' . $bus['id']) ?>" class="btn btn-primary btn-small">Edit</a>
                            <a href="<?= site_url('admin/bus/delete/' . $bus['id']) ?>" class="btn btn-danger btn-small" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
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
