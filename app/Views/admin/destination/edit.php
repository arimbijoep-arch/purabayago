<?= $this->extend('admin/layouts/base') ?>

<?= $this->section('content') ?>

<style>
    .form-card { background: white; border-radius: 14px; padding: 24px; box-shadow: 0 4px 12px rgba(0,0,0,.05); max-width: 600px; }
    .form-group { margin-bottom: 20px; }
    .form-group label { display: block; margin-bottom: 8px; font-weight: 500; color: #0d1b2a; }
    .form-group input,
    .form-group textarea { width: 100%; padding: 12px; border: 1px solid #dee2e6; border-radius: 8px; font-family: inherit; }
    .form-group textarea { resize: vertical; min-height: 100px; }
    .form-actions { display: flex; gap: 12px; }
    .form-actions a { text-decoration: none; }
</style>

<h2 style="margin-bottom: 24px;">Edit Tujuan</h2>

<div class="form-card">
    <form action="<?= site_url('admin/destination/update/' . $destination['id']) ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <input type="hidden" name="page" value="<?= esc($page) ?>">

        <div class="form-group">
            <label for="destination_name">Nama Tujuan <span style="color: red;">*</span></label>
            <input type="text" id="destination_name" name="destination_name" required placeholder="Contoh: Malang" value="<?= esc($destination['destination_name']) ?>">
        </div>

        <div class="form-group">
            <label for="photo">Ganti Foto Tujuan</label>
            <?php if (!empty($destination['photo'])): ?><img src="<?= base_url('uploads/destinations/' . rawurlencode($destination['photo'])) ?>" alt="<?= esc($destination['photo_alt'] ?? 'Kota ' . $destination['destination_name']) ?>" style="display: block; width: 220px; height: 120px; object-fit: cover; border-radius: 8px; margin-bottom: 10px;"><?php else: ?><p style="margin: 0 0 10px; color: #6c757d;">Belum ada foto tujuan.</p><?php endif; ?>
            <input type="file" id="photo" name="photo" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp">
            <small style="display: block; margin-top: 6px; color: #6c757d;">Kosongkan jika tidak ingin mengganti foto. JPG, PNG, atau WEBP, maksimal 2 MB.</small>
        </div>

        <div class="form-group">
            <label for="photo_alt">Alt text foto</label>
            <input type="text" id="photo_alt" name="photo_alt" value="<?= esc($destination['photo_alt'] ?? '') ?>" placeholder="Deskripsi foto untuk aksesibilitas">
        </div>

        <div class="form-group">
            <label for="photo_caption">Caption foto</label>
            <input type="text" id="photo_caption" name="photo_caption" value="<?= esc($destination['photo_caption'] ?? '') ?>" placeholder="Caption opsional">
        </div>

        <div class="form-group">
            <label for="description">Deskripsi</label>
            <textarea id="description" name="description" placeholder="Masukkan deskripsi tujuan..."><?= esc($destination['description'] ?? '') ?></textarea>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Perubahan</button>
            <a href="<?= site_url('admin/destination') . '?page=' . $page ?>" class="btn" style="background: #6c757d; color: white;"><i class="fas fa-times"></i> Batal</a>
        </div>
    </form>
</div>

<script>
    document.querySelector('#photo')?.addEventListener('change', (event) => { const file = event.target.files[0]; if (!file) return; let preview = document.querySelector('#photo-preview'); if (!preview) { preview = document.createElement('img'); preview.id = 'photo-preview'; preview.style = 'display:block;width:220px;height:120px;object-fit:cover;border-radius:8px;margin:10px 0'; event.target.parentElement.appendChild(preview); } preview.src = URL.createObjectURL(file); });
</script>

<?= $this->endSection() ?>
