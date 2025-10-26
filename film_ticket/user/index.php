<?php
// user/index.php
session_start();

// Check if user is logged in
if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: ../login.php");
    exit();
}

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Film.php';

$database = new Database();
$db = $database->connect();
$film = new Film($db);

$result = $film->read();
$films = $result->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PIX+ - Daftar Film</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(180deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            min-height: 100vh;
        }

        .navbar {
            background: rgba(0,0,0,0.3);
            backdrop-filter: blur(10px);
            padding: 15px 0;
            border-bottom: 2px solid rgba(255,255,255,0.2);
        }

        .navbar-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 1.8em;
            color: white;
            font-weight: bold;
        }

        .nav-links {
            display: flex;
            gap: 20px;
            align-items: center;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            padding: 8px 20px;
            border-radius: 10px;
            transition: all 0.3s ease;
            background: rgba(255,255,255,0.1);
        }

        .nav-links a:hover {
            background: rgba(255,255,255,0.2);
        }

        .user-info {
            color: white;
            font-weight: bold;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        header {
            text-align: center;
            padding: 40px 20px;
            color: white;
        }

        h1 {
            font-size: 3em;
            margin-bottom: 10px;
            text-shadow: 2px 2px 10px rgba(0,0,0,0.3);
        }

        .films-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 30px;
            margin-top: 40px;
        }

        .film-card {
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.3s ease;
            border: 2px solid rgba(255,255,255,0.2);
        }

        .film-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.4);
        }

        .film-poster {
            width: 100%;
            height: 400px;
            object-fit: cover;
        }

        .film-content {
            padding: 20px;
            color: white;
        }

        .film-title {
            font-size: 1.5em;
            margin-bottom: 10px;
            font-weight: bold;
        }

        .film-info {
            font-size: 0.9em;
            margin: 5px 0;
            opacity: 0.9;
        }

        .film-status {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.85em;
            margin-top: 10px;
            font-weight: bold;
        }

        .status-now_showing {
            background: rgba(76, 175, 80, 0.3);
            border: 1px solid rgba(76, 175, 80, 0.6);
        }

        .status-coming_soon {
            background: rgba(255, 193, 7, 0.3);
            border: 1px solid rgba(255, 193, 7, 0.6);
        }

        .status-ended {
            background: rgba(158, 158, 158, 0.3);
            border: 1px solid rgba(158, 158, 158, 0.6);
        }

        .price {
            font-size: 1.3em;
            font-weight: bold;
            color: #FFD700;
            margin: 10px 0;
        }

        .btn-book {
            width: 100%;
            padding: 12px;
            background: rgba(33, 150, 243, 0.3);
            color: white;
            border: 2px solid rgba(33, 150, 243, 0.6);
            border-radius: 10px;
            font-size: 1em;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: block;
            text-align: center;
            margin-top: 15px;
        }

        .btn-book:hover {
            background: rgba(33, 150, 243, 0.5);
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {
            h1 {
                font-size: 2em;
            }
            .films-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="navbar-content">
            <div class="logo">🎬 PIX+</div>
            <div class="nav-links">
                <span class="user-info">Halo, <?php echo htmlspecialchars($_SESSION['full_name']); ?>!</span>
                <a href="bookings.php">📋 Pesanan Saya</a>
                <a href="../logout.php">🚪 Logout</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <header>
            <h1>Film Yang Tersedia</h1>
            <p class="subtitle">Pilih film favorit dan pesan tiket sekarang!</p>
        </header>

        <div class="films-grid">
            <?php foreach($films as $film): ?>
                <div class="film-card">
                    <img src="<?php echo htmlspecialchars($film['poster_url']); ?>" 
                         alt="<?php echo htmlspecialchars($film['title']); ?>" 
                         class="film-poster">
                    <div class="film-content">
                        <div class="film-title"><?php echo htmlspecialchars($film['title']); ?></div>
                        <div class="film-info">🎭 <?php echo htmlspecialchars($film['genre']); ?></div>
                        <div class="film-info">⏱️ <?php echo htmlspecialchars($film['duration']); ?> menit</div>
                        <div class="film-info">🎬 <?php echo htmlspecialchars($film['director']); ?></div>
                        <div class="price">Rp <?php echo number_format($film['price'], 0, ',', '.'); ?></div>
                        <span class="film-status status-<?php echo $film['status']; ?>">
                            <?php 
                                $status_text = [
                                    'coming_soon' => 'Segera Tayang',
                                    'now_showing' => 'Sedang Tayang',
                                    'ended' => 'Sudah Berakhir'
                                ];
                                echo $status_text[$film['status']];
                            ?>
                        </span>
                        <?php if($film['status'] === 'now_showing'): ?>
                            <a href="book.php?id=<?php echo $film['id']; ?>" class="btn-book">🎟️ Pesan Tiket</a>
                        <?php else: ?>
                            <button class="btn-book" style="opacity: 0.5; cursor: not-allowed;" disabled>
                                <?php echo $film['status'] === 'coming_soon' ? 'Belum Tersedia' : 'Tidak Tersedia'; ?>
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>