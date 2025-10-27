<?php require_once 'views/layouts/header.php'; ?>

<div class="container">
    <div class="header-section">
        <h1>➕ Tambah Film Baru</h1>
        <a href="index.php" class="btn btn-secondary">⬅️ Kembali</a>
    </div>

    <?php if(isset($_GET['error'])): ?>
        <div class="alert alert-error">
            ❌ <?php echo htmlspecialchars($_GET['error']); ?>
        </div>
    <?php endif; ?>

    <div class="form-container">
        <form method="POST" action="index.php?action=store" class="movie-form">
            <div class="form-group">
                <label for="title">Judul Film *</label>
                <input type="text" id="title" name="title" required placeholder="Masukkan judul film">
            </div>

            <div class="form-group">
                <label for="director">Sutradara *</label>
                <input type="text" id="director" name="director" required placeholder="Masukkan nama sutradara">
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="genre">Genre *</label>
                    <input type="text" id="genre" name="genre" required placeholder="Contoh: Action, Horror, Drama">
                </div>

                <div class="form-group">
                    <label for="duration">Durasi (menit) *</label>
                    <input type="number" id="duration" name="duration" required min="1" placeholder="120">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="release_date">Tanggal Rilis *</label>
                    <input type="date" id="release_date" name="release_date" required>
                </div>

                <div class="form-group">
                    <label for="status">Status *</label>
                    <select id="status" name="status" required>
                        <option value="">Pilih Status</option>
                        <option value="akan_tayang">🎬 Akan Tayang</option>
                        <option value="sedang_tayang">🎥 Sedang Tayang</option>
                        <option value="telah_tayang">📀 Telah Tayang</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="poster_url">URL Poster</label>
                <input type="url" id="poster_url" name="poster_url" 
                       placeholder="https://example.com/poster.jpg"
                       value="https://via.placeholder.com/300x450/4A90E2/FFFFFF?text=Movie+Poster">
            </div>

            <div class="form-group">
                <label for="synopsis">Sinopsis</label>
                <textarea id="synopsis" name="synopsis" rows="5" 
                          placeholder="Masukkan sinopsis film..."></textarea>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">💾 Simpan Film</button>
                <a href="index.php" class="btn btn-secondary">❌ Batal</a>
            </div>
        </form>
    </div>
</div>

<?php require_once 'views/layouts/footer.php'; ?>