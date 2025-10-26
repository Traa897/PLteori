<!-- views/auth/register.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - PIX+</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .register-container {
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 450px;
            border: 2px solid rgba(255,255,255,0.2);
            box-shadow: 0 15px 35px rgba(0,0,0,0.3);
        }

        .logo {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo h1 {
            font-size: 3em;
            color: white;
            text-shadow: 2px 2px 10px rgba(0,0,0,0.3);
            margin-bottom: 10px;
        }

        .logo p {
            color: rgba(255,255,255,0.9);
            font-size: 1.1em;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            color: white;
            font-weight: bold;
            margin-bottom: 8px;
            font-size: 1em;
        }

        input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid rgba(255,255,255,0.3);
            border-radius: 10px;
            background: rgba(255,255,255,0.2);
            color: white;
            font-size: 1em;
            transition: all 0.3s ease;
        }

        input::placeholder {
            color: rgba(255,255,255,0.6);
        }

        input:focus {
            outline: none;
            border-color: rgba(255,255,255,0.6);
            background: rgba(255,255,255,0.25);
        }

        .btn-register {
            width: 100%;
            padding: 15px;
            background: rgba(76, 175, 80, 0.3);
            color: white;
            border: 2px solid rgba(76, 175, 80, 0.6);
            border-radius: 10px;
            font-size: 1.1em;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
        }

        .btn-register:hover {
            background: rgba(76, 175, 80, 0.5);
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.3);
        }

        .login-link {
            text-align: center;
            margin-top: 20px;
            color: white;
        }

        .login-link a {
            color: #FFD700;
            text-decoration: none;
            font-weight: bold;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        .alert {
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 10px;
            text-align: center;
        }

        .alert-error {
            background: rgba(244, 67, 54, 0.3);
            border: 2px solid rgba(244, 67, 54, 0.5);
            color: white;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="logo">
            <h1>🎬 PIX+</h1>
            <p>Daftar Akun Baru</p>
        </div>

        <?php if(isset($_GET['error'])): ?>
            <div class="alert alert-error">
                <?php echo htmlspecialchars($_GET['error']); ?>
            </div>
        <?php endif; ?>

        <form action="register_process.php" method="POST">
            <div class="form-group">
                <label for="full_name">Nama Lengkap</label>
                <input type="text" id="full_name" name="full_name" required placeholder="Masukkan nama lengkap">
            </div>

            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required placeholder="Pilih username">
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required placeholder="email@example.com">
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required placeholder="Masukkan password">
            </div>

            <div class="form-group">
                <label for="confirm_password">Konfirmasi Password</label>
                <input type="password" id="confirm_password" name="confirm_password" required placeholder="Ulangi password">
            </div>

            <button type="submit" class="btn-register">📝 Daftar</button>
        </form>

        <div class="login-link">
            Sudah punya akun? <a href="login.php">Login Sekarang</a>
        </div>
    </div>
</body>
</html>