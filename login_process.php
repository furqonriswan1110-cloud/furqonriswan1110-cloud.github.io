<?php
session_start();
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, username, password, role FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Memeriksa password (mendukung hash atau plain text dari dummy SQL)
        if (password_verify($password, $user['password']) || $password === $user['password']) {
            
            // Auto-Hashing: Jika login pakai plain text, otomatis ubah ke Hash di database
            if ($password === $user['password']) {
                $new_hash = password_hash($password, PASSWORD_DEFAULT);
                $update = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
                $update->bind_param("si", $new_hash, $user['id']);
                $update->execute();
            }

            // Set Sesi Pengguna
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            
            // Redirect ke Dashboard
            header("Location: dashboard.php");
            exit();
        } else {
            // Password Salah (Kirim pesan ke halaman login)
            $_SESSION['error_msg'] = "Kredensial sandi tidak valid. Silakan coba lagi.";
            header("Location: login.php");
            exit();
        }
    } else {
        // Username Tidak Ditemukan
        $_SESSION['error_msg'] = "Identitas pengguna tidak ditemukan dalam sistem.";
        header("Location: login.php");
        exit();
    }
    $stmt->close();
}
?>