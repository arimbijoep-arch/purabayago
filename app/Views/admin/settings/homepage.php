<?= $this->extend('admin/layouts/base') ?>
<?= $this->section('content') ?>
<style>
    .settings-card { max-width: 1100px; padding: 26px; border-radius: 14px; background: #fff; box-shadow: 0 4px 12px rgba(0,0,0,.05); }
    .image-setting { padding: 20px 0; border-bottom: 1px solid #e9ecef; }
    .image-setting:last-of-type { border-bottom: 0; }
    .image-setting h3 { margin: 0 0 14px; color: #0d1b2a; }
    .image-preview { width: 100%; max-width: 430px; height: 180px; object-fit: cover; border-radius: 10px; background: #e9f1f5; display: block; margin-bottom: 12px; }
    .logo-preview { max-width: 240px; object-fit: contain; padding: 24px; }
    .image-empty { display: grid; place-items: center; color: #607080; font-size: 13px; }
    .form-group { margin: 14px 0; }
    .form-group label { display: block; margin-bottom: 7px; font-weight: 600; }
    .form-group input { width: 100%; padding: 11px; border: 1px solid #dee2e6; border-radius: 8px; box-sizing: border-box; }
    .setting-actions { display: flex; flex-wrap: wrap; gap: 10px; align-items: center; }
    @media (max-width: 600px) { .settings-card { padding: 18px; } }
</style>
<h2 style="margin-bottom: 24px;">Pengaturan Homepage</h2>
<div class="settings-card">
    <form action="<?= site_url('admin/settings/homepage') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <section class="image-setting">
            <h3>Logo PURABAYA GO</h3>
            <?php if ($logoImage): ?><img class="image-preview logo-preview" src="<?= base_url('uploads/homepage/' . rawurlencode($logoImage)) ?>" alt="<?= esc($logoAlt) ?>"><?php else: ?><div class="image-preview logo-preview image-empty">Logo bawaan digunakan</div><?php endif; ?>
            <div class="form-group"><label for="logo_image">Ganti Logo</label><input type="file" id="logo_image" name="logo_image" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"></div>
            <div class="form-group"><label for="logo_alt">Alt text logo</label><input type="text" id="logo_alt" name="logo_alt" value="<?= esc($logoAlt) ?>" required></div>
            <div class="setting-actions"><?php if ($logoImage): ?><a class="btn btn-danger" href="<?= site_url('admin/settings/delete/logo') ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus logo?')">Hapus Logo</a><?php endif; ?></div>
        </section>
        <section class="image-setting">
            <h3>Foto Hero Homepage</h3>
            <?php if ($heroImage): ?><img class="image-preview" src="<?= base_url('uploads/homepage/' . rawurlencode($heroImage)) ?>" alt="<?= esc($heroAlt) ?>"><?php else: ?><div class="image-preview image-empty">Belum ada foto hero</div><?php endif; ?>
            <div class="form-group"><label for="hero_image">Ganti Foto</label><input type="file" id="hero_image" name="hero_image" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"></div>
            <div class="form-group"><label for="hero_alt">Alt text hero</label><input type="text" id="hero_alt" name="hero_alt" value="<?= esc($heroAlt) ?>" required></div>
            <div class="setting-actions"><?php if ($heroImage): ?><a class="btn btn-danger" href="<?= site_url('admin/settings/delete/hero') ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus foto hero?')">Hapus Foto Hero</a><?php endif; ?></div>
        </section>
        <section class="image-setting">
            <h3>Foto Terminal Purabaya</h3>
            <?php if ($terminalImage): ?><img class="image-preview" src="<?= base_url('uploads/homepage/' . rawurlencode($terminalImage)) ?>" alt="<?= esc($terminalAlt) ?>"><?php else: ?><div class="image-preview image-empty">Belum ada foto terminal</div><?php endif; ?>
            <div class="form-group"><label for="terminal_image">Ganti Foto</label><input type="file" id="terminal_image" name="terminal_image" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"></div>
            <div class="form-group"><label for="terminal_alt">Alt text terminal</label><input type="text" id="terminal_alt" name="terminal_alt" value="<?= esc($terminalAlt) ?>" required></div>
            <div class="setting-actions"><?php if ($terminalImage): ?><a class="btn btn-danger" href="<?= site_url('admin/settings/delete/terminal') ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus foto terminal?')">Hapus Foto Terminal</a><?php endif; ?></div>
        </section>
        <p style="color: #6c757d; font-size: 13px;">JPG, PNG, atau WebP. Maksimal 2 MB per foto.</p>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </form>
    <div style="margin-top: 24px; padding-top: 18px; border-top: 1px solid #e9ecef; color: #607080; font-size: 13px;">
        <strong style="color: #0d1b2a;">Foto lain di website</strong>
        <p style="margin: 6px 0 10px;">Foto tujuan dan foto bus dikelola dari menu masing-masing.</p>
        <div class="setting-actions"><a class="btn btn-primary" href="<?= site_url('admin/destination') ?>">Kelola Foto Tujuan</a><a class="btn btn-primary" href="<?= site_url('admin/bus') ?>">Kelola Foto Bus</a></div>
    </div>
</div>
<script>
    document.querySelectorAll('input[type="file"]').forEach((input) => input.addEventListener('change', () => {
        const file = input.files[0];
        const preview = input.closest('.image-setting').querySelector('.image-preview');
        if (file) preview.src = URL.createObjectURL(file), preview.classList.remove('image-empty');
    }));
</script>
<?= $this->endSection() ?>
