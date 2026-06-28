<?php
session_start();
require 'db.php';
if (!isset($_SESSION['user_id'])) header("Location: login.php");
$role = $_SESSION['role'];
?>
<!DOCTYPE html>
<html lang="id">
<head><title>Kelola Data</title>
<style>
    body{background:#0a0a0a; color:#fff; font-family:sans-serif; padding:20px;}
    table { width: 100%; border-collapse: collapse; margin-top: 15px; background: #111;}
    th, td { border: 1px solid #333; padding: 12px; text-align: left; }
    th { background: #d4af37; color: #000; }
    a { color:#d4af37; text-decoration:none; }
    .btn-delete { color: #ff4d4d; font-weight: bold; }
</style>
</head>
<body>
    <a href="dashboard.php">⬅ Kembali ke Dashboard</a> | <a href="input_data.php">➕ Tambah Data Baru</a>
    <hr style="border-color:#333; margin:20px 0;">

    <?php if($role == 'bos'): ?>
        <h3 style="color:#d4af37;">BOS: Kelola Arus Kas</h3>
        <table>
            <tr><th>ID</th><th>Tanggal</th><th>Keterangan</th><th>Pemasukan</th><th>Aksi</th></tr>
            <?php 
            $res = $conn->query("SELECT * FROM arus_kas ORDER BY id_kas DESC");
            while($row = $res->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id_kas'] ?></td><td><?= $row['tanggal'] ?></td><td><?= $row['keterangan'] ?></td>
                    <td>Rp <?= number_format($row['pemasukan'],0) ?></td>
                    <td><a href="delete_proses.php?table=arus_kas&id=<?= $row['id_kas'] ?>" class="btn-delete" onclick="return confirm('Hapus data kas ini?')">Hapus</a></td>
                </tr>
            <?php endwhile; ?>
        </table>

    <?php elseif($role == 'manajer'): ?>
        <h3 style="color:#d4af37;">MANAJER: Kelola Produk & Stok</h3>
        <table>
            <tr><th>ID</th><th>Nama Kopi</th><th>Harga</th><th>Sisa Stok</th><th>Aksi</th></tr>
            <?php 
            $res = $conn->query("SELECT * FROM products");
            while($row = $res->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td><td><?= $row['nama_kopi'] ?? $row['nama_produk'] ?></td>
                    <td>Rp <?= number_format($row['harga'],0) ?></td><td><?= $row['stok'] ?> Pcs</td>
                    <td><a href="delete_proses.php?table=products&id=<?= $row['id'] ?>" class="btn-delete" onclick="return confirm('Hapus produk ini?')">Hapus</a></td>
                </tr>
            <?php endwhile; ?>
        </table>

    <?php elseif($role == 'corlab'): ?>
        <h3 style="color:#d4af37;">CORLAB: Kelola Kampanye & Event</h3>
        <table>
            <tr><th>ID</th><th>Nama Event</th><th>Tanggal</th><th>Status</th><th>Aksi</th></tr>
            <?php 
            $res = $conn->query("SELECT * FROM kampanye");
            while($row = $res->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id_kampanye'] ?></td><td><?= $row['nama_event'] ?></td>
                    <td><?= $row['tanggal_event'] ?></td><td><?= $row['status'] ?></td>
                    <td><a href="delete_proses.php?table=kampanye&id=<?= $row['id_kampanye'] ?>" class="btn-delete" onclick="return confirm('Batalkan/Hapus event?')">Hapus</a></td>
                </tr>
            <?php endwhile; ?>
        </table>

    <?php elseif($role == 'pengguna'): ?>
        <h3 style="color:#d4af37;">CUSTOMER: Riwayat Booking Anda</h3>
        <table>
            <tr><th>ID</th><th>Layanan</th><th>Tanggal Request</th><th>Status</th><th>Aksi</th></tr>
            <?php 
            $res = $conn->query("SELECT * FROM bookings WHERE id_pengguna=".$_SESSION['user_id']);
            while($row = $res->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id_booking'] ?></td><td><?= $row['layanan'] ?></td>
                    <td><?= $row['tanggal_request'] ?></td><td><?= $row['status'] ?></td>
                    <td><a href="delete_proses.php?table=bookings&id=<?= $row['id_booking'] ?>" class="btn-delete" onclick="return confirm('Batalkan booking ini?')">Batalkan</a></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php endif; ?>
</body>
</html>