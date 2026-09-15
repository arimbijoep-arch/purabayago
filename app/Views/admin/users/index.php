<?= $this->extend('admin/layouts/base') ?>

<?= $this->section('content') ?>

<style>
    .content-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
    .table-card { background: var(--card); border-radius: 10px; overflow: hidden; box-shadow: 0 8px 18px rgba(23,76,58,.08); }
    .data-table { width: 100%; border-collapse: collapse; }
    .data-table th { background: var(--green-light); padding: 14px; text-align: left; border-bottom: 2px solid var(--line); font-size: 13px; }
    .data-table td { padding: 14px; border-bottom: 1px solid var(--line); }
    .data-table tr:hover { background: #f5f8f0; }
    .btn-small { padding: 6px 12px; font-size: 12px; }
    .pagination { padding: 16px; text-align: center; }
    .pagination a, .pagination span { margin: 0 4px; padding: 6px 10px; border: 1px solid var(--line); text-decoration: none; color: var(--green); border-radius: 4px; }
    .pagination .active { background: var(--green); color: white; border-color: var(--green); }
    .badge { display: inline-block; padding: 4px 8px; border-radius: 4px; font-size: 11px; font-weight: 500; }
    .badge-admin { background: #f8d7da; color: #721c24; }
    .badge-user { background: #d1ecf1; color: #0c5460; }
    .badge-active { background: #d4edda; color: #155724; }
    .badge-inactive { background: #f8f9fa; color: #666; }
</style>

<div class="content-header">
    <h2>Kelola Users</h2>
    <a href="<?= site_url('admin/users/create') ?>" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah User</a>
</div>

<div class="table-card">
    <table class="data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Nama Lengkap</th>
                <th>Email</th>
                <th>Role</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($users)): ?>
                <tr>
                    <td colspan="7" style="text-align: center; padding: 40px;">Belum ada users.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= $user['id'] ?></td>
                        <td><strong><?= esc($user['username']) ?></strong></td>
                        <td><?= esc($user['nama_lengkap']) ?></td>
                        <td><?= esc($user['email']) ?></td>
                        <td><span class="badge badge-<?= $user['role'] ?>"><?= ucfirst($user['role']) ?></span></td>
                        <td><span class="badge badge-<?= $user['status'] ?>"><?= ucfirst($user['status']) ?></span></td>
                        <td>
                            <a href="<?= site_url('admin/users/edit/' . $user['id']) ?>" class="btn btn-primary btn-small">Edit</a>
                            <?php if ($user['id'] != session()->get('user_id')): ?>
                                <a href="<?= site_url('admin/users/delete/' . $user['id']) ?>" class="btn btn-danger btn-small" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                            <?php endif; ?>
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
