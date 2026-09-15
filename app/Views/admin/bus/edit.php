<?= $this->extend('admin/layouts/base') ?>

<?= $this->section('content') ?>

<style>
    .form-card { background: white; border-radius: 14px; padding: 24px; box-shadow: 0 4px 12px rgba(0,0,0,.05); max-width: 600px; }
    .form-group { margin-bottom: 20px; }
    .form-group label { display: block; margin-bottom: 8px; font-weight: 500; color: #0d1b2a; }
    .form-group input,
    .form-group select,
    .form-group textarea { width: 100%; padding: 12px; border: 1px solid #dee2e6; border-radius: 8px; font-family: inherit; }
    .form-group textarea { resize: vertical; min-height: 100px; }
    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
    .currency-input { position: relative; }
    .currency-input::before { content: 'Rp'; position: absolute; top: 12px; left: 12px; color: #6c757d; font-weight: 600; pointer-events: none; }
    .currency-input input { padding-left: 36px; }
    .form-actions { display: flex; gap: 12px; }
    .form-actions a { text-decoration: none; }
</style>

<h2 style="margin-bottom: 24px;">Edit Bus</h2>

<div class="form-card">
    <form action="<?= site_url('admin/bus/update/' . $bus['id']) ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <div class="form-group">
            <label for="operator">Operator <span style="color: red;">*</span></label>
            <input type="text" id="operator" name="operator" required placeholder="Nama operator bus" value="<?= esc($bus['operator']) ?>">
        </div>

        <div class="form-group">
            <label for="photo">Ganti Foto Bus</label>
            <?php if (!empty($bus['photo'])): ?>
                <img src="<?= base_url('uploads/bus/' . rawurlencode($bus['photo'])) ?>" alt="Foto <?= esc($bus['operator']) ?>" style="display: block; width: 220px; height: 120px; object-fit: cover; border-radius: 8px; margin-bottom: 10px;">
            <?php else: ?>
                <p style="margin: 0 0 10px; color: #6c757d;">Belum ada foto bus.</p>
            <?php endif; ?>
            <input type="file" id="photo" name="photo" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp">
            <small style="display: block; margin-top: 6px; color: #6c757d;">Kosongkan jika tidak ingin mengganti foto. JPG, PNG, atau WEBP, maksimal 2 MB.</small>
        </div>

        <div class="form-group">
            <label for="photo_alt">Alt text foto</label>
            <input type="text" id="photo_alt" name="photo_alt" value="<?= esc($bus['photo_alt'] ?? '') ?>" placeholder="Deskripsi foto untuk aksesibilitas">
        </div>

        <div class="form-group">
            <label for="photo_caption">Caption foto</label>
            <input type="text" id="photo_caption" name="photo_caption" value="<?= esc($bus['photo_caption'] ?? '') ?>" placeholder="Caption opsional">
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="destination_id">Tujuan <span style="color: red;">*</span></label>
                <select id="destination_id" name="destination_id" required>
                    <option value="">-- Pilih Tujuan --</option>
                    <?php foreach ($destinations as $dest): ?>
                        <option value="<?= $dest['id'] ?>" <?= ($dest['id'] == $bus['destination_id']) ? 'selected' : '' ?>>
                            <?= esc($dest['destination_name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="bus_class">Kategori <span style="color: red;">*</span></label>
                <select id="bus_class" name="bus_class" required>
                    <option value="">-- Pilih Kategori --</option>
                    <option value="ekonomi" <?= ($bus['bus_class'] == 'ekonomi') ? 'selected' : '' ?>>Ekonomi</option>
                    <option value="patas" <?= ($bus['bus_class'] == 'patas') ? 'selected' : '' ?>>Patas</option>
                    <option value="executive" <?= ($bus['bus_class'] == 'executive') ? 'selected' : '' ?>>Executive</option>
                </select>
            </div>
        </div>

        <div class="form-group"><label for="shelter_id">Shelter <span style="color: red;">*</span></label><select id="shelter_id" name="shelter_id" required><option value="">-- Pilih Shelter --</option><?php foreach ($shelters as $shelter): ?><option value="<?= esc($shelter['id']) ?>" <?= ($shelter['id'] == ($bus['shelter_id'] ?? 0)) ? 'selected' : '' ?>>Shelter <?= esc($shelter['shelter_number']) ?><?= $shelter['category'] === 'jalur_bebas' ? ' - Jalur Bebas' : '' ?></option><?php endforeach; ?></select></div>

        <div class="form-row">
            <div class="form-group"><label for="schedule_times">Jadwal keberangkatan</label><?php $scheduleTimes = array_filter(array_map(static fn (array $schedule): ?string => $schedule['departure_time'] ? substr($schedule['departure_time'], 0, 5) : null, $schedules ?? [])); ?><input type="text" id="schedule_times" name="schedule_times" value="<?= esc(implode(', ', $scheduleTimes)) ?>" placeholder="07.45, 08.45, 11.15"><small style="display:block;margin-top:6px;color:#6c757d">Pisahkan waktu dengan koma.</small></div>

            <div class="form-group"><label for="fare">Perkiraan harga awal <span style="color: red;">*</span></label><div class="currency-input"><input type="text" id="fare" name="fare" required inputmode="numeric" placeholder="25.000" value="<?= esc(number_format((float) $bus['fare'], 0, ',', '.')) ?>"></div><small style="display:block;margin-top:6px;color:#6c757d">Contoh penulisan: Rp 25.000</small></div>
        </div>

        <div class="form-group"><label for="fare_max">Harga paling tinggi</label><div class="currency-input"><input type="text" id="fare_max" name="fare_max" inputmode="numeric" placeholder="130.000" value="<?= esc(number_format((float) ($bus['fare_max'] ?? $bus['fare']), 0, ',', '.')) ?>"></div><small style="display:block;margin-top:6px;color:#6c757d">Kosongkan jika sama dengan harga awal. Contoh: Rp 130.000</small></div>

        <?php $firstSchedule = $schedules[0] ?? []; ?><div class="form-row"><div class="form-group"><label for="schedule_status">Status jadwal</label><select id="schedule_status" name="schedule_status"><option value="available" <?= ($firstSchedule['schedule_status'] ?? '') === 'available' ? 'selected' : '' ?>>Jadwal tersedia</option><option value="estimated" <?= ($firstSchedule['schedule_status'] ?? 'estimated') === 'estimated' ? 'selected' : '' ?>>Perkiraan jadwal</option><option value="flexible" <?= ($firstSchedule['schedule_status'] ?? '') === 'flexible' ? 'selected' : '' ?>>Operasional fleksibel</option></select></div><div class="form-group"><label for="frequency">Frekuensi</label><input type="text" id="frequency" name="frequency" value="<?= esc($firstSchedule['frequency'] ?? '') ?>" placeholder="Contoh: sekitar 30 menit"></div></div><div class="form-group"><label for="schedule_note">Catatan jadwal</label><textarea id="schedule_note" name="schedule_note" placeholder="Catatan operasional atau rentang waktu..."><?= esc($firstSchedule['note'] ?? '') ?></textarea></div>

        <div class="form-group">
            <label for="departure_area">Area Keberangkatan <span style="color: red;">*</span></label>
            <input type="text" id="departure_area" name="departure_area" required placeholder="Contoh: Area A" value="<?= esc($bus['departure_area']) ?>">
        </div>

        <div class="form-group">
            <label for="ticket_information">Informasi Tiket</label>
            <textarea id="ticket_information" name="ticket_information" placeholder="Cara membeli tiket..."><?= esc($bus['ticket_information'] ?? '') ?></textarea>
        </div>

        <div class="form-group">
            <label for="description">Deskripsi</label>
            <textarea id="description" name="description" placeholder="Deskripsi tambahan..."><?= esc($bus['description'] ?? '') ?></textarea>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="quantity">Jumlah Bus <span style="color: red;">*</span></label>
                <input type="number" id="quantity" name="quantity" required placeholder="1" min="1" value="<?= $bus['quantity'] ?? 1 ?>">
            </div>

            <div class="form-group">
                <label for="capacity">Kapasitas Penumpang <span style="color: red;">*</span></label>
                <input type="number" id="capacity" name="capacity" required placeholder="40" min="1" value="<?= $bus['capacity'] ?? 40 ?>">
            </div>
        </div>

        <div class="form-group">
            <label for="status">Status <span style="color: red;">*</span></label>
            <select id="status" name="status" required>
                <option value="aktif" <?= ($bus['status'] == 'aktif') ? 'selected' : '' ?>>Aktif</option>
                <option value="nonaktif" <?= ($bus['status'] == 'nonaktif') ? 'selected' : '' ?>>Nonaktif</option>
            </select>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Perubahan</button>
            <a href="<?= site_url('admin/bus') ?>" class="btn" style="background: #6c757d; color: white;"><i class="fas fa-times"></i> Batal</a>
        </div>
    </form>
</div>

<script>
    const formatRupiahInput = (input) => {
        input.value = input.value.replace(/[^0-9]/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    };
    document.querySelectorAll('.currency-input input').forEach((input) => {
        input.addEventListener('input', () => formatRupiahInput(input));
    });

    document.querySelector('#photo')?.addEventListener('change', (event) => {
        const file = event.target.files[0];
        if (!file) return;
        let preview = document.querySelector('#photo-preview');
        if (!preview) { preview = document.createElement('img'); preview.id = 'photo-preview'; preview.style = 'display:block;width:220px;height:120px;object-fit:cover;border-radius:8px;margin:10px 0'; event.target.parentElement.appendChild(preview); }
        preview.src = URL.createObjectURL(file);
    });
</script>

<?= $this->endSection() ?>
