<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$type = $_GET['type'] ?? 'item';
$redirect = 'edit_hapus.php';

$role = $_SESSION['role'] ?? '';
if ($type === 'user') {
    if ($role !== 'bos') {
        die("Akses Ditolak. Hanya Bos yang bisa menghapus akun pengguna.");
    }
    $redirect = 'dashboard.php';
} else {
    if (!in_array($role, ['bos', 'manajer'], true)) {
        die("Akses Ditolak. Hanya Bos/Manajer yang bisa menghapus modul.");
    }
}


if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    if ($type === 'user') {
        $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    } else {
        $stmt = $conn->prepare("DELETE FROM bekal_ekosistem WHERE id_item = ?");
    }

    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo "<script>alert('Data berhasil dihapus!'); window.location='$redirect';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
    $stmt->close();
}
?>
