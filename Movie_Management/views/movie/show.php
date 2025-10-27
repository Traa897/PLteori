<?php require_once 'views/layouts/header.php'; ?>

<div class="container">
    <div class="header-section">
        <h1>🎬 Detail Film</h1>
        <a href="index.php" class="btn btn-secondary">⬅️ Kembali</a>
    </div>

    <div class="detail-container">
        <div class="detail-poster">
            <img src="<?php echo htmlspecialchars($this->movie->poster_url); ?>" 
                 alt="<?php echo htmlspecialchars($this->movie->title); ?>">
        </div>
        
        <div class="detail-info">
            <h2><?php echo htmlspecialchars($this->movie->title); ?></h2>
            
            <div class="status-badge-large status-<?php echo $this->movie->status; ?>">
                <?php 
                switch($this->movie->status) {
                    case 'akan_tayang': echo '🎬 AKAN TAYANG'; break;
                    case 'sedang_tayang': echo '🎥 SEDANG TAYANG'; break;
                    case 'telah_tayang': echo '📀 TELAH TAYANG'; break;
                }
                ?>
            </div>

            <div class="info-grid">
                <div class="info-item">
                    <strong>🎬 Sutradara:</strong>
                    <p><?php echo htmlspecialchars($this->movie->director); ?></p>
                </div>

                <div class="info-item">
                    <strong>🎭 Genre:</strong>
                    <p><?php echo htmlspecialchars($this->movie->genre); ?></p>
                </div>

                <div class="info-item">
                    <strong>⏱️ Durasi:</strong>
                    <p><?php echo $this->movie->duration; ?> menit</p>
                </div>

                <div class="info-item">
                    <strong>📅 Tanggal Rilis:</strong>
                    <p><?php echo date('d F Y', strtotime($this->movie->release_date)); ?></p>
                </div>
            </div>

            <div class="synopsis-section">
                <strong>📝 Sinopsis:</strong>
                <p><?php echo nl2br(htmlspecialchars($this->movie->synopsis)); ?></p>
            </div>

            <div class="detail-actions">
                <a href="index.php?action=edit&id=<?php echo $this->movie->id; ?>" 
                   class="btn btn-warning">✏️ Edit Film</a>
                <a href="index.php?action=delete&id=<?php echo $this->movie->id; ?>" 
                   class="btn btn-danger" 
                   onclick="return confirm('Apakah Anda yakin ingin menghapus film ini?')">🗑️ Hapus Film</a>
            </div>
        </div>
    </div>
</div>

<?php require_once 'views/layouts/footer.php'; ?>