<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Jelajahi tujuan bus dari Terminal Purabaya.">
    <title>Tujuan Bus | PURABAYA GO</title>
    <link rel="stylesheet" href="<?= base_url('css/home.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/destinations.css') ?>">
</head>
<body>
<header class="site-nav">
    <div class="nav-inner">
        <a class="brand" href="<?= site_url('/') ?>"><span class="brand-mark">P</span> PURABAYA GO</a>
        <button class="menu-toggle" type="button" aria-expanded="false" aria-controls="main-navigation">Menu</button>
        <nav class="nav-links" id="main-navigation" aria-label="Navigasi utama">
            <a href="<?= site_url('/') ?>">Home</a><a href="<?= site_url('search') ?>">Cari Bus</a><a class="active" href="<?= site_url('destinations') ?>" aria-current="page">Tujuan</a><a href="<?= site_url('categories') ?>">Kategori Bus</a><a href="<?= site_url('guide') ?>">Guide</a><a href="<?= site_url('about') ?>">About</a><?php if (session()->get('logged_in')): ?><a class="nav-search" href="<?= site_url('user/profile') ?>">Profile</a><a href="<?= site_url('logout') ?>">Logout</a><?php else: ?><a class="nav-search" href="<?= site_url('login') ?>">Login</a><a href="<?= site_url('register') ?>">Register</a><?php endif; ?>
        </nav>
    </div>
</header>

<main>
    <section class="destination-hero">
        <div class="section-inner destination-hero-inner">
            <div><div class="eyebrow">DARI TERMINAL PURABAYA</div><h1>Jelajahi Berbagai Tujuan</h1><p class="hero-copy">Temukan berbagai kota yang dapat kamu capai dari Terminal Purabaya dan lihat pilihan bus yang tersedia.</p></div>
            <div class="route-visual" aria-label="Rute visual dari Surabaya menuju Malang, Blitar, dan Kediri"><div class="route-orbit"></div><div class="route-bus">BUS</div><div class="route-stops"><span>Surabaya</span><span>Malang</span><span>Blitar</span><span>Kediri</span></div></div>
        </div>
    </section>

    <section class="stats-band" aria-label="Ringkasan data tujuan"><div class="section-inner stats-grid"><div><strong><?= count($destinations) ?></strong><span>Kota tujuan</span></div><div><strong><?= esc($totalBuses) ?></strong><span>Pilihan bus</span></div><div><strong>3</strong><span>Kategori bus</span></div><div><strong>1</strong><span>Titik berangkat</span></div></div></section>

    <section class="section" id="destination-list">
        <div class="section-inner">
            <div class="section-kicker">Discovery perjalanan</div><h2>Ke Mana Kamu Ingin Pergi?</h2><p class="section-intro">Pilih kota tujuanmu untuk melihat pilihan bus dari Terminal Purabaya.</p>
            <?php if (empty($destinations)): ?><div class="empty-state"><strong>Belum ada tujuan tersedia</strong><p>Data tujuan belum tersedia saat ini.</p></div><?php else: ?>
            <form class="destination-tools" role="search" onsubmit="return false;"><div class="field"><label for="destination-filter">Cari kota</label><div class="search-input-wrap"><input id="destination-filter" type="search" autocomplete="off" placeholder="Ketik nama kota, misalnya Malang..." aria-describedby="destination-search-help"><button type="button" id="clear-destination-filter" class="clear-search" aria-label="Hapus pencarian" title="Hapus pencarian">&times;</button></div><small id="destination-search-help">Pencarian berjalan otomatis saat kamu mengetik.</small></div><div class="field"><label for="destination-sort">Urutkan daftar</label><select id="destination-sort"><option value="name-asc">Nama: A-Z</option><option value="name-desc">Nama: Z-A</option><option value="count-desc">Bus terbanyak</option></select></div></form>

            <div class="featured-heading"><h3>Tujuan Populer</h3><span>Berdasarkan jumlah bus tersedia</span></div>
            <div class="featured-grid"><?php foreach ($popularDestinations as $destination): ?><?= view('destinations/_card', ['destination' => $destination, 'featured' => true]) ?><?php endforeach; ?></div>
            <div class="all-heading"><h3>Semua Tujuan</h3><span id="destination-count" aria-live="polite"><?= count($destinations) ?> tujuan</span></div>
            <div class="destination-card-grid" id="destination-grid"><?php foreach ($destinations as $destination): ?><?= view('destinations/_card', ['destination' => $destination]) ?><?php endforeach; ?></div>
            <div class="empty-state is-hidden" id="filter-empty"><strong>Tujuan tidak ditemukan</strong><p>Belum ada tujuan yang sesuai dengan pencarianmu.</p><button class="button button-primary" type="button" id="reset-filter">Tampilkan semua tujuan</button></div>
            <?php endif; ?>
        </div>
    </section>

    <section class="section alt"><div class="section-inner"><div class="section-kicker">Satu titik, banyak arah</div><h2>Perjalanan Dimulai dari Purabaya</h2><p class="section-intro">Terminal Purabaya menjadi titik awal untuk menjelajahi berbagai kota di Jawa Timur dan sekitarnya.</p><div class="journey-line"><div class="journey-origin"><span class="journey-dot">P</span><strong>Terminal Purabaya</strong><small>Bungurasih, Sidoarjo</small></div><div class="journey-branches"><?php foreach (array_slice($destinations, 0, 5) as $destination): ?><a href="<?= site_url('search/destination?destination_id=' . $destination['id']) ?>"><span></span><?= esc($destination['destination_name']) ?></a><?php endforeach; ?></div></div></div></section>

    <section class="section"><div class="section-inner"><div class="section-kicker">Sebelum berangkat</div><h2>Informasi Sebelum Berangkat</h2><div class="info-grid destination-info-grid"><article class="info-card"><span class="info-icon">01</span><strong>Periksa Jadwal</strong><p>Pastikan melihat jadwal keberangkatan sebelum melakukan perjalanan.</p></article><article class="info-card"><span class="info-icon">02</span><strong>Cek Estimasi Tarif</strong><p>Tarif yang ditampilkan merupakan informasi prototype.</p></article><article class="info-card"><span class="info-icon">03</span><strong>Pilih Kategori Bus</strong><p>Sesuaikan pilihan bus dengan kebutuhan perjalananmu.</p></article></div><a class="button button-primary info-action" href="<?= site_url('search') ?>">Cari informasi bus</a></div></section>

    <section class="section prototype-wrap"><div class="section-inner"><div class="prototype"><strong>DATA PROTOTYPE</strong><p>Informasi jadwal, tarif, dan layanan pada aplikasi ini merupakan data prototype untuk kebutuhan akademik/demo dan bukan data real-time resmi.</p></div></div></section>
