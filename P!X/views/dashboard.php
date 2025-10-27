<?php require_once 'views/layouts/header.php'; ?>

<div class="container">
    <div class="header-section">
        <h1>Dashboard P!X</h1>
    </div>

    <div class="stats-grid">
        <?php
        // Hitung total film
        $totalMovies = $this->db->query("SELECT COUNT(*) as total FROM movies")->fetch(PDO::FETCH_ASSOC);
        
        // Hitung berdasarkan status
        $akanTayang = $this->db->query("SELECT COUNT(*) as total FROM movies WHERE status='akan_tayang'")->fetch(PDO::FETCH_ASSOC);
        $sedangTayang = $this->db->query("SELECT COUNT(*) as total FROM movies WHERE status='sedang_tayang'")->fetch(PDO::FETCH_ASSOC);
        $telahTayang = $this->db->query("SELECT COUNT(*) as total FROM movies WHERE status='telah_tayang'")->fetch(PDO::FETCH_ASSOC);
        
        // Rating rata-rata
        $avgRating = $this->db->query("SELECT AVG(rating) as avg FROM movies")->fetch(PDO::FETCH_ASSOC);
        ?>

        <div class="stat-card">
            <div class="stat-icon">🎬</div>
            <div class="stat-info">
                <h3><?php echo $totalMovies['total']; ?></h3>
                <p>Total Film</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">📅</div>
            <div class="stat-info">
                <h3><?php echo $akanTayang['total']; ?></h3>
                <p>Akan Tayang</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">🎥</div>
            <div class="stat-info">
                <h3><?php echo $sedangTayang['total']; ?></h3>
                <p>Sedang Tayang</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">📀</div>
            <div class="stat-info">
                <h3><?php echo $telahTayang['total']; ?></h3>
                <p>Telah Tayang</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">⭐</div>
            <div class="stat-info">
                <h3><?php echo number_format($avgRating['avg'], 1); ?></h3>
                <p>Rating Rata-rata</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">🎭</div>
            <div class="stat-info">
                <h3><?php echo $this->db->query("SELECT COUNT(*) as total FROM genres")->fetch(PDO::FETCH_ASSOC)['total']; ?></h3>
                <p>Total Genre</p>
            </div>
        </div>
    </div>

    <!-- Film Terbaru -->
    <div class="section-header" style="margin-top: 40px;">
        <h2>🆕 Film Terbaru</h2>
        <a href="index.php" class="btn btn-secondary">Lihat Semua</a>
    </div>

    <?php
    $latestMovies = $this->db->query("SELECT m.*, g.name as genre_name FROM movies m 
                                      LEFT JOIN genres g ON m.genre_id = g.id 
                                      ORDER BY m.created_at DESC LIMIT 5")->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <div class="movie-scroll">
        <?php foreach($latestMovies as $movie): ?>
            <div class="movie-card-scroll">
                <div class="movie-poster-scroll">
                    <img src="<?php echo htmlspecialchars($movie['poster_url']); ?>" 
                         alt="<?php echo htmlspecialchars($movie['title']); ?>">
                    <div class="rating-badge">
                        <span class="rating-circle">
                            <svg viewBox="0 0 36 36">
                                <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
                                    fill="none" stroke="#204529" stroke-width="3"/>
                                <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
                                    fill="none" stroke="#21d07a" stroke-width="3"
                                    stroke-dasharray="<?php echo ($movie['rating'] * 10) . ', 100'; ?>"/>
                            </svg>
                            <span class="rating-number"><?php echo number_format($movie['rating'] * 10, 0); ?>%</span>
                        </span>
                    </div>
                </div>
                <div class="movie-info-scroll">
                    <h3><?php echo htmlspecialchars($movie['title']); ?></h3>
                    <p class="movie-date"><?php echo date('M d, Y', strtotime($movie['release_date'])); ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Film Rating Tertinggi -->
    <div class="section-header" style="margin-top: 40px;">
        <h2>⭐ Film Rating Tertinggi</h2>
    </div>

    <?php
    $topRatedMovies = $this->db->query("SELECT m.*, g.name as genre_name FROM movies m 
                                        LEFT JOIN genres g ON m.genre_id = g.id 
                                        ORDER BY m.rating DESC LIMIT 5")->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <div class="movie-scroll">
        <?php foreach($topRatedMovies as $movie): ?>
            <div class="movie-card-scroll">
                <div class="movie-poster-scroll">
                    <img src="<?php echo htmlspecialchars($movie['poster_url']); ?>" 
                         alt="<?php echo htmlspecialchars($movie['title']); ?>">
                    <div class="rating-badge">
                        <span class="rating-circle">
                            <svg viewBox="0 0 36 36">
                                <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
                                    fill="none" stroke="#204529" stroke-width="3"/>
                                <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
                                    fill="none" stroke="#21d07a" stroke-width="3"
                                    stroke-dasharray="<?php echo ($movie['rating'] * 10) . ', 100'; ?>"/>
                            </svg>
                            <span class="rating-number"><?php echo number_format($movie['rating'] * 10, 0); ?>%</span>
                        </span>
                    </div>
                </div>
                <div class="movie-info-scroll">
                    <h3><?php echo htmlspecialchars($movie['title']); ?></h3>
                    <p class="movie-date"><?php echo date('M d, Y', strtotime($movie['release_date'])); ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php require_once 'views/layouts/footer.php'; ?>