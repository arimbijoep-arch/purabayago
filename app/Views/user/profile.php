<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - PURABAYA GO</title>
    <style>
        :root { --navy:#071d32; --blue:#0a5d85; --blue-soft:#e8f3f8; --gold:#f4b63b; --paper:#f3f7fa; --text:#182b39; --muted:#617381; --line:#d7e2e9; }
        * { box-sizing:border-box; }
        body { min-height:100vh; margin:0; color:var(--text); background:linear-gradient(135deg,#eef5f8 0%,#f8fafb 52%,#edf5f8 100%); font-family:"Segoe UI",Arial,sans-serif; }
        nav { display:flex; align-items:center; justify-content:space-between; min-height:78px; padding:0 max(24px,calc((100% - 1180px) / 2)); color:#fff; background:var(--navy); box-shadow:0 8px 24px rgba(7,29,50,.16); }
        nav strong { display:flex; align-items:center; gap:12px; font-size:15px; letter-spacing:.08em; }
        nav strong::before { width:10px; height:10px; border-radius:50%; background:var(--gold); box-shadow:0 0 0 6px rgba(244,182,59,.16); content:""; }
        nav div { display:flex; align-items:center; gap:24px; }
        nav a { color:rgba(255,255,255,.78); font-size:14px; font-weight:700; text-decoration:none; transition:color .2s ease; }
        nav a:hover, nav a:focus-visible { color:var(--gold); }
        .wrap { width:min(980px,calc(100% - 32px)); margin:52px auto 80px; }
        .page-intro { margin-bottom:22px; }
        .eyebrow { color:var(--blue); font-size:12px; font-weight:800; letter-spacing:.16em; text-transform:uppercase; }
        .page-intro h1 { margin:10px 0 8px; color:var(--navy); font-size:clamp(2rem,4vw,3.1rem); letter-spacing:-.05em; }
        .page-intro p { max-width:580px; margin:0; color:var(--muted); line-height:1.65; }
        .card { position:relative; overflow:hidden; padding:34px; border:1px solid rgba(215,226,233,.9); border-radius:22px; background:rgba(255,255,255,.94); box-shadow:0 20px 45px rgba(7,29,50,.1); }
        .card::before { position:absolute; inset:0 0 auto; height:5px; background:linear-gradient(90deg,var(--blue),var(--gold)); content:""; }
        .card h2 { margin:0 0 26px; color:var(--navy); font-size:1.45rem; }
        .grid { display:grid; grid-template-columns:1fr 1fr; gap:18px; }
        .form-section { padding:22px; border:1px solid var(--line); border-radius:16px; background:#fbfdfe; }
        .form-section + .form-section { margin-top:18px; }
        .section-heading { display:flex; align-items:center; gap:12px; margin-bottom:14px; color:var(--blue); font-size:13px; font-weight:800; letter-spacing:.08em; text-transform:uppercase; }
        .section-heading::before { display:grid; place-items:center; width:28px; height:28px; border-radius:9px; color:var(--navy); background:var(--gold); content:""; }
        .profile-section .section-heading::before { content:"1"; }
        .security-section .section-heading::before { content:"2"; }
        label { display:block; margin:0 0 8px; color:var(--navy); font-size:13px; font-weight:800; }
        input { width:100%; padding:13px 14px; border:1px solid var(--line); border-radius:10px; outline:none; color:var(--text); background:#fff; font:inherit; transition:border-color .2s ease,box-shadow .2s ease; }
        input[type=file] { padding:10px; color:var(--muted); background:#fff; }
        input:focus { border-color:var(--blue); box-shadow:0 0 0 4px rgba(10,93,133,.12); }
        .field + .field { margin-top:16px; }
        .form-note { margin:9px 0 0; color:var(--muted); font-size:12px; }
        button { margin-top:20px; padding:13px 18px; border:0; border-radius:10px; color:var(--navy); background:var(--gold); font-weight:800; cursor:pointer; box-shadow:0 5px 0 #d79b23; transition:transform .2s ease,background .2s ease,box-shadow .2s ease; }
        button:hover, button:focus-visible { background:#ffc957; transform:translateY(-1px); box-shadow:0 6px 0 #d79b23; }
        .alert { margin-bottom:18px; padding:14px 16px; border-radius:12px; font-size:14px; font-weight:700; }
        .alert.success { border-left:4px solid #15956b; color:#126749; background:#e5f7ef; }
        .alert.error { border-left:4px solid #d94b4b; color:#842029; background:#fde8e8; }
        @media (max-width:680px) {
            nav { align-items:flex-start; flex-direction:column; gap:14px; padding:18px 20px; }
            nav div { flex-wrap:wrap; gap:12px 18px; }
            .wrap { width:min(100% - 24px,980px); margin-top:32px; }
            .card { padding:22px; }
            .grid { grid-template-columns:1fr; gap:16px; }
        }
    </style>
</head>
<body>
    <nav>
        <strong>PURABAYA GO</strong>
        <div>
            <a href="/PurabayaGo/public/index.php/user/dashboard">Dashboard</a>
            <a href="/PurabayaGo/public/index.php/user/profile">Profile</a>
            <a href="/PurabayaGo/public/index.php/logout">Logout</a>
        </div>
    </nav>

    <div class="wrap">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert success"><?= esc(session()->getFlashdata('success')) ?></div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert error"><?= esc(session()->getFlashdata('error')) ?></div>
        <?php endif; ?>

        <div class="page-intro">
            <span class="eyebrow">Akun pengguna</span>
            <h1>Profil Pengguna</h1>
            <p>Kelola informasi akun dan keamanan profilmu untuk pengalaman perjalanan yang lebih nyaman.</p>
        </div>

        <div class="card">

            <form action="/PurabayaGo/public/index.php/user/profile/update" method="post" enctype="multipart/form-data">
                <section class="form-section profile-section">
                    <div class="section-heading">Informasi dasar</div>
                    <div class="grid">
                        <div class="field">
                        <label for="nama_lengkap">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" id="nama_lengkap" value="<?= esc($user['nama_lengkap'] ?? '') ?>" required>
                        </div>
                        <div class="field">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" value="<?= esc($user['email'] ?? '') ?>" required>
                        </div>
                    </div>

                    <div class="field">
                        <label for="foto_profil">Foto Profil</label>
                        <input type="file" name="foto_profil" id="foto_profil" accept="image/*">
                        <p class="form-note">Gunakan gambar yang jelas agar profil mudah dikenali.</p>
                    </div>

                    <button type="submit">Simpan Profil</button>
                </section>
            </form>

            <form class="form-section security-section" action="/PurabayaGo/public/index.php/user/password/update" method="post">
                <div class="section-heading">Keamanan akun</div>
                <label for="password">Password Baru</label>
                <input type="password" name="password" id="password" placeholder="Masukkan password baru">
                <p class="form-note">Gunakan password yang kuat dan mudah kamu ingat.</p>

                <button type="submit">Ubah Password</button>
            </form>
        </div>
    </div>
</body>
</html>
