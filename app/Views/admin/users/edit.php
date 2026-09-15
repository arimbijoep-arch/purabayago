<?= $this->extend('admin/layouts/base') ?>

<?= $this->section('content') ?>

<style>
    .form-card { background: white; border-radius: 14px; padding: 24px; box-shadow: 0 4px 12px rgba(0,0,0,.05); max-width: 600px; }
    .form-group { margin-bottom: 20px; }
    .form-group label { display: block; margin-bottom: 8px; font-weight: 500; color: #0d1b2a; }
    .form-group input,
    .form-group select { width: 100%; padding: 12px; border: 1px solid #dee2e6; border-radius: 8px; font-family: inherit; }
    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
    .form-actions { display: flex; gap: 12px; }
    .form-actions a { text-decoration: none; }
    .help-text { font-size: 12px; color: #999; margin-top: 4px; }
</style>

<h2 style="margin-bottom: 24px;">Edit User</h2>

<div class="form-card">
    <form action="<?= site_url('admin/users/update/' . $user['id']) ?>" method="post">
        <?= csrf_field() ?>

        <div class="form-group">
            <label>Username</label>
            <input type="text" disabled placeholder="<?= esc($user['username']) ?>" style="background: #f8f9fa;">
            <div class="help-text">Username tidak dapat diubah.</div>
        </div>

        <div class="form-group">
            <label for="nama_lengkap">Nama Lengkap <span style="color: red;">*</span></label>
            <input type="text" id="nama_lengkap" name="nama_lengkap" required placeholder="Nama lengkap" value="<?= esc($user['nama_lengkap']) ?>">
        </div>

        <div class="form-group">
            <label for="email">Email <span style="color: red;">*</span></label>
            <input type="email" id="email" name="email" required placeholder="email@example.com" value="<?= esc($user['email']) ?>">
        </div>

        <div class="form-group">
            <label for="password">Password Baru</label>
            <input type="password" id="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah">
            <div class="help-text">Biarkan kosong untuk tidak mengubah password.</div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="role">Role <span style="color: red;">*</span></label>
                <select id="role" name="role" required>
                    <option value="user" <?= ($user['role'] == 'user') ? 'selected' : '' ?>>User</option>
                    <option value="admin" <?= ($user['role'] == 'admin') ? 'selected' : '' ?>>Admin</option>
                </select>
            </div>

            <div class="form-group">
                <label for="status">Status <span style="color: red;">*</span></label>
                <select id="status" name="status" required>
                    <option value="active" <?= ($user['status'] == 'active') ? 'selected' : '' ?>>Aktif</option>
                    <option value="inactive" <?= ($user['status'] == 'inactive') ? 'selected' : '' ?>>Nonaktif</option>
                </select>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Perubahan</button>
            <a href="<?= site_url('admin/users') ?>" class="btn" style="background: #6c757d; color: white;"><i class="fas fa-times"></i> Batal</a>
        </div>
    </form>
</div>

<?= $this->endSection() ?>
