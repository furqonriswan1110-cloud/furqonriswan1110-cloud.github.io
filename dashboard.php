<?php
session_start();
require 'db.php';

// Proteksi Halaman: Jika belum login, tendang ke login.php
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id  = $_SESSION['user_id'];
$username = $_SESSION['username'];
$role     = $_SESSION['role'];

// Ambil data produk untuk modul Manajer & Pengguna
$query_produk = "SELECT * FROM products";
$result_produk = $conn->query($query_produk);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pusat Kontrol Sistem - bekalkopibdg</title>
    <style>
        :root {
            --primary: #4A3022;
            --secondary: #D4A373;
            --success: #2a9d8f;
            --danger: #e63946;
            --dark: #1d1a18;
            --light: #FAEDCD;
            --white: #ffffff;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', Roboto, sans-serif; }
        body { background-color: #f7f5f0; color: var(--dark); display: flex; min-height: 100vh; }
        
        /* Sidebar Navigation */
        .sidebar { width: 260px; background-color: var(--primary); color: var(--white); padding: 20px; display: flex; flex-direction: column; }
        .sidebar h2 { font-size: 20px; text-align: center; margin-bottom: 30px; letter-spacing: 1px; color: var(--secondary); }
        .user-info { background: rgba(255,255,255,0.1); padding: 15px; border-radius: 8px; margin-bottom: 25px; text-align: center; }
        .user-info span { display: block; font-size: 12px; color: var(--secondary); text-transform: uppercase; font-weight: bold; }
        .sidebar a { color: #f0e6df; text-decoration: none; padding: 12px 15px; display: block; border-radius: 5px; margin-bottom: 8px; font-size: 14px; transition: 0.3s; }
        .sidebar a:hover, .sidebar a.active { background-color: var(--secondary); color: var(--primary); font-weight: bold; }
        .logout-btn { margin-top: auto; background-color: var(--danger) !important; color: white !important; text-align: center; }

        /* Main Content Workspace */
        .main-content { flex: 1; padding: 40px 30px; overflow-y: auto; }
        .header-title { margin-bottom: 30px; border-bottom: 2px solid var(--primary); padding-bottom: 10px; display: flex; justify-content: space-between; align-items: center; }
        
        /* UI Components: Cards & Tables */
        .grid-3 { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; margin-bottom: 30px; }
        .card { background: var(--white); padding: 20px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); border-left: 5px solid var(--secondary); }
        .card.success { border-left-color: var(--success); }
        .card h3 { font-size: 14px; color: #777; text-transform: uppercase; margin-bottom: 10px; }
        .card .value { font-size: 24px; font-weight: bold; color: var(--primary); }
        
        .section-block { background: var(--white); padding: 25px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); margin-bottom: 30px; }
        .section-block h2 { font-size: 18px; margin-bottom: 20px; color: var(--primary); display: flex; align-items: center; gap: 10px; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 10px; font-size: 14px; }
        th, td { padding: 12px 15px; text-align: left; border-bottom: 1px solid #eee; }
        th { background-color: #fcfbfa; color: var(--primary); font-weight: bold; }
        tr:hover { background-color: #faf9f6; }
        
        /* Forms & Badges */
        .badge { padding: 4px 8px; border-radius: 4px; font-size: 11px; font-weight: bold; text-transform: uppercase; }
        .badge.bos { background: #ffdde1; color: #ee6055; }
        .badge.manajer { background: #e2e2ff; color: #4d4dff; }
        .badge.karyawan { background: #e3faf2; color: #2a9d8f; }
        .badge.corlab { background: #fff3cd; color: #856404; }
        .badge.active { background: #d4edda; color: #155724; }
        
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; font-size: 13px; font-weight: bold; margin-bottom: 5px; }
        .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 14px; }
        .btn { background: var(--primary); color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; font-weight: bold; font-size: 14px; }
        .btn:hover { background: var(--secondary); color: var(--primary); }
        
        /* Product Catalog Grid for Customer View */
        .catalog-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px; }
        .catalog-item { background: #fff; border: 1px solid #eedec4; border-radius: 8px; padding: 15px; text-align: center; }
        .catalog-item h4 { color: var(--primary); margin-bottom: 8px; }
        .catalog-item p { font-size: 12px; color: #666; margin-bottom: 12px; height: 36px; overflow: hidden; }
        .catalog-item .price { font-weight: bold; color: var(--secondary); display: block; margin-bottom: 10px; }
    </style>
</head>
<body>

    <!-- SIDEBAR -->
    <div class="sidebar">
        <h2>bekalkopibdg</h2>
        <div class="user-info">
            <p><strong><?php echo htmlspecialchars($username); ?></strong></p>
            <span class="badge <?php echo $role; ?>"><?php echo $role; ?></span>
        </div>
        <a href="index.php" target="_blank">🌐 Lihat Website Publik</a>
        <a href="dashboard.php" class="active">📊 Dashboard Utama</a>
        <a href="logout.php" class="logout-btn">Keluar Sistem</a>
    </div>

    <!-- MAIN CONTENT WORKSPACE -->
    <div class="main-content">
        <div class="header-title">
            <h1>Workspace Panel Operasional</h1>
            <p>Hari Ini: <strong><?php echo date('d M Y'); ?></strong></p>
        </div>

        <!-- ==================== VIEW: BOS ==================== -->
        <?php if ($role == 'bos'): ?>
            <!-- Laporan Keuangan Komprehensif -->
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

            <!-- Manajemen Karyawan -->
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
                        <tr><td>Rian Hidayat</td><td>Barista & Driver Motor Keliling</td><td>Dipatiukur - Dago</td><td><span class="badge active">Bertugas</span></td><td>⭐ 4.8 (850 Botol Terjual)</td></tr>
                        <tr><td>Siti Aminah</td><td>Admin Media & Logistik Pusat</td><td>Basecamp Bandung</td><td><span class="badge active">Standby</span></td><td>⭐ 4.9 (Stok Akurat)</td></tr>
                    </ul>
                </table>
            </div>

            <!-- Kelola Pengguna (Terintegrasi Sistem Database Nyata) -->
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
                            echo "<tr>
                                    <td>{$u['id']}</td>
                                    <td><strong>{$u['username']}</strong></td>
                                    <td>{$u['email']}</td>
                                    <td><span class='badge {$u['role']}'>{$u['role']}</span></td>
                                    <td>";
                            if($u['role'] != 'bos') {
                                echo "<a href='delete_proses.php?id={$u['id']}' onclick='return confirm(\"Yakin ingin hapus akun ini?\")' style='color:var(--danger); text-decoration:none; font-weight:bold;'>Hapus Akses</a>";
                            } else {
                                echo "<span style='color:#aaa;'>Utama</span>";
                            }
                            echo "</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>


        <!-- ==================== VIEW: MANAJER ==================== -->
        <?php if ($role == 'manajer'): ?>
            <!-- Update Stok Kopi Botolan -->
            <div class="section-block">
                <h2>📦 Panel Kontrol Stok Kopi Botalan (Inventori Utama)</h2>
                <form method="POST" action="" style="margin-bottom: 25px; background: #fafafa; padding: 15px; border-radius: 6px;">
                    <h3 style="font-size:14px; margin-bottom:10px;">Aksi Cepat Tambah Stok Produk</h3>
                    <div style="display:flex; gap:15px; flex-wrap:wrap;">
                        <select name="prod_id" style="padding:8px; border-radius:4px; flex:1;" required>
                            <?php 
                            $result_produk->data_seek(0);
                            while($p = $result_produk->fetch_assoc()) {
                                echo "<option value='{$p['id']}'>{$p['nama_kopi']} (Sisa: {$p['stok']} btl)</option>";
                            }
                            ?>
                        </select>
                        <input type="number" name="tambahan_stok" placeholder="+ Jumlah Botol" style="padding:8px; width:120px; border-radius:4px;" required>
                        <button type="submit" name="update_stok_action" class="btn" style="padding:8px 15px;">Perbarui Stok</button>
                    </div>
                </form>
                
                <?php
                if(isset($_POST['update_stok_action'])) {
                    $pid = $_POST['prod_id'];
                    $t_stok = $_POST['tambahan_stok'];
                    $conn->query("UPDATE products SET stok = stok + $t_stok WHERE id = $pid");
                    echo "<script>alert('Stok logistik berhasil diperbarui!'); window.location='dashboard.php';</script>";
                }
                ?>

                <table>
                    <thead>
                        <tr>
                            <th>ID Varian</th>
                            <th>Nama Kopi Botol</th>
                            <th>Harga Jual</th>
                            <th>Sisa Stok Gudang</th>
                            <th>Status Logistik</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $result_produk->data_seek(0);
                        while($p = $result_produk->fetch_assoc()) {
                            $status_stok = ($p['stok'] > 15) ? "<span class='badge active'>Aman</span>" : "<span class='badge' style='background:#f8d7da; color:#721c24;'>Kritis</span>";
                            echo "<tr>
                                    <td>{$p['id']}</td>
                                    <td><strong>{$p['nama_kopi']}</strong></td>
                                    <td>Rp ".number_format($p['harga'],0,',','.')."</td>
                                    <td>{$p['stok']} Botol</td>
                                    <td>{$status_stok}</td>
                                  </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <!-- Set Venue / Lokasi Penjualan Harian -->
            <div class="section-block">
                <h2>📍 Pengaturan Distribusi Titik Jalan (Area Bandung Sekitarnya)</h2>
                <form method="POST" action="">
                    <div class="grid-3" style="grid-template-columns: 1fr 1fr 1fr; margin-bottom: 0;">
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
                            <input type="number" placeholder="Contoh: 100 Botol" required>
                        </div>
                    </div>
                    <button type="button" class="btn" onclick="alert('Lokasi jualan armada keliling berhasil disebarkan ke website publik!')">Broadcast Lokasi Hari Ini</button>
                </form>
            </div>
        <?php endif; ?>


        <!-- ==================== VIEW: CORLAB ==================== -->
        <?php if ($role == 'corlab'): ?>
            <!-- Data Kolaborasi & Event Kampanye -->
            <div class="section-block">
                <h2>🤝 Portal Manajemen Kolaborasi Brand & Aktivasi Kampanye</h2>
                <p style="font-size:14px; margin-bottom:20px; color:#666;">Pantau kesepakatan pemasaran bersama komunitas kreatif, brand clothing lokal Bandung, dan BEM/Himpunan Mahasiswa.</p>
                
                <table>
                    <thead>
                        <tr>
                            <th>Nama Project Kolaborasi</th>
                            <th>Mitra Kolaborator</th>
                            <th>Bentuk Aktivasi / Campaign</th>
                            <th>Tanggal Pelaksanaan</th>
                            <th>Status Perizinan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>Informatics Coffee Stand</strong></td>
                            <td>Himpunan Mahasiswa Informatika UHS</td>
                            <td>Suplai 200 botol free-sticker khusus event Expo Teknologi</td>
                            <td>12 Juli 2026</td>
                            <td><span class="badge active" style="background:#ccfbf1; color:#115e59;">Approved (Siap Kirim)</span></td>
                        </tr>
                        <tr>
                            <td><strong>Culture Blend: Threads & Beans</strong></td>
                            <td>Local Clothing Brand (Braga Area)</td>
                            <td>Bundling produk: Beli baju gratis Es Kopi Susu Aren Bekal</td>
                            <td>05 Agustus 2026</td>
                            <td><span class="badge" style="background:#fef3c7; color:#92400e;">Dalam Negosiasi</span></td>
                        </tr>
                        <tr>
                            <td><strong>Car Free Day Acoustic Session</strong></td>
                            <td>Komunitas Musik Jalanan Bandung</td>
                            <td>Mini showcase musik akustik di samping Motor Box Kopi Dago</td>
                            <td>Setiap Minggu Pagi</td>
                            <td><span class="badge active" style="background:#ccfbf1; color:#115e59;">Berjalan Rutin</span></td>
                        </tr>
                    </tbody>
                </table>
                <br>
                <button class="btn" onclick="alert('Formulir pengajuan proposal kolaborasi baru dibuka!')">+ Daftarkan Rencana Aliansi Strategis Baru</button>
            </div>
        <?php endif; ?>


        <!-- ==================== VIEW: PENGGUNA (CUSTOMER) ==================== -->
        <?php if ($role == 'pengguna'): ?>
            <!-- Peluang Member & Akumulasi Poin -->
            <div class="grid-3">
                <div class="card success" style="background: linear-gradient(135deg, #4A3022, #332015); color: white;">
                    <h3 style="color: #D4A373;">Kartu Member Digital</h3>
                    <div class="value" style="color: white;">ID: BEKAL-<?php echo 1000 + $user_id; ?></div>
                    <p style="font-size:12px; margin-top:10px; color:#d4a373;">Kategori: <strong>GOLD LOYALIST</strong></p>
                </div>
                <div class="card">
                    <h3>Poin Kopi Anda Saat Ini</h3>
                    <div class="value" style="color: var(--success);">180 Poin</div>
                    <p style="font-size:12px; color:#666; margin-top:5px;">Kumpulkan 20 poin lagi untuk Klaim 1 Botol Gratis!</p>
                </div>
            </div>

            <!-- Katalog Rincian Kopi Detail -->
            <div class="section-block">
                <h2>☕ Katalog Eksklusif Rincian Karakteristik Kopi</h2>
                <div class="catalog-grid">
                    <?php 
                    $result_produk->data_seek(0);
                    while($p = $result_produk->fetch_assoc()) {
                        echo "
                        <div class='catalog-item'>
                            <h4>{$p['nama_kopi']}</h4>
                            <span class='price'>Rp ".number_format($p['harga'],0,',','.')."</span>
                            <p>{$p['deskripsi']}</p>
                            <div style='text-align:left; font-size:11px; background:#faf7f0; padding:8px; border-radius:4px; margin-top:10px;'>
                                🟢 <strong>Notes:</strong> Creamy, Chocolatey, Low Acidity.<br>
                                📦 <strong>Kemasan:</strong> Botol PET Ramah Lingkungan 250ml.
                            </div>
                        </div>";
                    }
                    ?>
                </div>
            </div>

            <!-- Booking Slot Event bekalkopibdg -->
            <div class="section-block">
                <h2>📅 Form Pengajuan Booking Layanan Kopi Keliling (Event/Gathering)</h2>
                <form method="POST" action="" onsubmit="event.preventDefault(); alert('Permintaan booking berhasil diajukan! Tim admin kami akan menghubungi Anda via WhatsApp dalam 1x24 jam.');">
                    <div class="grid-3" style="grid-template-columns: 1fr 1fr; margin-bottom: 15px;">
                        <div class="form-group">
                            <label>Jenis Event / Acara</label>
                            <select required>
                                <option>Gathering Komunitas / Klub Motor</option>
                                <option>Seminar / Sidang Himpunan Kampus</option>
                                <option>Pesta Pernikahan / Syukuran Rumah</option>
                                <option>Lainnya</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Tanggal Rencana Pelaksanaan</label>
                            <input type="date" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Pilihan Paket Kuota Kopi Botol</label>
                        <select required>
                            <option>Paket Satuan Gembira (50 Botol Varian Campur + Free Pengantaran Lokasi Bandung)</option>
                            <option>Paket Serbu Kampus (100 Botol Varian Campur + Penempatan Motor Box di Lokasi)</option>
                            <option>Paket Enterprise Hub (Sistem Custom sesuai Kebutuhan Event)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Alamat Lengkap Detail Lokasi Drop Point / Penempatan</label>
                        <textarea rows="3" placeholder="Contoh: Jl. Dipatiukur No. X, Coblong, Kota Bandung (Halaman Parkir Gedung)" required></textarea>
                    </div>
                    <button type="submit" class="btn">Kirim Form Reservasi Booking</button>
                </form>
            </div>
        <?php endif; ?>

    </div>
</body>
</html>