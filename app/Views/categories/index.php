<!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Pilih kategori bus sesuai kebutuhan perjalanan dari Terminal Purabaya.">
	<title>Kategori Bus | PURABAYA GO</title>
	<link rel="stylesheet" href="<?= base_url('css/home.css') ?>">
	<link rel="stylesheet" href="<?= base_url('css/categories.css') ?>">
</head>
<body>
<header class="site-nav">
	<div class="nav-inner">
		<a class="brand" href="<?= site_url('/') ?>"><span class="brand-mark">P</span> PURABAYA GO</a>
		<button class="menu-toggle" type="button" aria-expanded="false" aria-controls="category-navigation">Menu</button>
		<nav class="nav-links" id="category-navigation" aria-label="Navigasi utama">
			<a href="<?= site_url('/') ?>">Home</a>
			<a href="<?= site_url('search') ?>">Cari Bus</a>
			<a href="<?= site_url('destinations') ?>">Tujuan</a>
			<a class="active" href="<?= site_url('categories') ?>" aria-current="page">Kategori Bus</a>
			<a href="<?= site_url('guide') ?>">Guide</a>
			<a href="<?= site_url('about') ?>">About</a>
			<?php if (session()->get('logged_in')): ?>
				<a href="<?= site_url('user/dashboard') ?>">Dashboard</a>
				<a href="<?= site_url('logout') ?>">Logout</a>
			<?php else: ?>
				<a href="<?= site_url('login') ?>">Login</a>
				<a href="<?= site_url('register') ?>">Register</a>
			<?php endif; ?>
		</nav>
	</div>
</header>

<main class="category-page">
	<section class="category-hero">
		<div class="section-inner category-hero-inner">
			<div>
				<span class="eyebrow">PILIH SESUAI KEBUTUHANMU</span>
				<h1>Kategori Bus</h1>
				<p class="hero-copy">Bandingkan pilihan layanan bus dari Terminal Purabaya. Pilih kategori berdasarkan anggaran, kenyamanan, dan durasi perjalananmu.</p>
			</div>
			<div class="category-hero-note">
				<span class="category-hero-icon" aria-hidden="true">✦</span>
				<strong>Tiga pilihan perjalanan</strong>
				<p>Mulai dari pilihan hemat hingga layanan dengan fasilitas lebih lengkap.</p>
			</div>
		</div>
	</section>

	<section class="section category-list-section" aria-labelledby="category-list-heading">
		<div class="section-inner">
			<div class="section-kicker">Temukan yang paling sesuai</div>
			<h2 id="category-list-heading">Pilih gaya perjalananmu</h2>
			<p class="section-intro">Setiap kategori memiliki keunggulan yang berbeda. Pilih salah satu untuk melihat bus dan jadwal yang tersedia.</p>

			<div class="category-grid">
				<?php foreach ($categories as $index => $category): ?>
					<article class="category-card category-card-<?= esc($category['value']) ?>">
						<div class="category-card-top">
							<span class="category-number">0<?= $index + 1 ?></span>
							<span class="category-label"><?= esc($category['eyebrow']) ?></span>
						</div>
						<h3><?= esc($category['label']) ?></h3>
						<p><?= esc($category['description']) ?></p>
						<div class="category-best-for"><strong>Ideal untuk</strong><span><?= esc($category['best_for']) ?></span></div>
						<a class="category-action" href="<?= site_url('search?category=' . rawurlencode($category['value'])) ?>">Lihat bus kategori ini <span aria-hidden="true">→</span></a>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<section class="section category-guide-section">
		<div class="section-inner category-guide">
			<div>
				<span class="section-kicker">Tips memilih</span>
				<h2>Perjalanan nyaman dimulai dari pilihan yang tepat.</h2>
			</div>
			<div class="category-tips">
				<div><span>01</span><p><strong>Perhatikan anggaran</strong><br>Gunakan Ekonomi untuk pilihan tarif yang lebih ramah.</p></div>
				<div><span>02</span><p><strong>Sesuaikan jarak perjalanan</strong><br>Pilih Patas atau Executive untuk perjalanan yang lebih nyaman.</p></div>
				<div><span>03</span><p><strong>Cek jadwal sebelum berangkat</strong><br>Pastikan tujuan, jam, dan tarif sesuai kebutuhanmu.</p></div>
			</div>
		</div>
	</section>
</main>

<footer class="footer"><div class="section-inner footer-inner"><div><strong>PURABAYA GO</strong><p>Temukan Busmu, Mulai Perjalananmu.</p><small>Portal informasi keberangkatan bus dari Terminal Purabaya.</small></div><div><small>DATA PROTOTYPE - bukan data real-time.<br>&copy; 2026 Purabaya Go</small></div></div></footer>
<script>
	const menuToggle = document.querySelector('.menu-toggle');
	const navigation = document.querySelector('.nav-links');
	menuToggle?.addEventListener('click', () => {
		const isOpen = navigation.classList.toggle('is-open');
		menuToggle.setAttribute('aria-expanded', String(isOpen));
	});
</script>
</body></html>
