<?php require_once 'views/layouts/header.php'; ?>

<div class="container">
    <div class="header-section">
        <h1>✏️ Edit Film</h1>
        <a href="index.php" class="btn btn-secondary">⬅️ Kembali</a>
    </div>

    <?php if(isset($_GET['error'])): ?>
        <div class="alert alert-error">
            ❌ <?php echo htmlspecialchars($_GET['error']); ?>
        </div>
    <?php endif; ?>

    <div class="form-container">
        <form method="POST" action="index.php?action=update" class="movie-form">
            <input type="hidden" name="id" value="<?php echo $this->movie->id; ?>">

            <div class="form-group">
                <label for="title">Judul Film *</label>
                <input type="text" id="title" name="title" required 
                       value="<?php echo htmlspecialchars($this->movie->title); ?>">
            </div>

            <div class="form-group">
                <label for="director">Sutradara *</label>
                <input type="text" id="director" name="director" required 
                       value="<?php echo htmlspecialchars($this->movie->director); ?>">
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="genre">Genre *</label>
                    <input type="text" id="genre" name="genre" required 
                           value="<?php echo htmlspecialchars($this->movie->genre); ?>">
                </div>

                <div class="form-group">
                    <label for="duration">Durasi (menit) *</label>
                    <input type="number" id="duration" name="duration" required min="1" 
                           value="<?php echo htmlspecialchars($this->movie->duration); ?>">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="release_date">Tanggal Rilis *</label>
                    <input type="date" id="release_date" name="release_date" required 
                           value="<?php echo htmlspecialchars($this->movie->release_date); ?>">
                </div>

                <div class="form-group">
                    <label for="status">Status *</label>
                    <select id="status" name="status" required>
                        <option value="akan_tayang" <?php echo ($this->movie->status == 'akan_tayang') ? 'selected' : ''; ?>>
                            🎬 Akan Tayang
                        </option>
                        <option value="sedang_tayang" <?php echo ($this->movie->status == 'sedang_tayang') ? 'selected' : ''; ?>>
                            🎥 Sedang Tayang
                        </option>
                        <option value="telah_tayang" <?php echo ($this->movie->status == 'telah_tayang') ? 'selected' : ''; ?>>
                            📀 Telah Tayang
                        </option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="poster_url">URL Poster</label>
                <input type="url" id="poster_url" name="poster_url" 
                       value="<?php echo htmlspecialchars($this->movie->poster_url); ?>">
            </div>

            <div class="form-group">
                <label for="synopsis">Sinopsis</label>
                <textarea id="synopsis" name="synopsis" rows="5"><?php echo htmlspecialchars($this->movie->synopsis); ?></textarea>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">💾 Update Film</button>
                <a href="index.php?action=dashboard" class="btn btn-secondary">❌ Batal</a>
            </div>
        </form>
    </div>
</div>

<?php require_once 'views/layouts/footer.php'; ?>