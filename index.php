<?php
// Memanggil koneksi database
require 'db.php';

// Mengambil data produk untuk Katalog Menu
$query_produk = "SELECT * FROM products WHERE stok > 0";
$result_produk = $conn->query($query_produk);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- /SEO/ Meta Tags -->
    <meta name="description" content="bekalkopibdg - Premium Mobile Coffee di Bandung. Menyajikkan biji kopi nusantara pilihan dalam kemasan botol eksklusif. Booking untuk event atau temukan venue kami.">
    <meta name="keywords" content="Kopi botolan premium, Kopi keliling Bandung, bekalkopibdg, Arabica Gayo, Event kopi, Franchise kopi">
    <title>bekalkopibdg | Premium Mobile Coffee Bandung</title>
    
    <!-- Google Fonts: Playfair Display (Mewah/Klasik) & Montserrat (Modern) -->
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

        * { margin: 0; padding: 0; box-sizing: border-box; scroll-behavior: smooth; }
        body { background-color: var(--bg-dark); color: var(--text-main); font-family: 'Montserrat', sans-serif; line-height: 1.6; }
        h1, h2, h3, .logo { font-family: 'Playfair Display', serif; }

        /* --- Navbar --- */
        header { position: fixed; top: 0; width: 100%; padding: 20px 50px; display: flex; justify-content: space-between; align-items: center; background: rgba(15, 12, 10, 0.8); backdrop-filter: blur(10px); z-index: 1000; border-bottom: 1px solid rgba(212, 175, 55, 0.1); transition: 0.3s; }
        .logo { font-size: 28px; color: var(--gold); letter-spacing: 2px; text-decoration: none; font-weight: 700; }
        nav a { color: var(--text-main); text-decoration: none; margin-left: 30px; font-size: 13px; text-transform: uppercase; letter-spacing: 1px; transition: color 0.3s; }
        nav a:hover { color: var(--gold); }
        .btn-login { border: 1px solid var(--gold); padding: 8px 20px; border-radius: 50px; color: var(--gold); }
        .btn-login:hover { background: var(--gold); color: var(--bg-dark); }

        /* --- Hero Section --- */
        .hero { height: 100vh; display: flex; align-items: center; justify-content: center; text-align: center; background: linear-gradient(rgba(15, 12, 10, 0.6), rgba(15, 12, 10, 0.9)), url('https://images.unsplash.com/photo-1497935586351-b67a49e012bf?auto=format&fit=crop&w=1920&q=80') center/cover no-repeat; padding: 0 20px; }
        .hero-content { max-width: 800px; animation: fadeIn 1.5s ease-in-out; }
        .hero h1 { font-size: 4rem; color: var(--gold); margin-bottom: 20px; line-height: 1.2; }
        .hero p { font-size: 1.1rem; color: var(--text-muted); margin-bottom: 40px; }
        .btn-primary { background: linear-gradient(135deg, var(--gold), #aa8022); color: var(--bg-dark); padding: 15px 35px; text-decoration: none; font-weight: 600; font-size: 14px; text-transform: uppercase; letter-spacing: 2px; border-radius: 4px; transition: 0.3s; display: inline-block; }
        .btn-primary:hover { box-shadow: 0 10px 20px rgba(212, 175, 55, 0.3); transform: translateY(-3px); }

        /* --- Section Titles --- */
        .section-header { text-align: center; margin-bottom: 60px; }
        .section-header h2 { font-size: 2.5rem; color: var(--gold); margin-bottom: 15px; }
        .section-header p { color: var(--text-muted); font-size: 1rem; max-width: 600px; margin: 0 auto; }

        /* --- The Beans Story (Deskripsi Biji Kopi) --- */
        .beans-section { padding: 100px 50px; background-color: var(--bg-light); }
        .beans-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 40px; max-width: 1200px; margin: 0 auto; }
        .bean-card { text-align: center; padding: 30px; border: 1px solid rgba(212, 175, 55, 0.1); border-radius: 8px; transition: 0.4s; background: rgba(0,0,0,0.2); }
        .bean-card:hover { border-color: var(--gold); transform: translateY(-10px); }
        .bean-icon { font-size: 40px; margin-bottom: 20px; color: var(--gold); }
        .bean-card h3 { font-size: 1.5rem; margin-bottom: 15px; color: var(--text-main); }
        .bean-card p { font-size: 0.95rem; color: var(--text-muted); }

        /* --- Menu Penjualan --- */
        .menu-section { padding: 100px 50px; }
        .menu-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 30px; max-width: 1200px; margin: 0 auto; }
        .menu-item { background: var(--bg-light); border-radius: 8px; padding: 30px 20px; text-align: center; position: relative; overflow: hidden; border: 1px solid rgba(255,255,255,0.05); transition: 0.3s; }
        .menu-item:hover { background: rgba(212, 175, 55, 0.05); border-color: rgba(212, 175, 55, 0.3); }
        .menu-item h3 { font-size: 1.4rem; color: var(--gold); margin-bottom: 10px; }
        .menu-item p { font-size: 0.9rem; color: var(--text-muted); margin-bottom: 20px; height: 60px; }
        .menu-price { font-size: 1.5rem; font-weight: 600; color: var(--text-main); display: block; margin-bottom: 20px; }
        .btn-order { background: transparent; border: 1px solid var(--gold); color: var(--gold); padding: 10px 20px; cursor: pointer; border-radius: 4px; font-family: 'Montserrat'; font-weight: 600; font-size: 12px; text-transform: uppercase; letter-spacing: 1px; transition: 0.3s; width: 100%; }
        .btn-order:hover { background: var(--gold); color: var(--bg-dark); }

        /* --- Venues & Booking --- */
        .venue-booking { display: flex; flex-wrap: wrap; }
        .venue-side, .booking-side { flex: 1; min-width: 300px; padding: 100px 50px; }
        
        .venue-side { background: linear-gradient(rgba(26, 22, 19, 0.9), rgba(26, 22, 19, 0.9)), url('https://images.unsplash.com/photo-1447933601403-0c6688de566e?auto=format&fit=crop&w=800&q=80') center/cover; }
        .venue-list { margin-top: 40px; }
        .venue-item { padding: 20px; border-bottom: 1px solid rgba(212,175,55,0.2); }
        .venue-item h4 { color: var(--gold); font-size: 1.2rem; margin-bottom: 5px; }
        
        .booking-side { background: var(--bg-dark); }
        .booking-form { margin-top: 40px; }
        .input-group { margin-bottom: 20px; }
        .input-group input, .input-group select, .input-group textarea { width: 100%; background: var(--bg-light); border: 1px solid rgba(255,255,255,0.1); color: var(--text-main); padding: 15px; font-family: 'Montserrat'; font-size: 14px; border-radius: 4px; outline: none; transition: 0.3s; }
        .input-group input:focus, .input-group select:focus, .input-group textarea:focus { border-color: var(--gold); }
        
        /* --- Footer --- */
        footer { background: #050403; padding: 40px 50px; text-align: center; border-top: 1px solid rgba(212,175,55,0.2); }
        .social-links { margin-bottom: 20px; }
        .social-links a { color: var(--gold); margin: 0 15px; text-decoration: none; font-size: 14px; letter-spacing: 1px; text-transform: uppercase; }
        .footer-text { font-size: 12px; color: var(--text-muted); }

        @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }

        /* Responsive */
        @media(max-width: 768px) {
            header { padding: 15px 20px; flex-direction: column; gap: 15px; }
            nav a { margin: 0 10px; }
            .hero h1 { font-size: 2.5rem; }
            .venue-side, .booking-side { padding: 50px 20px; }
        }
    </style>
