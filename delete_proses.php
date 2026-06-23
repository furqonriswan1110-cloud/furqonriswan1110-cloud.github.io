<?php
session_start();
require 'db.php';

if (!isset($_SESSION['role']) || ($_SESSION['role'] != 'bos' && $_SESSION['role'] != 'manajer')) {
    die("Akses Ditolak. Hanya Bos/Manajer yang bisa menghapus data.");
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo "<script>alert('User berhasil dihapus!'); window.location='dashboard.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
    $stmt->close();
}
?>