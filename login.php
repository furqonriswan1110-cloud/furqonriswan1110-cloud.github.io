<?php session_start(); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Eksekutif | bekalkopibdg</title>
    <!-- Menggunakan Font Mewah dari Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        :root {
            --gold: #D4AF37;
            --dark-bg: #0a0807;
            --card-bg: rgba(20, 15, 12, 0.85);
            --text-light: #fdfbf7;
            --text-muted: #a39587;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(rgba(10, 8, 7, 0.7), rgba(10, 8, 7, 0.9)), 
                        url('https://images.unsplash.com/photo-1497935586351-b67a49e012bf?auto=format&fit=crop&w=1920&q=80') center/cover no-repeat;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-light);
        }

        .login-wrapper {
            width: 100%;
            max-width: 420px;
            padding: 20px;
        }

        .login-card {
            background: var(--card-bg);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid rgba(212, 175, 55, 0.2);
            border-radius: 16px;
            padding: 50px 40px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5), inset 0 0 0 1px rgba(255,255,255,0.05);
            text-align: center;
        }

        .brand-logo {
            font-family: 'Playfair Display', serif;
            font-size: 32px;
            color: var(--gold);
            margin-bottom: 5px;
            letter-spacing: 2px;
        }

        .brand-subtitle {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 3px;
            color: var(--text-muted);
            margin-bottom: 40px;
        }

        /* Pesan Error Elegan */
        .error-box {
            background: rgba(220, 53, 69, 0.1);
            border-left: 3px solid #dc3545;
            color: #ffb3b8;
            padding: 12px;
            border-radius: 4px;
            font-size: 13px;
            margin-bottom: 25px;
            text-align: left;
        }

        .form-group {
            margin-bottom: 25px;
            text-align: left;
            position: relative;
        }

        .form-group label {
            display: block;
            font-size: 12px;
            color: var(--text-muted);
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .form-group input {
            width: 100%;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 14px 16px;
            border-radius: 8px;
            color: var(--text-light);
            font-size: 14px;
            transition: all 0.3s ease;
            outline: none;
        }

        .form-group input:focus {
            border-color: var(--gold);
            background: rgba(212, 175, 55, 0.05);
            box-shadow: 0 0 15px rgba(212, 175, 55, 0.1);
        }

        .btn-login {
            width: 100%;
            background: linear-gradient(135deg, #D4AF37 0%, #AA8022 100%);
            color: #0a0807;
            border: none;
            padding: 15px;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 2px;
            cursor: pointer;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin-top: 10px;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(212, 175, 55, 0.3);
        }

        .footer-link {
            margin-top: 30px;
            font-size: 13px;
            color: var(--text-muted);
        }

        .footer-link a {
            color: var(--gold);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
        }

        .footer-link a:hover {
            color: #fff;
            text-shadow: 0 0 8px rgba(212, 175, 55, 0.5);
        }
    </style>
</head>
<body>

    <div class="login-wrapper">
        <div class="login-card">
            <div class="brand-logo">bekalkopibdg</div>
            <div class="brand-subtitle">Executive Portal</div>

            <!-- Menampilkan Pesan Error Jika Ada (Dioper dari login_process.php) -->
            <?php if (isset($_SESSION['error_msg'])): ?>
                <div class="error-box">
                    ⚠️ <?php echo $_SESSION['error_msg']; ?>
                </div>
                <?php unset($_SESSION['error_msg']); // Hapus pesan setelah ditampilkan ?>
            <?php endif; ?>

            <form method="POST" action="login_process.php">
                <div class="form-group">
                    <label for="username">Username ID</label>
                    <input type="text" id="username" name="username" placeholder="Masukkan identitas pengguna..." required autocomplete="off">
                </div>
                
                <div class="form-group">
                    <label for="password">Security Key</label>
                    <input type="password" id="password" name="password" placeholder="Masukkan kata sandi..." required>
                </div>

                <button type="submit" class="btn-login">Akses Sistem</button>
            </form>

            <div class="footer-link">
                Belum memiliki akses? <a href="register.php">Ajukan Kemitraan</a>
            </div>
        </div>
    </div>

</body>
</html>