</main>
<footer class="footer"><div class="section-inner footer-inner"><div><strong>PURABAYA GO</strong><p>Temukan Busmu, Mulai Perjalananmu.</p><small>Portal informasi keberangkatan bus dari Terminal Purabaya.</small></div><div class="footer-links"><a href="<?= site_url('/') ?>">Home</a><a href="<?= site_url('search') ?>">Cari Bus</a><a href="<?= site_url('destinations') ?>">Tujuan</a><a href="<?= site_url('categories') ?>">Kategori Bus</a><a href="<?= site_url('guide') ?>">Guide</a><a href="<?= site_url('about') ?>">About</a><small>&copy; 2026 Purabaya Go</small></div></div></footer>
<script>
const menuToggle = document.querySelector('.menu-toggle'); const navigation = document.querySelector('.nav-links'); menuToggle?.addEventListener('click', () => { const isOpen = navigation.classList.toggle('is-open'); menuToggle.setAttribute('aria-expanded', String(isOpen)); });
const grid = document.querySelector('#destination-grid'); const filter = document.querySelector('#destination-filter'); const sort = document.querySelector('#destination-sort'); const empty = document.querySelector('#filter-empty'); const count = document.querySelector('#destination-count'); const reset = document.querySelector('#reset-filter'); const clearSearch = document.querySelector('#clear-destination-filter');
function updateDestinations() { if (!grid || !filter) return; const cards = [...grid.querySelectorAll('.destination-card-item')]; const query = filter.value.trim().toLowerCase(); cards.sort((a, b) => { if (sort.value === 'count-desc') return Number(b.dataset.busCount) - Number(a.dataset.busCount); const result = a.dataset.name.localeCompare(b.dataset.name, 'id'); return sort.value === 'name-desc' ? -result : result; }); cards.forEach(card => { grid.appendChild(card); card.hidden = Boolean(query && !card.dataset.name.includes(query)); }); const visible = cards.filter(card => !card.hidden).length; count.textContent = `${visible} tujuan`; empty.classList.toggle('is-hidden', visible !== 0); clearSearch?.classList.toggle('is-visible', Boolean(query)); }
filter?.addEventListener('input', updateDestinations); sort?.addEventListener('change', updateDestinations); clearSearch?.addEventListener('click', () => { filter.value = ''; filter.focus(); updateDestinations(); }); reset?.addEventListener('click', () => { filter.value = ''; filter.focus(); updateDestinations(); }); updateDestinations();
</script>
</body>
</html>
