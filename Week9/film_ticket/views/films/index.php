<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Film Ticket System - Daftar Film</title>
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
            transition: background 0.3s ease;
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

        .subtitle {
            font-size: 1.2em;
            opacity: 0.9;
        }

        .actions {
            text-align: center;
            margin: 30px 0;
        }

        .btn {
            display: inline-block;
            padding: 15px 30px;
            background: rgba(255,255,255,0.2);
            color: white;
            text-decoration: none;
            border-radius: 30px;
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255,255,255,0.3);
            font-size: 1.1em;
            transition: all 0.3s ease;
        }

        .btn:hover {
            background: rgba(255,255,255,0.3);
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
            background: rgba(76, 175, 80, 0.3);
            border: 2px solid rgba(76, 175, 80, 0.5);
            color: white;
        }

        .alert-error {
            background: rgba(244, 67, 54, 0.3);
            border: 2px solid rgba(244, 67, 54, 0.5);
            color: white;
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
            border-color: rgba(255,255,255,0.4);
        }

        .film-poster {
            width: 100%;
            height: 400px;
            object-fit: cover;
            background: rgba(255,255,255,0.1);
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
            background: rgba(255, 193, 7, 0.3);
            border: 1px solid rgba(255, 193, 7, 0.6);
        }

        .status-now_showing {
            background: rgba(76, 175, 80, 0.3);
            border: 1px solid rgba(76, 175, 80, 0.6);
        }

        .status-ended {
            background: rgba(158, 158, 158, 0.3);
            border: 1px solid rgba(158, 158, 158, 0.6);
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

        .btn-view {
            background: rgba(33, 150, 243, 0.3);
            color: white;
            border: 1px solid rgba(33, 150, 243, 0.6);
        }

        .btn-edit {
            background: rgba(255, 152, 0, 0.3);
            color: white;
            border: 1px solid rgba(255, 152, 0, 0.6);
        }

        .btn-delete {
            background: rgba(244, 67, 54, 0.3);
            color: white;
            border: 1px solid rgba(244, 67, 54, 0.6);
        }

        .btn-view:hover, .btn-edit:hover, .btn-delete:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }

        .price {
            font-size: 1.3em;
            font-weight: bold;
            color: #FFD700;
            margin-top: 10px;
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
    <div class="container">
        <header>
            <h1>PIX+</h1>
            <p class="subtitle">Pesan Tiket Film Favorit Anda</p>
        </header>

        <div class="actions">
            <a href="create.php" class="btn">+ Tambah Film Baru</a>
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
                        <div class="film-actions">
                            <a href="show.php?id=<?php echo $film['id']; ?>" class="btn-view">Lihat</a>
                            <a href="edit.php?id=<?php echo $film['id']; ?>" class="btn-edit">Edit</a>
                            <button onclick="deleteFilm(<?php echo $film['id']; ?>)" class="btn-delete">Hapus</button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script>
        // Efek gradient yang berubah saat scroll seperti ColorSpace
        let scrollPosition = 0;
        
        window.addEventListener('scroll', () => {
            scrollPosition = window.scrollY;
            const maxScroll = document.documentElement.scrollHeight - window.innerHeight;
            const scrollPercentage = scrollPosition / maxScroll;
            
            // Transisi warna dari ungu ke pink ke biru
            const colors = [
                { r: 102, g: 126, b: 234 },  // #667eea
                { r: 118, g: 75, b: 162 },   // #764ba2
                { r: 240, g: 147, b: 251 },  // #f093fb
                { r: 251, g: 147, b: 196 },  // pink
                { r: 168, g: 85, b: 247 }    // purple-blue
            ];
            
            const colorIndex = scrollPercentage * (colors.length - 1);
            const colorStart = colors[Math.floor(colorIndex)];
            const colorEnd = colors[Math.ceil(colorIndex)];
            const colorBlend = colorIndex % 1;
            
            const r = Math.round(colorStart.r + (colorEnd.r - colorStart.r) * colorBlend);
            const g = Math.round(colorStart.g + (colorEnd.g - colorStart.g) * colorBlend);
            const b = Math.round(colorStart.b + (colorEnd.b - colorStart.b) * colorBlend);
            
            const nextIndex = Math.min(Math.ceil(colorIndex) + 1, colors.length - 1);
            const nextColor = colors[nextIndex];
            
            document.body.style.background = `linear-gradient(180deg, 
                rgb(${r}, ${g}, ${b}) 0%, 
                rgb(${colorEnd.r}, ${colorEnd.g}, ${colorEnd.b}) 50%, 
                rgb(${nextColor.r}, ${nextColor.g}, ${nextColor.b}) 100%)`;
        });

        function deleteFilm(id) {
            if(confirm('Apakah Anda yakin ingin menghapus film ini?')) {
                window.location.href = 'delete.php?id=' + id;
            }
        }
    </script>
</body>
</html>