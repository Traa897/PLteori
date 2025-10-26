<?php
// admin/index.php
session_start();

// Check if admin is logged in
if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
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
    <title>Admin Dashboard - PIX+</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(180deg, #2c3e50 0%, #34495e 50%, #2c3e50 100%);
            min-height: 100vh;
        }

        .navbar {
            background: rgba(0,0,0,0.5);
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

        .admin-badge {
            background: rgba(231, 76, 60, 0.5);
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.8em;
            margin-left: 10px;
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

        .actions {
            text-align: center;
            margin: 30px 0;
        }

        .btn-add {
            display: inline-block;
            padding: 15px 30px;
            background: rgba(46, 204, 113, 0.3);
            color: white;
            text-decoration: none;
            border-radius: 30px;
            backdrop-filter: blur(10px);
            border: 2px solid rgba(46, 204, 113, 0.5);
            font-size: 1.1em;
            transition: all 0.3s ease;
            font-weight: bold;
        }

        .btn-add:hover {
            background: rgba(46, 204, 113, 0.5);
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.3);
        }

        .alert {
            padding: 15px;
            margin: 20px 0;
            border-radius: 10px;
            text-align: center;
            backdrop-filter: blur(10px);
        }

        .alert-success {
            background: rgba(46, 204, 113, 0.3);
            border: 2px solid rgba(46, 204, 113, 0.5);
            color: white;
        }

        .alert-error {
            background: rgba(231, 76, 60, 0.3);
            border: 2px solid rgba(231, 76, 60, 0.5);
            color: white;
        }

        .films-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 30px;
            margin-top: 40px;
        }

        .film-card {
            background: rgba(255,255,255,0.1);
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

        .status-coming_soon {
            background: rgba(241, 196, 15, 0.3);
            border: 1px solid rgba(241, 196, 15, 0.6);
        }

        .status-now_showing {
            background: rgba(46, 204, 113, 0.3);
            border: 1px solid rgba(46, 204, 113, 0.6);
        }

        .status-ended {
            background: rgba(149, 165, 166, 0.3);
            border: 1px solid rgba(149, 165, 166, 0.6);
        }

        .price {
            font-size: 1.3em;
            font-weight: bold;
            color: #FFD700;
            margin: 10px 0;
        }

        .film-actions {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }

        .film-actions a, .film-actions button {
            flex: 1;
            padding: 10px;
            text-align: center;
            text-decoration: none;
            border-radius: 10px;
            font-size: 0.9em;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            font-weight: bold;
        }

        .btn-edit {
            background: rgba(230, 126, 34, 0.3);
            color: white;
            border: 1px solid rgba(230, 126, 34, 0.6);
        }

        .btn-delete {
            background: rgba(231, 76, 60, 0.3);
            color: white;
            border: 1px solid rgba(231, 76, 60, 0.6);
        }

        .btn-edit:hover, .btn-delete:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
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
            <div class="logo">
                🎬 PIX+ <span class="admin-badge">👑 ADMIN</span>
            </div>
            <div class="nav-links">
                <a href="bookings.php">📋 Kelola Pesanan</a>
                <a href="../logout.php">🚪 Logout</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <header>
            <h1>Kelola Film</h1>
            <p class="subtitle">Dashboard Administrator</p>
        </header>

        <div class="actions">
            <a href="create.php" class="btn-add">➕ Tambah Film Baru</a>
        </div>

        <?php if(isset($_GET['message'])): ?>
            <div class="alert alert-success">
                <?php echo htmlspecialchars($_GET['message']); ?>
            </div>
        <?php endif; ?>

        <?php if(isset($_GET['error'])): ?>
            <div class="alert alert-error">
                <?php echo htmlspecialchars($_GET['error']); ?>
            </div>
        <?php endif; ?>

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
                        <div class="film-info">📅 <?php echo date('d M Y', strtotime($film['release_date'])); ?></div>
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
                        <div class="film-actions">
                            <a href="edit.php?id=<?php echo $film['id']; ?>" class="btn-edit">✏️ Edit</a>
                            <button onclick="deleteFilm(<?php echo $film['id']; ?>)" class="btn-delete">🗑️ Hapus</button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script>
        function deleteFilm(id) {
            if(confirm('Apakah Anda yakin ingin menghapus film ini?')) {
                window.location.href = 'delete.php?id=' + id;
            }
        }
    </script>
</body>
</html>