</head>
<body>

    <!-- Header / Navbar -->
    <header>
        <a href="#" class="logo">bekalkopibdg.</a>
        <nav>
            <a href="#beans">Filosofi Biji</a>
            <a href="#menu">Katalog Eksklusif</a>
            <a href="#venues">Lokasi (Venues)</a>
            <a href="#booking">Reservasi Event</a>
            <a href="login.php" class="btn-login">Portal Eksekutif</a>
        </nav>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1>Kopi Kelas Atas, Menemani Mobilitas Anda.</h1>
            <p>Diekstraksi dari biji kopi nusantara kualitas premium. Disajikan dalam botol eksklusif untuk gaya hidup urban Bandung yang dinamis dan berkelas.</p>
            <a href="#menu" class="btn-primary">Jelajahi Rasa</a>
        </div>
    </section>

    <!-- The Beans Story (Deskripsi Biji Kopi) -->
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

    <!-- Katalog Menu (Data Dinamis dari Database) -->
    <section id="menu" class="menu-section">
        <div class="section-header">
            <h2>Katalog Eksklusif</h2>
            <p>Pilih botol pendamping aktivitas Anda hari ini. Segar, dingin, dan dikurasi dengan presisi tinggi.</p>
        </div>
        <div class="menu-grid">
            <?php
            if ($result_produk->num_rows > 0) {
                while($row = $result_produk->fetch_assoc()) {
                    $harga_rp = "Rp " . number_format($row['harga'], 0, ',', '.');
                    echo "
                    <div class='menu-item'>
                        <h3>" . htmlspecialchars($row['nama_kopi']) . "</h3>
                        <p>" . htmlspecialchars($row['deskripsi']) . "</p>
                        <span class='menu-price'>" . $harga_rp . "</span>
                        <button class='btn-order' onclick='alert(\"Menghubungkan ke Gateway WooCommerce... Silakan hubungi admin kami untuk sementara waktu.\")'>Pesan & Antar</button>
                    </div>
                    ";
                }
            } else {
                echo "<p style='text-align:center; color:var(--text-muted); grid-column: 1 / -1;'>Katalog sedang dalam pembaruan kualitas. Silakan periksa kembali nanti.</p>";
            }
            ?>
        </div>
    </section>

    <!-- Venues & Booking Area -->
    <section class="venue-booking">
        <!-- Live Venues -->
        <div id="venues" class="venue-side">
            <h2 style="font-family: 'Playfair Display'; font-size: 2rem; color: var(--gold);">Live Venues & Armada</h2>
            <p style="color: var(--text-muted); margin-top: 10px;">Lacak titik distribusi motor box kami di area Bandung Raya hari ini.</p>
            
            <div class="venue-list">
                <div class="venue-item">
                    <h4>📍 Area Lengkong (Kampus)</h4>
                    <p style="font-size: 13px; color: #ccc;"> dibelakang restoran suharti. Waktu: 09.00 - 14.00 WIB. (Status: <span style="color:#ffc107;">Persiapan</span>)</p>
                </div>
                <div class="venue-item">
                    <h4>📍 Kawasan Braga</h4>
                    <p style="font-size: 13px; color: #ccc;">Pedestrian Braga Pendek. Waktu: 15.00 - 21.00 WIB. (Status: <span style="color:#ffc107;">Persiapan</span>)</p>
                </div>
                <div class="venue-item">
                    <h4>📍 Dago Car Free Day</h4>
                    <p style="font-size: 13px; color: #ccc;">Spesifik Hari Minggu Pagi. (Status: <span style="color:#dc3545;">Tutup</span>)</p>
                </div>
            </div>
        </div>

        <!-- Event Booking Form -->
        <div id="booking" class="booking-side">
            <h2 style="font-family: 'Playfair Display'; font-size: 2rem; color: var(--gold);">Reservasi Privat & Event</h2>
            <p style="color: var(--text-muted); margin-top: 10px;">Bawa kemewahan *bekalkopibdg* ke acara pernikahan, gathering perusahaan, atau acara eksklusif kampus Anda.</p>
            
            <form class="booking-form" onsubmit="event.preventDefault(); alert('Proposal reservasi Anda telah masuk. Tim operasional kami akan segera menghubungi Anda.');">
                <div class="input-group">
                    <input type="text" placeholder="Nama Lengkap / Nama Instansi" required>
                </div>
                <div class="input-group">
                    <input type="text" placeholder="Nomor WhatsApp Aktif" required>
                </div>
                <div class="input-group">
                    <select required>
                        <option value="" disabled selected>Pilih Jenis Layanan Eksekutif</option>
                        <option value="wedding">Pesta Pernikahan (Wedding Coffee Bar)</option>
                        <option value="corporate">Gathering Perusahaan (Corporate Suplly)</option>
                        <option value="campus">Sponsorship Event Kampus (Himpunan/BEM)</option>
                        <option value="custom">Pesanan Kustom Massal (Bulk Order)</option>
                    </select>
                </div>
                <div class="input-group">
                    <textarea rows="4" placeholder="Jelaskan detail acara Anda (Tanggal, Lokasi di Bandung, Perkiraan Porsi...)" required></textarea>
                </div>
                <button type="submit" class="btn-primary" style="width: 100%; border:none;">Kirim Permintaan Reservasi</button>
            </form>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="social-links">
            <a href="#">Instagram</a>
            <a href="#">TikTok</a>
            <a href="#">WhatsApp Admin</a>
        </div>
        <p class="footer-text">&copy; 2026 bekalkopibdg | Premium Mobile Coffee Hub Bandung. All Rights Reserved.</p>
    </footer>

</body>
</html>