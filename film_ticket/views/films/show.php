<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($film['title']); ?> - Detail Film</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
        }

        .back-btn {
            display: inline-block;
            padding: 12px 25px;
            background: rgba(255,255,255,0.2);
            color: white;
            text-decoration: none;
            border-radius: 10px;
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255,255,255,0.3);
            margin-bottom: 30px;
            transition: all 0.3s ease;
        }

        .back-btn:hover {
            background: rgba(255,255,255,0.3);
            transform: translateX(-5px);
        }

        .film-detail {
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            overflow: hidden;
            border: 2px solid rgba(255,255,255,0.2);
        }

        .film-header {
            display: grid;
            grid-template-columns: 350px 1fr;
            gap: 30px;
            padding: 40px;
        }

        .film-poster {
            width: 100%;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }

        .film-info {
            color: white;
        }

        .film-title {
            font-size: 2.5em;
            margin-bottom: 15px;
            font-weight: bold;
        }

        .film-status {
            display: inline-block;
            padding: 8px 20px;
            border-radius: 20px;
            font-size: 0.9em;
            margin-bottom: 20px;
            font-weight: bold;
        }

        .status-coming_soon {
            background: rgba(255, 193, 7, 0.3);
            border: 2px solid rgba(255, 193, 7, 0.6);
        }

        .status-now_showing {
            background: rgba(76, 175, 80, 0.3);
            border: 2px solid rgba(76, 175, 80, 0.6);
        }

        .status-ended {
            background: rgba(158, 158, 158, 0.3);
            border: 2px solid rgba(158, 158, 158, 0.6);
        }

        .info-item {
            margin: 15px 0;
            font-size: 1.1em;
        }

        .info-label {
            font-weight: bold;
            opacity: 0.8;
            margin-right: 10px;
        }

        .price-tag {
            font-size: 2em;
            color: #FFD700;
            font-weight: bold;
            margin: 20px 0;
        }

        .film-description {
            padding: 40px;
            color: white;
            border-top: 2px solid rgba(255,255,255,0.2);
        }

        .description-title {
            font-size: 1.5em;
            margin-bottom: 15px;
            font-weight: bold;
        }

        .description-text {
            line-height: 1.8;
            font-size: 1.1em;
            opacity: 0.9;
        }

        .action-buttons {
            padding: 40px;
            display: flex;
            gap: 15px;
            border-top: 2px solid rgba(255,255,255,0.2);
        }

        .btn {
            flex: 1;
            padding: 15px;
            text-align: center;
            text-decoration: none;
            border-radius: 10px;
            font-size: 1.1em;
            font-weight: bold;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .btn-edit {
            background: rgba(255, 152, 0, 0.3);
            color: white;
            border: 2px solid rgba(255, 152, 0, 0.6);
        }

        .btn-delete {
            background: rgba(244, 67, 54, 0.3);
            color: white;
            border: 2px solid rgba(244, 67, 54, 0.6);
        }

        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.3);
        }

        @media (max-width: 768px) {
            .film-header {
                grid-template-columns: 1fr;
            }
            
            .film-title {
                font-size: 2em;
            }
            
            .action-buttons {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="index.php" class="back-btn">← Kembali ke Daftar</a>

        <div class="film-detail">
            <div class="film-header">
                <div>
                    <img src="<?php echo htmlspecialchars($film['poster_url']); ?>" 
                         alt="<?php echo htmlspecialchars($film['title']); ?>" 
                         class="film-poster">
                </div>
                
                <div class="film-info">
                    <h1 class="film-title"><?php echo htmlspecialchars($film['title']); ?></h1>
                    
                    <span class="film-status status-<?php echo $film['status']; ?>">
                        <?php 
                            $status_text = [
                                'coming_soon' => '🎬 Segera Tayang',
                                'now_showing' => '🎥 Sedang Tayang',
                                'ended' => '📼 Sudah Berakhir'
                            ];
                            echo $status_text[$film['status']];
                        ?>
                    </span>

                    <div class="info-item">
                        <span class="info-label">🎭 Genre:</span>
                        <?php echo htmlspecialchars($film['genre']); ?>
                    </div>

                    <div class="info-item">
                        <span class="info-label">⏱️ Durasi:</span>
                        <?php echo htmlspecialchars($film['duration']); ?> menit
                    </div>

                    <div class="info-item">
                        <span class="info-label">📅 Tanggal Rilis:</span>
                        <?php echo date('d F Y', strtotime($film['release_date'])); ?>
                    </div>

                    <div class="info-item">
                        <span class="info-label">🎬 Sutradara:</span>
                        <?php echo htmlspecialchars($film['director']); ?>
                    </div>

                    <div class="price-tag">
                        💰 Rp <?php echo number_format($film['price'], 0, ',', '.'); ?>
                    </div>
                </div>
            </div>

            <?php if(!empty($film['description'])): ?>
            <div class="film-description">
                <h2 class="description-title">📖 Sinopsis</h2>
                <p class="description-text"><?php echo nl2br(htmlspecialchars($film['description'])); ?></p>
            </div>
            <?php endif; ?>

            <div class="action-buttons">
                <a href="edit.php?id=<?php echo $film['id']; ?>" class="btn btn-edit">✏️ Edit Film</a>
                <button onclick="deleteFilm(<?php echo $film['id']; ?>)" class="btn btn-delete">🗑️ Hapus Film</button>
            </div>
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