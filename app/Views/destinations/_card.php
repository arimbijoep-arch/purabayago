<?php
$categories = $destination['categories'] ?? [];
$categoryLabel = $categories ? implode(' · ', array_map(static fn (string $category): string => ucfirst($category), $categories)) : 'Kategori belum tersedia';
$visualClass = 'city-' . preg_replace('/[^a-z0-9]+/i', '-', strtolower($destination['destination_name']));
?>
<a class="destination-card-item <?= !empty($featured) ? 'is-featured' : '' ?>" data-name="<?= esc(strtolower($destination['destination_name'])) ?>" data-bus-count="<?= esc($destination['bus_count']) ?>" href="<?= site_url('search/destination?destination_id=' . $destination['id']) ?>">
    <div class="city-visual <?= esc($visualClass) ?>"><?php if (!empty($destination['photo'])): ?><img src="<?= base_url('uploads/destinations/' . rawurlencode($destination['photo']) . '?v=' . strtotime($destination['updated_at'] ?? 'now')) ?>" alt="<?= esc($destination['photo_alt'] ?? 'Kota ' . $destination['destination_name']) ?>" loading="lazy"><?php else: ?><span><?= esc(strtoupper(substr($destination['destination_name'], 0, 2))) ?></span><?php endif; ?><?php if (!empty($featured)): ?><b>POPULER</b><?php endif; ?></div>
    <div class="destination-card-content"><h3><?= esc($destination['destination_name']) ?></h3><p><?= esc($destination['service_count'] ?? $destination['bus_count']) ?> pilihan layanan</p><div class="category-list"><?= esc($categoryLabel) ?></div><?php if ($destination['min_fare'] !== null): ?><small>Mulai Rp<?= number_format((float) $destination['min_fare'], 0, ',', '.') ?></small><?php endif; ?><span class="card-cta">Lihat Bus <b>&rarr;</b></span></div>
</a>
