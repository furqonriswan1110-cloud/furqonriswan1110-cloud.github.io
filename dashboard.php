<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id  = $_SESSION['user_id'];
$username = $_SESSION['username'] ?? '';
$role     = $_SESSION['role'] ?? '';

$result_produk = $conn->query("SELECT * FROM products");
function e(mixed $v): string { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | bekalkopibdg</title>
    <style>
        :root {
            --primary: #4A3022;
            --secondary: #D4A373;
            --success: #2a9d8f;
            --danger: #e63946;
            --dark: #1d1a18;
            --white: #ffffff;
            --bg: #f7f5f0;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', Roboto, sans-serif; }
        body { background-color: var(--bg); color: var(--dark); display: flex; min-height: 100vh; }

        .sidebar {
            width: 260px;
            background-color: var(--primary);
            color: var(--white);
            padding: 20px;
            display: flex;
            flex-direction: column;
        }
        .sidebar h2 {
            font-size: 20px;
            text-align: center;
            margin-bottom: 30px;
            letter-spacing: 1px;
            color: var(--secondary);
        }
        .user-info {
            background: rgba(255,255,255,0.1);
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 25px;
            text-align: center;
        }
        .user-info span { display: block; font-size: 12px; color: var(--secondary); text-transform: uppercase; font-weight: 800; }

        .sidebar a {
            color: #f0e6df;
            text-decoration: none;
            padding: 12px 15px;
            display: block;
            border-radius: 5px;
            margin-bottom: 8px;
            font-size: 14px;
            transition: 0.3s;
        }
        .sidebar a:hover, .sidebar a.active {
            background-color: var(--secondary);
            color: var(--primary);
            font-weight: bold;
        }
        .logout-btn { margin-top: auto; background-color: var(--danger) !important; color: white !important; text-align: center; }

        .main-content { flex: 1; padding: 40px 30px; overflow-y: auto; }
        .header-title { margin-bottom: 30px; border-bottom: 2px solid var(--primary); padding-bottom: 10px; display: flex; justify-content: space-between; align-items: center; }

        .grid-3 { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; margin-bottom: 30px; }
        .card { background: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); border-left: 5px solid var(--secondary); }
        .card.success { border-left-color: var(--success); }
        .card h3 { font-size: 14px; color: #777; text-transform: uppercase; margin-bottom: 10px; }
        .card .value { font-size: 24px; font-weight: bold; color: var(--primary); }

        .section-block {
            background: #fff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
            margin-bottom: 30px;
        }
        .section-block h2 { font-size: 18px; margin-bottom: 20px; color: var(--primary); display: flex; align-items: center; gap: 10px; }

        table { width: 100%; border-collapse: collapse; margin-top: 10px; font-size: 14px; }
        th, td { padding: 12px 15px; text-align: left; border-bottom: 1px solid #eee; }
        th { background-color: #fcfbfa; color: var(--primary); font-weight: bold; }
        tr:hover { background-color: #faf9f6; }

        .badge { padding: 4px 8px; border-radius: 4px; font-size: 11px; font-weight: 800; text-transform: uppercase; }
        .badge.bos { background: #ffdde1; color: #ee6055; }
        .badge.manajer { background: #e2e2ff; color: #4d4dff; }
        .badge.karyawan { background: #e3faf2; color: #2a9d8f; }
        .badge.corlab { background: #fff3cd; color: #856404; }
        .badge.pengguna { background: #dbeafe; color: #1d4ed8; }

        .catalog-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px; }
        .catalog-item { background: #fff; border: 1px solid #eedec4; border-radius: 8px; padding: 15px; text-align: center; }
        .catalog-item h4 { color: var(--primary); margin-bottom: 8px; }
        .catalog-item p { font-size: 12px; color: #666; margin-bottom: 12px; height: 36px; overflow: hidden; }
        .catalog-item .price { font-weight: bold; color: var(--secondary); display: block; margin-bottom: 10px; }

        .btn {
            background: var(--primary);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            font-size: 14px;
            text-decoration: none;
            display: inline-block;
        }
        .btn:hover { background: var(--secondary); color: var(--primary); }

        .action-row { display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 16px; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; font-size: 13px; font-weight: bold; margin-bottom: 5px; }
        .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 14px; }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>bekalkopibdg</h2>
        <div class="user-info">
            <p><strong><?= e($username) ?></strong></p>
            <span class="badge <?= e($role) ?>"><?= e($role) ?></span>
        </div>
        <a href="index.php" target="_blank">🌐 Lihat Website Publik</a>
        <a href="input_data.php">📝 Halaman Input Data</a>
        <a href="edit_hapus.php">✏️ Form Edit & Hapus</a>
        <a href="dashboard.php" class="active">📊 Dashboard Utama</a>
        <a href="logout.php" class="logout-btn">Keluar Sistem</a>
    </div>

    <div class="main-content">
        <div class="header-title">
            <h1>Workspace Panel Operasional</h1>
            <p>Hari Ini: <strong><?= date('d M Y') ?></strong></p>
        </div>

        <?php if ($role === 'bos'): ?>
            <div class="grid-3">
                <div class="card success">
                    <h3>Total Omzet Bulan Ini (Rupiah)</h3>
                    <div class="value">Rp 24.550.000</div>
                </div>
                <div class="card">
                    <h3>Pengeluaran Operasional (Bahan & Bensin)</h3>
                    <div class="value" style="color: var(--danger);">Rp 9.120.000</div>
                </div>
                <div class="card success">
                    <h3>Profit Bersih Bersih</h3>
                    <div class="value" style="color: var(--success);">Rp 15.430.000</div>
                </div>
            </div>

            <div class="section-block">
                <div class="action-row">
                    <a href="input_data.php" class="btn">📝 Halaman Input Data</a>
                    <a href="edit_hapus.php" class="btn">✏️ Form Edit & Hapus</a>
                </div>
                <h2>📈 Rincian Arus Kas Masuk (Penjualan Keliling Bandung)</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Keterangan Operasional</th>
                            <th>Titik Penjualan (Venue)</th>
                            <th>Metode Pembayaran</th>
                            <th>Jumlah Masuk</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td>24/06/2026</td><td>Penjualan 80 Botol Aren Premium</td><td>Depan Telkom Dipatiukur</td><td>QRIS BCA</td><td>Rp 1.200.000</td></tr>
                        <tr><td>23/06/2026</td><td>Batch Order Himpunan Informatika UHS</td><td>Kampus UHS Bandung</td><td>Transfer Bank</td><td>Rp 2.500.000</td></tr>
                        <tr><td>22/06/2026</td><td>Penjualan Sore Santai Keliling</td><td>Area Lapangan Saparua</td><td>Tunai</td><td>Rp 750.000</td></tr>
                    </tbody>
                </table>
            </div>

            <div class="section-block">
                <h2>👥 Manajemen Karyawan Lapangan & Barista</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Nama Staff</th>
                            <th>Job Desk / Peran</th>
                            <th>Wilayah Kerja Hari Ini</th>
                            <th>Status Kehadiran</th>
                            <th>Performa Bulan Ini</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td>Rian Hidayat</td><td>Barista & Driver Motor Keliling</td><td>Dipatiukur - Dago</td><td><span class="badge">Bertugas</span></td><td>⭐ 4.8 (850 Botol Terjual)</td></tr>
                        <tr><td>Siti Aminah</td><td>Admin Media & Logistik Pusat</td><td>Basecamp Bandung</td><td><span class="badge">Standby</span></td><td>⭐ 4.9 (Stok Akurat)</td></tr>
                        <tr><td>Siti Aminah</td><td>Admin Media & Logistik Pusat</td><td>Basecamp Bandung</td><td><span class="badge">Standby</span></td><td>⭐ 4.9 (Stok Akurat)</td></tr>
                    </tbody>
                </table>
            </div>

            <div class="section-block">
                <h2>🔐 Hak Akses Akun & Kelola Pengguna</h2>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username Akun</th>
                            <th>Email Terdaftar</th>
                            <th>Hak Akses (Role)</th>
                            <th>Tindakan Operasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $get_users = $conn->query("SELECT id, username, email, role FROM users");
                        while($u = $get_users->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>".e($u['id'])."</td>";
                            echo "<td><strong>".e($u['username'])."</strong></td>";
                            echo "<td>".e($u['email'])."</td>";
                            echo "<td><span class='badge ".e($u['role'])."'>".e($u['role'])."</span></td>";
                            echo "<td>";
                            if ($u['role'] !== 'bos') {
                                echo "<a href='delete_proses.php?id=".e($u['id'])."&type=user' onclick='return confirm(\"Yakin ingin hapus akun ini?\")' style='color:var(--danger); text-decoration:none; font-weight:bold;'>Hapus Akses</a>";
                            } else {
                                echo "<span style='color:#aaa;'>Utama</span>";
                            }
                            echo "</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

        <?php elseif ($role === 'manajer'): ?>
            <div class="section-block">
                <h2>📦 Panel Kontrol Stok Kopi Botolan (Inventori Utama)</h2>
                <form method="POST" action="" style="margin-bottom: 25px; background:#fafafa; padding:15px; border-radius:6px;">
                    <h3 style="font-size:14px; margin-bottom:10px;">Aksi Cepat Tambah Stok Produk</h3>
                    <div style="display:flex; gap:15px; flex-wrap:wrap;">
                        <select name="prod_id" style="padding:8px; border-radius:4px; flex:1;" required>
                            <?php
                            if ($result_produk) {
                                $result_produk->data_seek(0);
                                while($p = $result_produk->fetch_assoc()) {
                                    echo "<option value='".e($p['id'])."'>".e($p['nama_kopi'])." (Sisa: ".e($p['stok'])." btl)</option>";
                                }
                            }
                            ?>
                        </select>
                        <input type="number" name="tambahan_stok" placeholder="+ Jumlah Botol" style="padding:8px; width:140px; border-radius:4px;" required>
                        <button type="submit" name="update_stok_action" class="btn" style="padding:8px 15px;">Perbarui Stok</button>
                    </div>
                </form>

                <?php
                if (isset($_POST['update_stok_action'])) {
                    $pid = (int)($_POST['prod_id'] ?? 0);
                    $t_stok = (int)($_POST['tambahan_stok'] ?? 0);
                    if ($pid > 0 && $t_stok !== 0) {
                        $conn->query("UPDATE products SET stok = stok + $t_stok WHERE id = $pid");
                    }
                    echo "<script>alert('Stok berhasil diperbarui!'); window.location='dashboard.php';</script>";
                    exit();
                }
                ?>

                <table>
                    <thead>
                        <tr>
                            <th>ID Varian</th>
                            <th>Nama Kopi Botol</th>
                            <th>Harga Jual</th>
                            <th>Sisa Stok</th>
                            <th>Status Logistik</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result_produk) {
                            $result_produk->data_seek(0);
                            while($p = $result_produk->fetch_assoc()) {
                                $status_stok = ((int)$p['stok'] > 15)
                                    ? "<span class='badge' style='background:#d1fae5; color:#065f46;'>Aman</span>"
                                    : "<span class='badge' style='background:#fef2f2; color:#b91c1c;'>Kritis</span>";

                                echo "<tr>";
                                echo "<td>".e($p['id'])."</td>";
                                echo "<td><strong>".e($p['nama_kopi'])."</strong></td>";
                                echo "<td>Rp ".number_format((float)$p['harga'], 0, ',', '.')."</td>";
                                echo "<td>".e($p['stok'])." Botol</td>";
                                echo "<td>{$status_stok}</td>";
                                echo "</tr>";
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <div class="section-block">
                <h2>📍 Pengaturan Distribusi Titik Jalan (Area Bandung Sekitarnya)</h2>
                <form method="POST" action="" onsubmit="event.preventDefault(); alert('Broadcast lokasi (demo)');">
                    <div class="grid-3" style="grid-template-columns: 1fr 1fr 1fr; margin-bottom:0;">
                        <div class="form-group">
                            <label>Pilih Karyawan Lapangan</label>
                            <select name="driver" required>
                                <option>Rian Hidayat (Motor Box 01)</option>
                                <option>Ahmad Faisal (Motor Box 02)</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Titik Penempatan Lokasi (Bandung)</label>
                            <select name="lokasi" required>
                                <option value="Dipatiukur">Depan Telkom Dipatiukur (Area Kampus)</option>
                                <option value="Saparua">GOR Lapangan Saparua</option>
                                <option value="Braga">Kawasan Pedestrian Braga</option>
                                <option value="Lengkong">Kuliner Malam Lengkong Kecil</option>
                                <option value="Dago">Pojok CFD Dago (Spesifik Hari Minggu)</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Alokasi Muatan Botol</label>
                            <input type="number" name="botol" placeholder="Contoh: 100 Botol" required>
                        </div>
                    </div>
                    <div style="margin-top: 15px;">
                        <button type="submit" class="btn">Broadcast Lokasi Hari Ini</button>
                    </div>
                </form>
            </div>

        <?php elseif ($role === 'pengguna'): ?>
            <div class="grid-3">
                <div class="card success" style="background: linear-gradient(135deg, #4A3022, #332015); color: white; border-left-color: #D4A373;">
                    <h3 style="color: #D4A373;">Kartu Member Digital</h3>
                    <div class="value" style="color: white; font-size:24px;">ID: BEKAL-<?= e(1000 + (int)$user_id) ?></div>
                    <p style="font-size:12px; margin-top:10px; color:#d4a373;">Kategori: <strong>GOLD LOYALIST</strong></p>
                </div>
                <div class="card">
                    <h3>Poin Kopi Anda Saat Ini</h3>
                    <div class="value" style="color: var(--success);">180 Poin</div>
                    <p style="font-size:12px; color:#666; margin-top:5px;">Kumpulkan 20 poin lagi untuk Klaim 1 Botol Gratis!</p>
                </div>
                <div class="card">
                    <h3>Status Member</h3>
                    <div class="value" style="color: var(--secondary);">Aktif</div>
                    <p style="font-size:12px; color:#666; margin-top:5px;">Silakan ajukan booking event kopi keliling.</p>
                </div>
            </div>

            <div class="section-block">
                <h2>☕ Katalog Eksklusif Rincian Karakteristik Kopi</h2>
                <div class="catalog-grid">
                    <?php
                    if ($result_produk) {
                        $result_produk->data_seek(0);
                        while($p = $result_produk->fetch_assoc()) {
                            $desc = $p['deskripsi'] ?? '';
                            echo "<div class='catalog-item'>";
                            echo "<h4>".e($p['nama_kopi'])."</h4>";
                            echo "<span class='price'>Rp ".number_format((float)$p['harga'], 0, ',', '.')."</span>";
                            echo "<p>".e($desc)."</p>";
                            echo "</div>";
                        }
                    }
                    ?>
                </div>
            </div>

            <div class="section-block">
                <h2>📅 Form Pengajuan Booking Layanan Kopi Keliling (Event/Gathering)</h2>
                <form method="POST" action="proses_booking.php">
                    <input type="hidden" name="submit_booking" value="1" />
                    <div class="form-group">
                        <label>Nama Lengkap / Nama Instansi</label>
                        <input type="text" name="nama_klien" placeholder="Contoh: Rani Putri" required>
                    </div>
                    <div class="form-group">
                        <label>Nomor WhatsApp Aktif</label>
                        <input type="text" name="no_wa" placeholder="08xxxxxxxxxx" required>
                    </div>
                    <div class="form-group">
                        <label>Jenis Layanan Kopi Keliling</label>
                        <select name="tipe_layanan" required>
                            <option value="Gathering Komunitas / Klub Motor">Gathering Komunitas / Klub Motor</option>
                            <option value="Seminar / Sidang Himpunan Kampus">Seminar / Sidang Himpunan Kampus</option>
                            <option value="Pesta Pernikahan / Syukuran Rumah">Pesta Pernikahan / Syukuran Rumah</option>
                            <option value="Corporate Event / Launching Produk">Corporate Event / Launching Produk</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Rincian Pesanan</label>
                        <textarea rows="4" name="rincian_pesanan" placeholder="Jelaskan detail acara Anda (tanggal, lokasi di Bandung, perkiraan porsi, dll)" required></textarea>
                    </div>
                    <button type="submit" class="btn">Kirim Form Reservasi Booking</button>
                </form>
            </div>

        <?php endif; ?>

    </div>
</body>
</html>

