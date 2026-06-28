<?php
require 'db.php';

$query_produk = "SELECT * FROM products WHERE stok > 0";
$result_produk = $conn->query($query_produk);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="description" content="bekalkopibdg - Premium Mobile Coffee di Bandung. Menyajikkan biji kopi nusantara pilihan dalam kemasan botol eksklusif. Booking untuk event atau temukan venue kami.">
    <meta name="keywords" content="Kopi botolan premium, Kopi keliling Bandung, bekalkopibdg, Arabica Gayo, Event kopi, Franchise kopi">

    <title>bekalkopibdg | Premium Mobile Coffee Bandung</title>

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600&family=Playfair+Display:ital,wght@0,600;0,700;1,600&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg-dark: #0f0c0a;
            --bg-light: #1a1613;
            --gold: #d4af37;
            --gold-hover: #b5952f;
            --text-main: #fdfbf7;
            --text-muted: #a39587;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            scroll-behavior: smooth;
        }

        body {
            background-color: var(--bg-dark);
            color: var(--text-main);
            font-family: 'Montserrat', sans-serif;
            line-height: 1.6;
        }

        h1,
        h2,
        h3,
        .logo {
            font-family: 'Playfair Display', serif;
        }

        /* --- Navbar --- */
        header {
            position: fixed;
            top: 0;
            width: 100%;
            padding: 20px 50px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: rgba(15, 12, 10, 0.8);
            backdrop-filter: blur(10px);
            z-index: 1000;
            border-bottom: 1px solid rgba(212, 175, 55, 0.1);
            transition: 0.3s;
        }

        .logo {
            font-size: 28px;
            color: var(--gold);
            letter-spacing: 2px;
            text-decoration: none;
            font-weight: 700;
        }

        nav a {
            color: var(--text-main);
            text-decoration: none;
            margin-left: 30px;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: color 0.3s;
        }

        nav a:hover {
            color: var(--gold);
        }

        .btn-login {
            border: 1px solid var(--gold);
            padding: 8px 20px;
            border-radius: 50px;
            color: var(--gold);
        }

        .btn-login:hover {
            background: var(--gold);
            color: var(--bg-dark);
        }

        /* --- Hero Section --- */
        .hero {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            background: linear-gradient(rgba(15, 12, 10, 0.6), rgba(15, 12, 10, 0.9)), url('https://images.unsplash.com/photo-1497935586351-b67a49e012bf?auto=format&fit=crop&w=1920&q=80') center/cover no-repeat;
            padding: 0 20px;
        }

        .hero-content {
            max-width: 820px;
            animation: fadeIn 1.5s ease-in-out;
        }

        .hero h1 {
            font-size: 4rem;
            color: var(--gold);
            margin-bottom: 20px;
            line-height: 1.2;
        }

        .hero p {
            font-size: 1.1rem;
            color: var(--text-muted);
            margin-bottom: 40px;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--gold), #aa8022);
            color: var(--bg-dark);
            padding: 15px 35px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 2px;
            border-radius: 4px;
            transition: 0.3s;
            display: inline-block;
        }

        .btn-primary:hover {
            box-shadow: 0 10px 20px rgba(212, 175, 55, 0.3);
            transform: translateY(-3px);
        }

        /* --- Section Titles --- */
        .section-header {
            text-align: center;
            margin-bottom: 60px;
            padding-top: 30px;
        }

        .section-header h2 {
            font-size: 2.5rem;
            color: var(--gold);
            margin-bottom: 15px;
        }

        .section-header p {
            color: var(--text-muted);
            font-size: 1rem;
            max-width: 650px;
            margin: 0 auto;
        }

        /* --- The Beans Story --- */
        .beans-section {
            padding: 100px 50px;
            background-color: var(--bg-light);
        }

        .beans-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 40px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .bean-card {
            text-align: center;
            padding: 30px;
            border: 1px solid rgba(212, 175, 55, 0.1);
            border-radius: 8px;
            transition: 0.4s;
            background: rgba(0, 0, 0, 0.2);
        }

        .bean-card:hover {
            border-color: var(--gold);
            transform: translateY(-10px);
        }

        .bean-icon {
            font-size: 40px;
            margin-bottom: 20px;
            color: var(--gold);
        }

        .bean-card h3 {
            font-size: 1.5rem;
            margin-bottom: 15px;
            color: var(--text-main);
        }

        .bean-card p {
            font-size: 0.95rem;
            color: var(--text-muted);
        }

        /* --- Menu Penjualan --- */
        .menu-section {
            padding: 100px 50px;
            background-color: var(--bg-dark);
        }

        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .menu-item {
            background: var(--bg-light);
            border-radius: 8px;
            padding: 30px 20px;
            text-align: center;
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.05);
            transition: 0.3s;
        }

        .menu-item:hover {
            background: rgba(212, 175, 55, 0.05);
            border-color: rgba(212, 175, 55, 0.3);
        }

        .menu-item h3 {
            font-size: 1.4rem;
            color: var(--gold);
            margin-bottom: 10px;
        }

        .menu-item p {
            font-size: 0.9rem;
            color: var(--text-muted);
            margin-bottom: 20px;
            height: 60px;
            overflow: hidden;
        }

        .menu-price {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--text-main);
            display: block;
            margin-bottom: 20px;
        }

        .btn-order {
            background: transparent;
            border: 1px solid var(--gold);
            color: var(--gold);
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 4px;
            font-weight: 600;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: 0.3s;
            width: 100%;
        }

        .btn-order:hover {
            background: var(--gold);
            color: var(--bg-dark);
        }

        /* --- Venues & Booking Area --- */
        .venue-booking {
            display: flex;
            flex-wrap: wrap;
        }

        .venue-side,
        .booking-side {
            flex: 1;
            min-width: 320px;
            padding: 100px 50px;
        }

        .venue-side {
            background: linear-gradient(rgba(26, 22, 19, 0.9), rgba(26, 22, 19, 0.9)), url('https://images.unsplash.com/photo-1447933601403-0c6688de566e?auto=format&fit=crop&w=800&q=80') center/cover no-repeat;
        }

        .venue-list {
            margin-top: 40px;
        }

        .venue-item {
            padding: 20px;
            border-bottom: 1px solid rgba(212, 175, 55, 0.2);
        }

        .venue-item h4 {
            color: var(--gold);
            font-size: 1.2rem;
            margin-bottom: 5px;
        }

        .venue-item p {
            font-size: 13px;
            color: #ccc;
        }

        .booking-side {
            background: var(--bg-dark);
        }

        .booking-form {
            margin-top: 40px;
        }

        .input-group {
            margin-bottom: 20px;
        }

        .input-group input,
        .input-group select,
        .input-group textarea {
            width: 100%;
            background: var(--bg-light);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: var(--text-main);
            padding: 15px;
            font-size: 14px;
            border-radius: 4px;
            outline: none;
            transition: 0.3s;
        }

        .input-group input:focus,
        .input-group select:focus,
        .input-group textarea:focus {
            border-color: var(--gold);
        }

        .booking-form .note {
            color: var(--text-muted);
            font-size: 12px;
            margin-top: 8px;
        }

        footer {
            background: #050403;
            padding: 40px 50px;
            text-align: center;
            border-top: 1px solid rgba(212, 175, 55, 0.2);
        }

        .social-links {
            margin-bottom: 20px;
            display: flex;
            gap: 14px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .social-links {
            margin-bottom: 20px;
            display: flex;
            justify-content: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .social-links a {
            color: var(--gold);
            text-decoration: none;
            font-size: 13px;
            letter-spacing: 1px;
            text-transform: uppercase;
            padding: 10px 18px;
            border: 1px solid rgba(212, 175, 55, 0.35);
            border-radius: 999px;
            transition: 0.25s;
            line-height: 1;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 120px;
        }

        .social-links a:hover {
            background: var(--gold);
            color: var(--bg-dark);
        }

        .footer-text {
            font-size: 12px;
            color: var(--text-muted);
        }



        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media(max-width: 768px) {
            header {
                padding: 15px 20px;
                flex-direction: column;
                gap: 15px;
            }

            nav a {
                margin: 0 10px;
            }

            .hero h1 {
                font-size: 2.5rem;
            }

            .venue-side,
            .booking-side {
                padding: 50px 20px;
            }
        }
    </style>

    <style>
        /* berita section */
        .berita {
            padding: 16px 14px;
            width: 100%;
            max-width: 820px;
            margin: 0 auto;
            background: rgba(0, 0, 0, 0.25);
            border: 1px solid rgba(212, 175, 55, 0.18);
            border-radius: 6px;
        }

        .berita h3 {
            color: var(--gold);
            font-family: 'Playfair Display', serif;
            margin-bottom: 12px;
            font-size: 1.6rem;
        }

        .berita p.lead {
            color: var(--text-muted);
            margin-bottom: 18px;
        }

        .berita-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 14px;
            margin-top: 10px;
        }

        .berita-card {
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 12px;
            padding: 14px;
        }

        .berita-card .tag {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 999px;
            border: 1px solid rgba(212, 175, 55, 0.35);
            color: rgba(212, 175, 55, 0.98);
            font-weight: 800;
            font-size: 12px;
            text-transform: uppercase;
        }

        .berita-card h4 {
            margin: 10px 0 6px;
            color: #fff;
            font-size: 15px;
            line-height: 1.35;
        }

        .berita-card ul {
            margin: 0;
            padding-left: 18px;
            color: var(--text-muted);
            font-size: 13px;
        }

        .berita-card li {
            margin: 6px 0;
        }
    </style>
    <style>
        /* berita section */
        .berita {
            padding: 14px 14px;
            width: 100%;
            max-width: 820px;
            margin: 0 auto;
            background: rgba(18, 7, 7, 0.20);
            border: 1px solid rgba(234, 175, 55, 0.18);
            border-radius: 14px;
        }

        .berita h3 {
            color: var(--gold);
            font-family: 'Playfair Display', serif;
            margin-bottom: 12px;
            font-size: 1.6rem;
        }

        .berita p.lead {
            color: var(--text-muted);
            margin-bottom: 18px;
        }

        .berita-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 14px;
            margin-top: 10px;
        }

        .berita-card {
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 12px;
            padding: 14px;
        }

        .berita-card .tag {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 999px;
            border: 1px solid rgba(212, 175, 55, 0.35);
            color: rgba(212, 175, 55, 0.98);
            font-weight: 800;
            font-size: 12px;
            text-transform: uppercase;
        }

        .berita-card h4 {
            margin: 10px 0 6px;
            color: #fff;
            font-size: 15px;
            line-height: 1.35;
        }

        .berita-card ul {
            margin: 0;
            padding-left: 18px;
            color: var(--text-muted);
            font-size: 13px;
        }

        .berita-card li {
            margin: 6px 0;
        }

        /* --- Footer Premium --- */
        .site-footer {
            background: #050403;
            padding: 60px 50px 30px;
            /* Jarak atas lebih lega, bawah lebih rapat */
            border-top: 1px solid rgba(212, 175, 55, 0.15);
        }

        .footer-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            /* Sejajar dengan grid menu kopi Anda */
            margin: 0 auto;
            padding-bottom: 40px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            /* Garis pemisah tipis */
        }

        .footer-brand h2 {
            font-family: 'Playfair Display', serif;
            color: var(--gold);
            font-size: 2rem;
            margin-bottom: 5px;
            letter-spacing: 1px;
        }

        .footer-brand p {
            color: var(--text-muted);
            font-size: 0.95rem;
        }

        .footer-social {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .footer-social a {
            color: var(--gold);
            text-decoration: none;
            font-size: 12px;
            letter-spacing: 1px;
            text-transform: uppercase;
            padding: 10px 24px;
            border: 1px solid rgba(212, 175, 55, 0.3);
            border-radius: 50px;
            transition: all 0.3s ease;
            font-weight: 600;
        }

        .footer-social a:hover {
            background: var(--gold);
            color: var(--bg-dark);
            border-color: var(--gold);
            box-shadow: 0 5px 15px rgba(212, 175, 55, 0.15);
            transform: translateY(-2px);
        }

        .footer-bottom {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            padding-top: 25px;
        }

        .footer-bottom p,
        .footer-links a {
            font-size: 13px;
            color: var(--text-muted);
            text-decoration: none;
            transition: 0.3s;
        }

        .footer-links {
            display: flex;
            gap: 20px;
        }

        .footer-links a:hover {
            color: var(--gold);
        }

        /* --- SECTION VENUES & BERITA (TWO COLUMNS) --- */
        .info-section {
            padding: 80px 5%;
            background: #050403;
            /* Warna dasar gelap */
        }

        .info-container {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1.2fr;
            /* Kolom berita sedikit lebih lebar */
            gap: 50px;
            align-items: start;
        }

        /* Global Header untuk Section */
        .section-header h2 {
            font-family: 'Playfair Display', serif;
            font-size: 2.2rem;
            color: var(--gold, #d4af37);
            margin-bottom: 10px;
        }

        .section-header p {
            color: var(--text-muted, #999);
            font-size: 0.95rem;
            line-height: 1.5;
            margin-bottom: 25px;
        }

        /* --- KIRI: VENUE LIST --- */
        .venue-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .venue-item {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-left: 3px solid var(--gold, #d4af37);
            /* Aksen emas di kiri */
            padding: 20px;
            border-radius: 8px;
            transition: 0.3s ease;
        }

        .venue-item:hover {
            background: rgba(255, 255, 255, 0.06);
            transform: translateX(5px);
        }

        .venue-item h4 {
            color: #fff;
            font-size: 1.1rem;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .venue-item p {
            font-size: 0.85rem;
            color: #bbb;
            margin: 0;
            line-height: 1.6;
        }

        /* Badge Status */
        .status-badge {
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 0.75rem;
            text-transform: uppercase;
            margin-left: 5px;
        }

        .status-warning {
            background: rgba(255, 193, 7, 0.15);
            color: #ffc107;
        }

        .status-danger {
            background: rgba(220, 53, 69, 0.15);
            color: #dc3545;
        }


        /* --- KANAN: BERITA GRID --- */
        .berita-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px;
        }

        .berita-card {
            background: rgba(212, 175, 55, 0.03);
            /* Sentuhan emas sangat tipis */
            border: 1px solid rgba(212, 175, 55, 0.15);
            border-radius: 12px;
            padding: 24px;
            transition: 0.3s ease;
        }

        .berita-card:hover {
            border-color: var(--gold, #d4af37);
            box-shadow: 0 5px 20px rgba(212, 175, 55, 0.08);
        }

        .berita-card .tag {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 50px;
            border: 1px solid var(--gold, #d4af37);
            color: var(--gold, #d4af37);
            font-weight: 700;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 12px;
        }

        .berita-card h4 {
            color: #fff;
            font-size: 1.1rem;
            margin-bottom: 12px;
            line-height: 1.4;
        }

        .berita-card ul {
            margin: 0;
            padding-left: 18px;
            color: var(--text-muted, #999);
            font-size: 0.9rem;
            line-height: 1.6;
        }

        .berita-card li {
            margin-bottom: 6px;
        }

        /* --- RESPONSIVE MOBILE --- */
        @media(max-width: 992px) {
            .info-container {
                grid-template-columns: 1fr;
                /* Berubah jadi atas-bawah di layar kecil */
                gap: 40px;
            }
        }
    </style>
</head>

<body>
    <header>
        <a href="#" class="logo">bekalkopibdg.</a>
        <nav>
            <a href="#beans">Filosofi Biji</a>
            <a href="#menu">Katalog Eksklusif</a>
            <a href="#venues">Lokasi (Venues)</a>
            <a href="#berita">berita</a>
            <a href="login.php" class="btn-login">Portal Eksekutif</a>
        </nav>
    </header>

    <section class="hero">
        <div class="hero-content">
            <h1>Kopi Kelas Atas, Menemani Mobilitas Anda.</h1>
            <p>Diekstraksi dari biji kopi nusantara kualitas premium. Disajikan dalam botol eksklusif untuk gaya hidup urban Bandung yang dinamis dan berkelas.</p>
            <a href="#menu" class="btn-primary">Jelajahi Rasa</a>
        </div>
    </section>

    <section id="beans" class="beans-section">
        <div class="section-header">
            <h2>Karakteristik Biji Kopi Kami</h2>
            <p>Rahasia di balik setiap tetes bekalkopibdg adalah seleksi ketat biji kopi dari dataran tinggi terbaik di Indonesia, di roasting oleh artisan profesional.</p>
        </div>
        <div class="beans-grid">
            <div class="bean-card">
                <div class="bean-icon">🌱</div>
                <h3>Sumatra Gayo Premium</h3>
                <p>Profil rasa yang berat full-bodied dengan tingkat keasaman yang sangat rendah. Menghasilkan aroma rempah earthy yang elegan, sangat cocok untuk menu Americano Botolan kami yang murni dan tegas.</p>
            </div>
            <div class="bean-card">
                <div class="bean-icon">⛰️</div>
                <h3>Priangan Highland Arabica</h3>
                <p>Dipanen dari tanah vulkanik Jawa Barat. Biji ini menawarkan notes karamel dan sedikit sentuhan buah beri manis. Karakter inilah yang membuat menu Signature kami terasa lembut namun berkarakter.</p>
            </div>
            <div class="bean-card">
                <div class="bean-icon">⚖️</div>
                <h3>bekal House Blend</h3>
                <p>Racikan rahasia 70% Arabica dan 30% Fine Robusta. Didesain khusus agar rasa kopi tetap kuat menembus campuran susu segar dan gula aren asli, menciptakan Kopi Susu Gula Aren yang creamy dan bold.</p>
            </div>
        </div>
    </section>

    <section id="menu" class="menu-section">
        <div class="section-header">
            <h2>Katalog Eksklusif</h2>
            <p>Pilih botol pendamping aktivitas Anda hari ini. Segar, dingin, dan dikurasi dengan presisi tinggi.</p>
        </div>
        <div class="menu-grid">
            <?php
            if ($result_produk && $result_produk->num_rows > 0) {
                while ($row = $result_produk->fetch_assoc()) {
                    $harga_rp = "Rp " . number_format((float)$row['harga'], 0, ',', '.');
                    echo "
                    <div class='menu-item'>
                        <h3>" . htmlspecialchars($row['nama_kopi']) . "</h3>
                        <p>" . htmlspecialchars($row['deskripsi'] ?? '') . "</p>
                        <span class='menu-price'>" . $harga_rp . "</span>
                        <button class='btn-order' onclick='alert(\"Menghubungkan ke Gateway WooCommerce... Silakan hubungi admin kami untuk sementara waktu.\")'>Pesan & Antar</button>
                    </div>";
                }
            } else {
                echo "<p style='text-align:center; color:var(--text-muted); grid-column: 1 / -1;'>Katalog sedang dalam pembaruan kualitas. Silakan periksa kembali nanti.</p>";
            }
            ?>
        </div>
    </section>

    <section class="info-section">
        <div class="info-container">

            <!-- KOLOM KIRI: Live Venues -->
            <div class="venue-side">
                <div class="section-header">
                    <h2>Live Venues & Armada</h2>
                    <p>Lacak titik distribusi motor box kami di area Bandung Raya hari ini.</p>
                </div>

                <div class="venue-list">
                    <div class="venue-item">
                        <h4>📍 Area Lengkong (Kampus)</h4>
                        <p>Di belakang restoran Suharti.<br>Waktu: 09.00 - 14.00 WIB.<br>
                            Status: <span class="status-badge status-warning">Persiapan</span></p>
                    </div>

                    <div class="venue-item">
                        <h4>📍 Kawasan Braga</h4>
                        <p>Pedestrian Braga Pendek.<br>Waktu: 15.00 - 21.00 WIB.<br>
                            Status: <span class="status-badge status-warning">Persiapan</span></p>
                    </div>

                    <div class="venue-item">
                        <h4>📍 Dago Car Free Day</h4>
                        <p>Spesifik hari Minggu pagi.<br>
                            Status: <span class="status-badge status-danger">Tutup</span></p>
                    </div>
                </div>
            </div>

            <!-- KOLOM KANAN: Berita -->
            <div class="berita-side">
                <div class="section-header">
                    <h2>Berita 2026</h2>
                    <p>Update cepat tren Indonesia untuk ekosistem event, mobilitas, dan kuliner.</p>
                </div>

                <div class="berita-grid">
                    <div class="berita-card">
                        <span class="tag">Mobilitas</span>
                        <h4>Arus Event Makin Padat & Terjadwal</h4>
                        <ul>
                            <li>Permintaan Coffee Bar untuk kampus & komunitas meningkat.</li>
                            <li>Slot layanan dibuat lebih terstruktur per sesi.</li>
                        </ul>
                    </div>

                    <div class="berita-card">
                        <span class="tag">Komunitas</span>
                        <h4>Brand Lokal Makin Eksis di Aktivasi Jalanan</h4>
                        <ul>
                            <li>Kolaborasi komunitas kreatif berperan besar dalam event.</li>
                            <li>Stand minuman botolan jadi pilihan karena praktis.</li>
                        </ul>
                    </div>

                    <div class="berita-card">
                        <span class="tag">Kualitas</span>
                        <h4>Konsumen Minta Transparansi Rasa & Varian</h4>
                        <ul>
                            <li>Deskripsi varian kopi lebih detail jadi standar.</li>
                            <li>Tren menu berfokus pada rasa premium & konsisten.</li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <!-- <footer>
        <div class="social-links">
            <a href="#">Instagram</a>
            <a href="#">TikTok</a>
            <a href="#">WhatsApp Admin</a>
        </div>
        <p class="footer-text">&copy; 2026 bekalkopibdg | Premium Mobile Coffee Hub Bandung. All Rights Reserved.</p>

    </footer> -->

    <footer class="site-footer">
        <div class="footer-content">
            <div class="footer-brand">
                <h2>bekalkopibdg.</h2>
                <p>Premium Mobile Coffee Hub Bandung.</p>
            </div>
            <div class="footer-social">
                <a href="#">Instagram</a>
                <a href="#">TikTok</a>
                <a href="#">WhatsApp</a>
            </div>
        </div>

        <div class="footer-bottom">
            <p class="footer-text">&copy; 2026 bekalkopibdg. All Rights Reserved.</p>
            <div class="footer-links">
                <a href="#">Syarat & Ketentuan</a>
                <a href="#">Kebijakan Privasi</a>
            </div>
        </div>
    </footer>

</body>

</html>
