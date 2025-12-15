<?php require_once 'views/layouts/header.php'; ?>

<div class="container" style="max-width: 600px;">
    <div class="header-section">
        <h1>🔐 Ganti Password</h1>
        <a href="index.php?module=user&action=dashboard" class="btn btn-secondary">⬅️ Kembali</a>
    </div>

    <?php if(isset($error)): ?>
        <div class="alert alert-error">
            ❌ <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <div class="form-container">
        <form method="POST" action="index.php?module=auth&action=gantiPasswordUser" class="movie-form">
            <div class="form-group">
                <label for="password_lama">Password Lama *</label>
                <input type="password" id="password_lama" name="password_lama" required 
                       placeholder="Masukkan password lama">
            </div>

            <div class="form-group">
                <label for="password_baru">Password Baru *</label>
                <input type="password" id="password_baru" name="password_baru" required 
                       minlength="6" placeholder="Minimal 6 karakter">
            </div>

            <div class="form-group">
                <label for="konfirmasi_password">Konfirmasi Password Baru *</label>
                <input type="password" id="konfirmasi_password" name="konfirmasi_password" required 
                       minlength="6" placeholder="Ulangi password baru">
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">💾 Ubah Password</button>
                <a href="index.php?module=user&action=dashboard" class="btn btn-secondary">❌ Batal</a>
            </div>
        </form>
    </div>
</div>

<?php require_once 'views/layouts/footer.php'; ?>