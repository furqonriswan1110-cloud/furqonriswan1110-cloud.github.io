<?php
require 'db.php';
if (isset($_POST['submit_booking'])) {
    $nama = $conn->real_escape_string($_POST['nama_klien']);
    $tipe = $conn->real_escape_string($_POST['tipe_layanan']);
    $detail = $conn->real_escape_string($_POST['rincian_pesanan']);
    
    $conn->query("INSERT INTO bookings (nama, tipe, detail, status) VALUES ('$nama', '$tipe', '$detail', 'Pending')");
    
    echo "<script>alert('Reservasi berhasil dikirim!'); window.location='index.php';</script>";
}
?>