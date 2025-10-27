<?php require_once 'views/layouts/header.php'; ?>

<div class="container">
    <div class="header-section">
        <h1>📽️ Movie Management System</h1>
        <p class="subtitle">Kelola data film yang akan tayang, sedang tayang, dan telah tayang</p>
    </div>

    <?php if(isset($_GET['message'])): ?>
        <div class="alert alert-success">
            ✅ <?php echo htmlspecialchars($_GET['message']); ?>
        </div>
    <?php endif; ?>

    <?php if(isset($_GET['error'])): ?>
        <div class="alert alert-error">
            ❌ <?php echo htmlspecialchars($_GET['error']); ?>
        </div>
    <?php endif; ?>

    <div class="toolbar">
        <a href="index.php?action=create" class="btn btn-primary">➕ Tambah Film Baru</a>
        
        <form method="GET" class="search-form">
            <input type="text" name="search" placeholder="Cari film..." 
                   value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
            <button type="submit" class="btn btn-secondary">🔍 Cari</button>
        </form>
    </div>

    <div class="filter-tabs">
        <a href="index.php" class="tab <?php echo (!isset($_GET['filter']) || $_GET['filter'] == 'all') ? 'active' : ''; ?>">
            Semua Film
        </a>
        <a href="index.php?filter=akan_tayang" class="tab <?php echo (isset($_GET['filter']) && $_GET['filter'] == 'akan_tayang') ? 'active' : ''; ?>">
            🎬 Akan Tayang
        </a>
        <a href="index.php?filter=sedang_tayang" class="tab <?php echo (isset($_GET['filter']) && $_GET['filter'] == 'sedang_tayang') ? 'active' : ''; ?>">
            🎥 Sedang Tayang
        </a>
        <a href="index.php?filter=telah_tayang" class="tab <?php echo (isset($_GET['filter']) && $_GET['filter'] == 'telah_tayang') ? 'active' : ''; ?>">
            📀 Telah Tayang
        </a>
    </div>

    <?php if(empty($movies)): ?>
        <div class="empty-state">
            <p>📭 Tidak ada film yang ditemukan</p>
        </div>
    <?php else: ?>
        <div class="movie-grid">
            <?php foreach($movies as $movie): ?>
                <div class="movie-card">
                    <div class="movie-poster">
                        <img src="<?php echo htmlspecialchars($movie['poster_url']); ?>" 
                             alt="<?php echo htmlspecialchars($movie['title']); ?>">
                        <span class="status-badge status-<?php echo $movie['status']; ?>">
                            <?php 
                            switch($movie['status']) {
                                case 'akan_tayang': echo '🎬 Akan Tayang'; break;
                                case 'sedang_tayang': echo '🎥 Sedang Tayang'; break;
                                case 'telah_tayang': echo '📀 Telah Tayang'; break;
                            }
                            ?>
                        </span>
                    </div>
                    <div class="movie-info">
                        <h3><?php echo htmlspecialchars($movie['title']); ?></h3>
                        <p class="director">🎬 <?php echo htmlspecialchars($movie['director']); ?></p>
                        <p class="genre">🎭 <?php echo htmlspecialchars($movie['genre']); ?></p>
                        <p class="duration">⏱️ <?php echo $movie['duration']; ?> menit</p>
                        <p class="release-date">📅 <?php echo date('d M Y', strtotime($movie['release_date'])); ?></p>
                        
                        <div class="card-actions">
                            <a href="index.php?action=show&id=<?php echo $movie['id']; ?>" class="btn btn-info btn-sm">👁️ Detail</a>
                            <a href="index.php?action=edit&id=<?php echo $movie['id']; ?>" class="btn btn-warning btn-sm">✏️ Edit</a>
                            <a href="index.php?action=delete&id=<?php echo $movie['id']; ?>" 
                               class="btn btn-danger btn-sm" 
                               onclick="return confirm('Apakah Anda yakin ingin menghapus film ini?')">🗑️ Hapus</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php require_once 'views/layouts/footer.php'; ?>