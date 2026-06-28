<?php
session_start();
require 'db.php';
if (!isset($_SESSION['user_id'])) header("Location: login.php");
$role = $_SESSION['role'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['input_kas']) && $role === 'bos') {
        $ket = $_POST['keterangan'] ?? '';
        $jumlah = $_POST['jumlah'] ?? 0;
        $ket = $conn->real_escape_string($ket);
        $conn->query("INSERT INTO arus_kas (tanggal, keterangan, pemasukan) VALUES (CURDATE(), '$ket', '$jumlah')");
    }

    if (isset($_POST['input_stok']) && $role === 'manajer') {
        $nama = $_POST['nama_kopi'] ?? '';
        $stok = $_POST['stok'] ?? 0;
        $nama = $conn->real_escape_string($nama);
        $conn->query("INSERT INTO products (nama_kopi, stok) VALUES ('$nama', '$stok')");
    }

    if (isset($_POST['input_laporan']) && $role === 'karyawan') {
        $ket = $_POST['keterangan'] ?? '';
        $jumlah = $_POST['jumlah'] ?? 0;
        $idk = (int)$_SESSION['user_id'];
        $ket = $conn->real_escape_string($ket);
        $conn->query("INSERT INTO arus_kas (tanggal, keterangan, pemasukan, id_karyawan) VALUES (CURDATE(), '$ket', '$jumlah', '$idk')");
    }

    if (isset($_POST['input_booking']) && $role === 'pengguna') {
        $layanan = $_POST['layanan'] ?? '';
        $idp = (int)$_SESSION['user_id'];
        $layanan = $conn->real_escape_string($layanan);
        $conn->query("INSERT INTO bookings (id_pengguna, layanan, tanggal_request, status) VALUES ('$idp', '$layanan', CURDATE(), 'Pending')");
    }

    echo "<script>alert('Data berhasil diinput!'); window.location='edit_hapus.php';</script>";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Input Data | bekalkopibdg</title>
    <style>
        :root{
            --bg0:#070606;
            --bg1:#0f0c0a;
            --card:rgba(255,255,255,0.06);
            --card2:rgba(255,255,255,0.09);
            --line:rgba(212,175,55,0.25);
            --gold:#d4af37;
            --gold2:#b5952f;
            --text:#f6f1e6;
            --muted:rgba(246,241,230,0.72);
            --shadow: 0 20px 60px rgba(0,0,0,.55);
        }
        *{box-sizing:border-box;}
        body{
            margin:0;
            font-family: ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, "Apple Color Emoji","Segoe UI Emoji";
            background:
                radial-gradient(1000px 500px at 20% -10%, rgba(212,175,55,0.18), transparent 55%),
                radial-gradient(900px 450px at 90% 10%, rgba(181,149,47,0.14), transparent 55%),
                linear-gradient(180deg, var(--bg0), var(--bg1));
            color:var(--text);
            min-height:100vh;
            padding:28px 18px;
        }

        .shell{max-width:980px; margin:0 auto;}

        .topbar{
            display:flex; align-items:center; justify-content:space-between;
            gap:12px; margin-bottom:18px;
        }
        .brand{
            display:flex; align-items:center; gap:12px;
        }
        .logo{
            width:40px; height:40px; border-radius:14px;
            background: linear-gradient(135deg, rgba(212,175,55,.25), rgba(212,175,55,.06));
            border:1px solid rgba(212,175,55,.35);
            box-shadow: 0 0 0 4px rgba(212,175,55,.08);
        }
        .brand h1{
            font-size:16px; margin:0; letter-spacing:.6px; text-transform:uppercase;
            color:rgba(212,175,55,0.95);
        }
        .brand p{margin:0; font-size:12px; color:var(--muted);} 

        .nav{
            display:flex; gap:10px; flex-wrap:wrap; justify-content:flex-end;
        }
        .nav a{
            text-decoration:none;
            padding:10px 14px;
            border-radius:12px;
            border:1px solid rgba(212,175,55,.28);
            background: rgba(255,255,255,0.03);
            color: rgba(212,175,55,.95);
            font-weight:700;
            font-size:12px;
            letter-spacing:.3px;
            transition:.2s;
        }
        .nav a:hover{
            background: rgba(212,175,55,.14);
            border-color: rgba(212,175,55,.55);
            transform: translateY(-1px);
        }

        .hero{
            border:1px solid rgba(212,175,55,.25);
            border-radius:22px;
            background:
                linear-gradient(135deg, rgba(255,255,255,0.06), rgba(255,255,255,0.03)),
                radial-gradient(800px 300px at 20% 0%, rgba(212,175,55,0.20), transparent 60%);
            box-shadow: var(--shadow);
            padding:22px;
            margin-bottom:18px;
        }
        .hero .title{
            display:flex; align-items:flex-start; justify-content:space-between; gap:16px;
        }
        .hero h2{
            margin:0; font-size:18px; letter-spacing:.4px;
        }
        .hero .sub{margin-top:8px; color:var(--muted); font-size:13px; line-height:1.5;}
        .role-pill{
            border:1px solid rgba(212,175,55,.35);
            padding:8px 12px;
            border-radius:999px;
            font-size:12px;
            font-weight:800;
            color: rgba(212,175,55,.98);
            background: rgba(212,175,55,0.08);
            white-space:nowrap;
        }

        .grid{
            display:grid;
            grid-template-columns: 1fr;
            gap:16px;
        }

        .card{
            border-radius:18px;
            border:1px solid rgba(255,255,255,0.08);
            background: rgba(255,255,255,0.04);
            padding:18px;
        }

        .card h3{
            margin:0 0 14px 0;
            color: rgba(212,175,55,0.95);
            font-size:14px;
            letter-spacing:.4px;
            text-transform:uppercase;
        }

        .form{
            display:grid;
            grid-template-columns: 1fr;
            gap:12px;
        }

        label{display:block; font-size:12px; color:var(--muted); font-weight:800; margin-bottom:6px; letter-spacing:.2px;}

        input, select, textarea, button{
            width:100%;
            padding:12px 14px;
            border-radius:14px;
            border:1px solid rgba(255,255,255,0.12);
            background: rgba(0,0,0,0.18);
            color:var(--text);
            outline:none;
        }
        input:focus, select:focus, textarea:focus{
            border-color: rgba(212,175,55,0.6);
            box-shadow: 0 0 0 4px rgba(212,175,55,0.14);
        }

        .row2{
            display:grid;
            grid-template-columns: 1fr 1fr;
            gap:12px;
        }

        .btn{
            cursor:pointer;
            background: linear-gradient(135deg, var(--gold), var(--gold2));
            border:1px solid rgba(0,0,0,0.2);
            font-weight:900;
            color:#101010;
            letter-spacing:.4px;
            text-transform:uppercase;
            transition:.2s;
            box-shadow: 0 18px 40px rgba(212,175,55,.15);
        }
        .btn:hover{transform: translateY(-2px); filter: brightness(1.05);} 
        .btn:active{transform: translateY(0px);} 

        .hint{
            margin-top:10px;
            color:rgba(246,241,230,0.68);
            font-size:12px;
            line-height:1.5;
        }

        .divider{
            height:1px;
            width:100%;
            background: linear-gradient(90deg, transparent, rgba(212,175,55,.45), transparent);
            margin:14px 0;
        }

        @media (min-width: 760px){
            .grid{grid-template-columns: 1.05fr 0.95fr; align-items:start;}
        }

        .side{
            color:var(--muted);
            font-size:13px;
            line-height:1.55;
        }
        .side ul{margin:10px 0 0 18px; padding:0;}
        .side li{margin:8px 0;}
        .kbd{
            display:inline-block;
            padding:2px 8px;
            border-radius:999px;
            background: rgba(212,175,55,.10);
            border:1px solid rgba(212,175,55,.25);
            color: rgba(212,175,55,.95);
            font-weight:900;
            font-size:12px;
        }
    </style>
