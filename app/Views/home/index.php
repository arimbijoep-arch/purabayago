<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Portal informasi keberangkatan bus dari Terminal Purabaya.">
    <title><?= esc($title) ?> | Portal Informasi Bus</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('css/home.css') ?>">
</head>
<body>
    <header class="site-nav">
        <div class="nav-inner">
            <a class="brand" href="<?= site_url('/') ?>" aria-label="PURABAYA GO Home">
                <?php if (!empty($logoImage)): ?><img class="brand-logo" src="<?= base_url('uploads/homepage/' . rawurlencode($logoImage) . '?v=' . time()) ?>" alt="<?= esc($logoAlt) ?>"><?php else: ?><span class="brand-mark" aria-hidden="true">
                    <svg viewBox="0 0 48 48" role="img" aria-hidden="true">
                        <path d="M9 31V17c0-3 2-5 5-5h20c3 0 5 2 5 5v14"/>
                        <path d="M7 31h34M12 31v4M36 31v4M14 18h20M17 23h5M26 23h5"/>
                        <circle cx="14" cy="32" r="3"/>
                        <circle cx="34" cy="32" r="3"/>
                        <path d="M9 27h30"/>
                    </svg>
                </span><?php endif; ?>
                <span>PURABAYA GO</span>
            </a>

            <details class="terminal-location">
                <summary>
                    <span class="location-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24"><path d="M12 21s6-5.4 6-10a6 6 0 1 0-12 0c0 4.6 6 10 6 10Zm0-8.5a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5Z"/></svg>
                    </span>
                    <span class="location-copy">
                        <strong>Terminal Purabaya</strong>
                        <span>Kasian, Jl. Bungurasih Timur No.31, Kasian, Bungurasih, Kec. Waru, Kabupaten Sidoarjo, Jawa Timur 61256</span>
                    </span>
                    <span class="location-chevron" aria-hidden="true">⌄</span>
                </summary>
                <div class="location-popover">
                    <p>Kasian, Jl. Bungurasih Timur No.31, Kasian, Bungurasih, Kec. Waru, Kabupaten Sidoarjo, Jawa Timur 61256</p>
                    <a href="https://maps.app.goo.gl/YrgYLXeiDCx7BLEA6?g_st=ac" target="_blank" rel="noopener noreferrer">Lihat di Google Maps ↗</a>
                </div>
            </details>

            <button class="menu-toggle" type="button" aria-expanded="false" aria-controls="main-navigation">
                <span></span><span></span><span></span>
            </button>

            <nav class="nav-links" id="main-navigation" aria-label="Navigasi utama">
                <a class="active" href="<?= site_url('/') ?>" aria-current="page">Home</a>
                <?php if (session()->get('logged_in')): ?>
                    <a href="#planner">Cari Bus</a>
                    <a href="<?= site_url('destinations') ?>">Tujuan</a>
                <?php else: ?>
                    <a href="<?= site_url('login') ?>">Cari Bus</a>
                    <a href="<?= site_url('login') ?>">Tujuan</a>
                <?php endif; ?>
                <a href="<?= site_url('guide') ?>">Guide</a>
                <a href="<?= site_url('about') ?>">About</a>
                <?php if (session()->get('logged_in')): ?>
                    <a href="<?= site_url(session()->get('role') === 'admin' ? 'admin/dashboard' : 'user/dashboard') ?>">Dashboard</a>
                    <a href="<?= site_url('logout') ?>">Logout</a>
                <?php else: ?>
                    <a href="<?= site_url('login') ?>">Login</a>
                    <a href="<?= site_url('register') ?>">Register</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>

    <main>
        <?php
            $heroImageUrl = $heroImage ? base_url('uploads/homepage/' . rawurlencode($heroImage) . '?v=' . time()) : null;
            $heroBackground = "url('data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 1600 900%22%3E%3Cg fill=%22none%22%3E%3Crect width=%221600%22 height=%22900%22 fill=%22%23051d32%22/%3E%3Cpath d=%22M0 700C180 620 310 590 500 640C660 682 850 708 1040 655C1240 598 1388 554 1600 641V900H0Z%22 fill=%22%230d5d85%22/%3E%3Cpath d=%22M250 560h1100c38 0 68 30 68 68v42H182v-42c0-38 30-68 68-68Z%22 fill=%22%23dfeef6%22 opacity=%220.14%22/%3E%3Cpath d=%22M272 430h1056c40 0 72 32 72 72v110H200V502c0-40 32-72 72-72Z%22 fill=%22%23f4b63b%22 opacity=%220.9%22/%3E%3Crect x=%22320%22 y=%22348%22 width=%22960%22 height=%22142%22 rx=%2222%22 fill=%22%23f5f7fa%22/%3E%3Crect x=%22398%22 y=%22380%22 width=%22300%22 height=%2280%22 rx=%2212%22 fill=%22%230a5d85%22/%3E%3Crect x=%22750%22 y=%22358%22 width=%22520%22 height=%22104%22 rx=%2224%22 fill=%22%23ffffff%22 opacity=%220.92%22/%3E%3Ccircle cx=%22352%22 cy=%22582%22 r=%2248%22 fill=%22%230f2333%22/%3E%3Ccircle cx=%221252%22 cy=%22582%22 r=%2248%22 fill=%22%230f2333%22/%3E%3Cpath d=%22M310 310h980%22 stroke=%22%23f4b63b%22 stroke-width=%2218%22 stroke-linecap=%22round%22 opacity=%220.75%22/%3E%3Cpath d=%22M214 324C364 288 480 258 620 252C820 245 984 286 1201 242C1327 216 1430 200 1540 192%22 stroke=%22%23dfeef6%22 stroke-width=%228%22 stroke-linecap=%22round%22 opacity=%220.35%22/%3E%3C/g%3E%3C/svg%3E')";
        ?>
        <section class="hero" id="top">
            <div class="hero-media" aria-hidden="true" style="background-image: linear-gradient(180deg, rgba(5, 19, 30, 0.2), rgba(5, 19, 30, 0.6)), <?= esc($heroBackground) ?>;"></div>
            <div class="hero-overlay" aria-hidden="true"></div>
            <?php if ($heroImageUrl): ?><div class="hero-bus-visual"><img src="<?= esc($heroImageUrl) ?>" alt="<?= esc($heroAlt) ?>"></div><?php endif; ?>

            <div class="hero-inner">
                <div class="hero-content">
                    <div class="eyebrow">TERMINAL PURABAYA / BUNGURASIH</div>
                    <h1>Temukan Busmu.<br>Mulai Perjalananmu.</h1>
                    <p class="hero-copy">Portal informasi keberangkatan bus dari Terminal Purabaya/Bungurasih berdasarkan tujuan, jadwal, dan estimasi tarif.</p>
                    <aside class="hero-notice" aria-label="Peringatan keamanan"><strong><span aria-hidden="true">⚠</span> PERHATIAN</strong><p>Pastikan Anda memilih dan membayar sesuai dengan ketentuan yang berlaku. Hati-hati dan jangan mudah percaya kepada calo yang berkeliaran di sekitar terminal.</p></aside>
                </div>
            </div>

            <?php if (session()->get('logged_in')): ?>
            <div class="search-wrap" id="planner">
                <form class="search-panel" action="<?= site_url('search/destination') ?>" method="get">
                    <div class="search-field">
                        <label for="from">
                            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 21s6-5.4 6-10a6 6 0 1 0-12 0c0 4.6 6 10 6 10Zm0-8.5a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5Z"/></svg>
                            Dari
                        </label>
                        <input id="from" type="text" value="Terminal Purabaya" readonly>
                    </div>

                    <div class="search-field">
                        <label for="destination">
                            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 21s6-5.4 6-10a6 6 0 1 0-12 0c0 4.6 6 10 6 10Zm0-8.5a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5Z"/></svg>
                            Tujuan
                        </label>
                        <select id="destination" name="destination_id" required>
                            <option value="">Pilih tujuan...</option>
                            <?php foreach ($destinations as $destination): ?>
                                <option value="<?= esc($destination['id']) ?>"><?= esc($destination['destination_name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="search-field">
                        <label for="travel-date">
                            <svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M8 3v4M16 3v4M3 10h18"/></svg>
                            Tanggal
                        </label>
                        <input id="travel-date" type="date" aria-label="Pilih tanggal">
                    </div>

                    <button class="search-button" type="submit">
                        <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="5"/><path d="M16 16l5 5"/></svg>
                        Cari Bus
                    </button>
                </form>
            </div>
            <?php else: ?>
            <div class="login-gate" aria-labelledby="login-gate-heading">
                <div class="prototype-box">
                    <strong id="login-gate-heading">LOGIN UNTUK MELANJUTKAN</strong>
                    <p>Silakan login terlebih dahulu untuk mencari bus, melihat tujuan, jadwal, tarif, dan informasi pembelian tiket.</p>
                    <a class="button-primary-link" href="<?= site_url('login') ?>">Login Pengguna</a>
                </div>
            </div>
            <?php endif; ?>
        </section>

        <?php if (session()->get('logged_in')): ?>
        <section class="section planner-intro">
            <div class="section-inner">
                <div class="section-head">
                    <div>
                        <span class="section-kicker">Rencanakan perjalananmu</span>
                        <h2>Temukan informasi bus berdasarkan kota tujuanmu.</h2>
                    </div>
                    <a class="inline-link" href="<?= site_url('destinations') ?>">Lihat Semua Tujuan</a>
                </div>

                <div class="destination-grid">
                    <?php foreach ($featuredDestinations as $destination): ?>
                        <a class="destination-card" href="<?= site_url('search/destination?destination_id=' . $destination['id']) ?>">
                            <div class="city-chip"><?= esc(strtoupper(substr($destination['destination_name'], 0, 2))) ?></div>
                            <div class="destination-name"><?= esc($destination['destination_name']) ?></div>
                            <p class="destination-meta">
                                Surabaya → <?= esc($destination['destination_name']) ?>
                                <?php if ($destination['min_fare'] !== null): ?>
                                    <span>• Mulai Rp<?= number_format((float) $destination['min_fare'], 0, ',', '.') ?></span>
                                <?php endif; ?>
                            </p>
                            <span class="card-link">Lihat Bus</span>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <?php if (!empty($todayDepartures)): ?>
            <section class="section alt schedule-section" id="schedule">
                    <div class="section-head compact">
                        <div>
                            <span class="section-kicker">Jadwal keberangkatan</span>
                            <h2>Jadwal Hari Ini</h2>
                        </div>
                    </div>

                    <div class="schedule-table-wrap">
                        <table class="schedule">
                            <thead>
                                <tr>
                                    <th>Jam</th>
                                    <th>Tujuan</th>
                                    <th>Shelter</th>
                                    <th>Kategori</th>
                                    <th>Estimasi Tarif</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($todayDepartures as $bus): ?>
                                    <tr>
                                        <td data-label="Jam"><strong><?= esc(substr($bus['scheduled_time'] ?? $bus['departure_time'], 0, 5)) ?></strong></td>
                                        <td data-label="Tujuan"><?= esc($bus['destination_name']) ?></td>
                                        <td data-label="Shelter">Shelter <?= esc($bus['shelter_number'] ?? '-') ?></td>
                                        <td data-label="Kategori"><span class="pill"><?= esc(ucfirst($bus['bus_class'])) ?></span></td>
                                        <td data-label="Estimasi Tarif">Rp<?= number_format((float) $bus['fare'], 0, ',', '.') ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <?php endif; ?>

        <section class="section ticket-purchase-section" id="ticket-purchase" aria-labelledby="ticket-purchase-heading">
            <div class="section-inner">
                <div class="ticket-purchase-head">
                    <div>
                        <span class="section-kicker">Pembelian tiket</span>
                        <h2 id="ticket-purchase-heading">🎫 Beli Tiket Bus</h2>
                    </div>
                    <p>Sudah menemukan bus dan tujuanmu?<br>Lanjutkan pembelian tiket melalui platform resmi berikut.</p>
                </div>

                <div class="ticket-purchase-layout">
                    <aside class="trip-summary-card" aria-label="Ringkasan perjalanan">
                        <h3>Perjalananmu</h3>
                        <p>📍 Dari: Terminal Purabaya</p>
                        <p>📍 Tujuan: Pilih dari informasi bus</p>
                        <p>🚌 Bus: Lihat detail perjalanan</p>
                        <p>🏢 Shelter: Lihat jadwal keberangkatan</p>
                        <p>💰 Estimasi tarif: Lihat detail bus</p>
                    </aside>

                    <div class="ticket-platform-grid">
                        <article class="ticket-platform-card">
                            <div>
                                <img class="ticket-platform-logo redbus-logo" src="<?= base_url('images/redbus-logo.png') ?>" alt="Logo RedBus" width="100" height="66">
                                <h3>RedBus</h3>
                                <p>Pesan tiket bus secara online melalui RedBus.</p>
                            </div>
                            <a href="https://www.redbus.id/" target="_blank" rel="noopener noreferrer" aria-label="Beli tiket di RedBus, membuka tab baru">Beli Tiket di RedBus <span aria-hidden="true">→</span></a>
                        </article>
                        <article class="ticket-platform-card">
                            <div>
                                <img class="ticket-platform-logo" src="https://www.google.com/s2/favicons?domain=traveloka.com&sz=128" alt="Logo Traveloka" width="64" height="64">
                                <h3>Traveloka</h3>
                                <p>Temukan dan pesan tiket bus melalui Traveloka.</p>
                            </div>
                            <a href="https://www.traveloka.com/id-id/bus-and-shuttle" target="_blank" rel="noopener noreferrer" aria-label="Beli tiket di Traveloka, membuka tab baru">Beli Tiket di Traveloka <span aria-hidden="true">→</span></a>
                        </article>
                    </div>
                </div>

                <p class="ticket-purchase-note">ℹ️ PURABAYA GO tidak melayani pembelian tiket dan tidak memproses pembayaran. Tiket dapat dibeli melalui RedBus, Traveloka, atau langsung di loket/tempat pembelian tiket di terminal. Pastikan memeriksa kembali tujuan, jadwal, tarif, dan ketentuan sebelum melakukan transaksi.</p>
            </div>
        </section>

        <section class="section terminal-section">
            <div class="section-inner terminal-layout">
                <div class="terminal-visual">
                    <?php if ($terminalImage): ?>
                        <img src="<?= base_url('uploads/homepage/' . rawurlencode($terminalImage) . '?v=' . time()) ?>" alt="<?= esc($terminalAlt) ?>">
                    <?php else: ?>
                        <div class="terminal-placeholder">
                            <span>P</span>
                            <small>TERMINAL<br>PURABAYA</small>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="terminal-copy">
                    <span class="section-kicker">Titik awal perjalanan</span>
                    <h2>Berangkat dari Terminal Purabaya</h2>
                    <p>Purabaya Go menyajikan informasi keberangkatan bus dari Terminal Purabaya/Bungurasih untuk membantu perencanaan perjalanan Anda.</p>
                    <div class="terminal-facts">
                        <div>
                            <strong>Lokasi</strong>
                            <a class="terminal-map-link" href="https://www.google.com/maps/place/Terminal+Bungurasih/@-7.3514024,112.7245512,17z/data=!3m1!4b1!4m6!3m5!1s0x2dd7e5ef62fbc74d:0xc850d71c0bfc7b60!8m2!3d-7.3514024!4d112.7245512!16s%2Fg%2F11f6g1h1q9!18m1!1e1?entry=ttu&amp;g_ep=EgoyMDI2MDkwOC4wIKXMDSoASAFQAw%3D%3D" target="_blank" rel="noopener noreferrer" aria-label="Buka lokasi Terminal Purabaya di Google Maps, membuka tab baru">Terminal Purabaya<br>Bungurasih, Sidoarjo</a>
                        </div>
                        <div>
                            <strong>Informasi</strong>
                            <span>Tujuan, jadwal, dan tarif</span>
                        </div>
                        <div>
                            <strong>Jadwal</strong>
                            <span>Keberangkatan bus setiap hari</span>
                        </div>
                    </div>
                    <a class="button-primary-link" href="<?= site_url('about') ?>">Pelajari tentang Purabaya</a>
                </div>
            </div>
        </section>

        <section class="section info-banner">
            <div class="section-inner">
                <div class="prototype-box">
                    <strong>DATA PROTOTYPE</strong>
                    <p>Informasi jadwal, tarif, dan layanan ini merupakan data prototype untuk kebutuhan akademik dan demonstrasi, bukan data real-time resmi dari operator.</p>
                </div>
            </div>
        </section>
    </main>

    <footer class="footer">
        <div class="section-inner footer-inner">
            <div>
                <strong>PURABAYA GO</strong>
                <p>Temukan Busmu, Mulai Perjalananmu.</p>
                <small>Portal informasi keberangkatan bus dari Terminal Purabaya.</small>
            </div>
            <div class="footer-links">
                <a href="<?= site_url('/') ?>">Home</a>
                <a href="#planner">Cari Bus</a>
                <a href="<?= site_url('destinations') ?>">Tujuan</a>
                <a href="<?= site_url('guide') ?>">Guide</a>
                <a href="<?= site_url('about') ?>">About</a>
            </div>
        </div>
    </footer>

    <script>
        const body = document.body;
        const nav = document.querySelector('.site-nav');
        const toggle = document.querySelector('.menu-toggle');
        const menu = document.querySelector('.nav-links');

        const setNavbarState = () => {
            body.classList.toggle('scrolled', window.scrollY > 20);
            nav?.classList.toggle('is-scrolled', window.scrollY > 20);
        };

        window.addEventListener('scroll', setNavbarState, { passive: true });
        setNavbarState();

        toggle?.addEventListener('click', () => {
            const isOpen = menu?.classList.toggle('is-open');
            toggle.setAttribute('aria-expanded', String(Boolean(isOpen)));
        });
    </script>
</body>
</html>
