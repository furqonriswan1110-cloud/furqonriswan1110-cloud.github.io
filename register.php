<?php
require 'db.php';
session_start();

$successMsg = null;
$errorMsg = null;

// Tampilkan pesan sukses dari proses register (jika ada)
if (isset($_SESSION['register_success_msg'])) {
    $successMsg = $_SESSION['register_success_msg'];
    unset($_SESSION['register_success_msg']);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // Basic server-side validation
    if ($username === '' || $email === '' || $password === '') {
        $errorMsg = "Semua field wajib diisi.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorMsg = "Format email tidak valid.";
    } elseif (mb_strlen($username) < 3) {
        $errorMsg = "Username minimal 3 karakter.";
    } elseif (mb_strlen($password) < 6) {
        $errorMsg = "Password minimal 6 karakter.";
    } else {
        $role = 'pengguna';
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        // Check duplicates (username/email) for nicer UX
        $check = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ? LIMIT 1");
        $check->bind_param("ss", $username, $email);
        $check->execute();
        $checkRes = $check->get_result();

        if ($checkRes && $checkRes->num_rows > 0) {
            $errorMsg = "Username atau email sudah terdaftar.";
        } else {
            $stmt = $conn->prepare(
                "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)"
            );
            $stmt->bind_param("ssss", $username, $email, $passwordHash, $role);

            if ($stmt->execute()) {
                $_SESSION['register_success_msg'] = "Berhasil! Akun Anda sudah dibuat. Silakan login.";
                header("Location: login.php");
                exit();
            } else {
                $errorMsg = "Gagal mendaftar. Silakan coba lagi.";
            }

            $stmt->close();
        }

        $check->close();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar | bekalkopibdg</title>

    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">

    <style>
        :root {
            --gold: #D4AF37;
            --gold-2: #AA8022;
            --dark-bg: #0a0807;
            --card-bg: rgba(20, 15, 12, 0.85);
            --text-light: #fdfbf7;
            --text-muted: #a39587;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(rgba(10, 8, 7, 0.7), rgba(10, 8, 7, 0.95)),
                        url('https://images.unsplash.com/photo-1497935586351-b67a49e012bf?auto=format&fit=crop&w=1920&q=80') center/cover no-repeat;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            color: var(--text-light);
        }

        .wrap {
            width: 100%;
            max-width: 460px;
        }

        .card {
            background: var(--card-bg);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid rgba(212, 175, 55, 0.22);
            border-radius: 18px;
            padding: 46px 34px;
            box-shadow: 0 22px 55px rgba(0, 0, 0, 0.55), inset 0 0 0 1px rgba(255,255,255,0.05);
            position: relative;
            overflow: hidden;
        }

        .card:before {
            content: '';
            position: absolute;
            inset: -2px;
            background: radial-gradient(600px 200px at 20% 0%, rgba(212,175,55,0.18), transparent 60%),
                        radial-gradient(500px 160px at 90% 10%, rgba(170,128,34,0.14), transparent 55%);
            pointer-events: none;
        }

        .card > * { position: relative; }

        .brand {
            text-align: center;
            margin-bottom: 10px;
        }

        .brand .logo {
            font-family: 'Playfair Display', serif;
            font-size: 34px;
            color: var(--gold);
            letter-spacing: 2px;
            font-weight: 700;
        }

        .brand .sub {
            margin-top: 6px;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 3px;
            color: var(--text-muted);
        }

        h2 {
            text-align: center;
            margin-top: 26px;
            font-size: 18px;
            color: #f3e9c8;
            letter-spacing: 0.5px;
            font-weight: 600;
        }

        .banner {
            margin: 18px 0 22px;
            padding: 12px 14px;
            border-radius: 10px;
            font-size: 13px;
            line-height: 1.4;
        }

        .error {
            background: rgba(220, 53, 69, 0.12);
            border-left: 3px solid #dc3545;
            color: #ffccd2;
        }

        .success {
            background: rgba(42, 157, 143, 0.12);
            border-left: 3px solid var(--gold);
            color: #bff5ea;
        }

        form { margin-top: 16px; }

        .group { margin-bottom: 18px; }

        .group label {
            display: block;
            font-size: 12px;
            color: var(--text-muted);
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 1.2px;
        }

        .group input {
            width: 100%;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.12);
            padding: 14px 16px;
            border-radius: 10px;
            color: var(--text-light);
            font-size: 14px;
            outline: none;
            transition: 0.25s;
        }

        .group input:focus {
            border-color: var(--gold);
            background: rgba(212, 175, 55, 0.06);
            box-shadow: 0 0 18px rgba(212, 175, 55, 0.12);
        }

        .actions {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-top: 12px;
        }

        .btn {
            width: 100%;
            border: none;
            border-radius: 12px;
            padding: 14px 16px;
            font-size: 14px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            cursor: pointer;
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-2) 100%);
            color: #0a0807;
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 26px rgba(212, 175, 55, 0.25);
        }

        .link-row {
            text-align: center;
            font-size: 13px;
            color: var(--text-muted);
            margin-top: 16px;
        }

        .link-row a {
            color: var(--gold);
            text-decoration: none;
            font-weight: 600;
        }

        .link-row a:hover { text-shadow: 0 0 14px rgba(212,175,55,0.45); }

        .fineprint {
            text-align: center;
            margin-top: 14px;
            font-size: 11px;
            color: rgba(163,149,135,0.95);
        }
    </style>
</head>
<body>

    <div class="wrap">
        <div class="card">
            <div class="brand">
                <div class="logo">bekalkopibdg</div>
                <div class="sub">Executive Portal</div>
            </div>

            <h2>Daftar Akun Baru</h2>

            <?php if ($errorMsg): ?>
                <div class="banner error">⚠️ <?= htmlspecialchars($errorMsg) ?></div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="group">
                    <label for="username">Username</label>
                    <input id="username" type="text" name="username" placeholder="Contoh: bekalrian" required value="<?= isset($username) ? htmlspecialchars($username) : '' ?>" autocomplete="off">
                </div>

                <div class="group">
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" placeholder="Contoh: kamu@email.com" required value="<?= isset($email) ? htmlspecialchars($email) : '' ?>" autocomplete="off">
                </div>

                <div class="group">
                    <label for="password">Password</label>
                    <input id="password" type="password" name="password" placeholder="Minimal 6 karakter" required autocomplete="new-password">
                </div>

                <div class="actions">
                    <button class="btn" type="submit">Buat Akun</button>
                </div>

                <div class="link-row">
                    Sudah punya akun? <a href="login.php">Masuk di sini</a>
                </div>

                <div class="fineprint">Dengan mendaftar, Anda menyetujui kebijakan penggunaan sistem internal bekalkopibdg.</div>
            </form>
        </div>
    </div>

</body>
</html>