</head>
<body>
<div class="shell">

    <div class="topbar">
        <div class="brand">
            <div class="logo" aria-hidden="true"></div>
            <div>
                <h1>bekalkopibdg</h1>
                <p>Input Data Operasional</p>
            </div>
        </div>
        <div class="nav">
            <a href="dashboard.php">← Dashboard</a>
            <a href="index.php">Ke Index</a>
        </div>
    </div>

    <div class="hero">
        <div class="title">
            <div>
                <h2>Form Input Data</h2>
                <div class="sub">Isi form sesuai akses role Anda. Semua data akan tersimpan ke database lalu diarahkan ke <span class="kbd">Edit & Hapus</span>.</div>
            </div>
            <div class="role-pill">ROLE: <?= htmlspecialchars((string)$role) ?></div>
        </div>
    </div>

    <div class="grid">
        <div class="card">
            <h3>Form Utama</h3>
            <form class="form" method="POST">
                <?php if($role === 'bos'): ?>
                    <div>
                        <label>Keterangan Pemasukan</label>
                        <input type="text" name="keterangan" placeholder="Contoh: Penjualan Keliling Bandung - 80 botol" required />
                    </div>
                    <div>
                        <label>Jumlah (Rp)</label>
                        <input type="number" name="jumlah" placeholder="Contoh: 1200000" required />
                    </div>
                    <button class="btn" type="submit" name="input_kas">Simpan Arus Kas</button>
                <?php elseif($role === 'manajer'): ?>
                    <div>
                        <label>Nama Produk Kopi</label>
                        <input type="text" name="nama_kopi" placeholder="Contoh: Aren Premium" required />
                    </div>
                    <div>
                        <label>Stok Botol</label>
                        <input type="number" name="stok" placeholder="Contoh: 250" required />
                    </div>
                    <button class="btn" type="submit" name="input_stok">Tambah / Set Stok Produk</button>
                <?php elseif($role === 'karyawan'): ?>
                    <div>
                        <label>Lokasi & Keterangan Jual</label>
                        <input type="text" name="keterangan" placeholder="Contoh: Dipatiukur - sore hari" required />
                    </div>
                    <div>
                        <label>Total Uang Masuk (Rp)</label>
                        <input type="number" name="jumlah" placeholder="Contoh: 750000" required />
                    </div>
                    <button class="btn" type="submit" name="input_laporan">Kirim Laporan Penjualan</button>
                <?php elseif($role === 'pengguna'): ?>
                    <div>
                        <label>Pilih Layanan</label>
                        <select name="layanan" required>
                            <option value="Corporate Coffee Break">Corporate Coffee Break</option>
                            <option value="Private Barista">Private Barista</option>
                        </select>
                    </div>
                    <button class="btn" type="submit" name="input_booking">Ajukan Booking</button>
                <?php else: ?>
                    <div class="hint">Tidak ada form untuk role ini.</div>
                <?php endif; ?>
            </form>
            <div class="divider"></div>
            <div class="hint">
                Tips: gunakan keterangan yang spesifik agar laporan tim operasional lebih mudah ditelusuri.
            </div>
        </div>

        <?php if($role !== 'pengguna'): ?>
        <div class="card side">
            <h3>Petunjuk Cepat</h3>
            <ul>
                <li><span class="kbd">Bos</span> : input <b>arus kas masuk</b>.</li>
                <li><span class="kbd">Manajer</span> : input/kelola <b>stok produk</b> (tabel <b>products</b>).</li>
                <li><span class="kbd">Karyawan</span> : kirim <b>laporan penjualan lapangan</b>.</li>
                <li><span class="kbd">Pengguna</span> : ajukan <b>booking layanan</b>.</li>
            </ul>
            <div class="divider"></div>
            <div>
                Setelah submit, Anda akan diarahkan ke halaman <b>Edit & Hapus</b> untuk koreksi data.
            </div>
        </div>
        <?php endif; ?>
    </div>

</div>
</body>
</html>

