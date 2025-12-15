<?php require_once 'views/layouts/header.php'; ?>

<div class="container">
    <div class="header-section">
        <h1>
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle; margin-right: 8px;">
                <rect x="3" y="3" width="18" height="18" rx="2"/>
                <path d="M9 3v18M15 3v18M3 9h18M3 15h18"/>
            </svg>
            Dashboard Admin
        </h1>
        <div style="display: flex; gap: 10px;">
            <a href="index.php?module=admin&action=createFilm" class="btn btn-primary">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle; margin-right: 4px;">
                    <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
                Tambah Film
            </a>
            <a href="index.php?module=jadwal&action=create" class="btn btn-info">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle; margin-right: 4px;">
                    <rect x="3" y="4" width="18" height="18" rx="2"/>
                    <line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/>
                    <line x1="3" y1="10" x2="21" y2="10"/>
                </svg>
                Tambah Jadwal
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="2" y="7" width="20" height="15" rx="2"/>
                    <polyline points="17 2 12 7 7 2"/>
                </svg>
            </div>
            <div class="stat-info">
                <h3><?php echo $totalFilms; ?></h3>
                <p>Total Film</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                    <polyline points="9 22 9 12 15 12 15 22"/>
                </svg>
            </div>
            <div class="stat-info">
                <h3><?php echo $totalBioskops; ?></h3>
                <p>Total Bioskop</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="4" width="18" height="18" rx="2"/>
                    <line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/>
                    <line x1="3" y1="10" x2="21" y2="10"/>
                </svg>
            </div>
            <div class="stat-info">
                <h3><?php echo $totalJadwals; ?></h3>
                <p>Jadwal Tayang</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
            </div>
            <div class="stat-info">
                <h3><?php echo $totalUsers; ?></h3>
                <p>User Aktif</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M20 7h-3a2 2 0 0 1-2-2V2"/>
                    <rect x="3" y="2" width="14" height="20" rx="2"/>
                    <path d="M7 10h6M7 14h6M7 18h3"/>
                </svg>
            </div>
            <div class="stat-info">
                <h3><?php echo $totalTransaksi; ?></h3>
                <p>Total Transaksi</p>
            </div>
        </div>

        <div class="stat-card" style="grid-column: span 2;">
            <div class="stat-icon">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                </svg>
            </div>
            <div class="stat-info">
                <h3>Rp <?php echo number_format($totalRevenue, 0, ',', '.'); ?></h3>
                <p>Total Pendapatan</p>
            </div>
        </div>
    </div>

    <!-- Film Tanpa Jadwal -->
    <div class="section-header" style="margin-top: 40px;">
        <h2>
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle; margin-right: 8px;">
                <circle cx="12" cy="12" r="10"/>
                <line x1="12" y1="8" x2="12" y2="12"/>
                <line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
            Film Belum Ada Jadwal Aktif
        </h2>
        <div style="display: flex; gap: 10px;">
            <a href="index.php?module=admin&action=cleanExpiredFilms" class="btn btn-warning" 
               onclick="return confirm('Hapus semua film yang jadwalnya sudah lewat?')">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle; margin-right: 4px;">
                    <polyline points="3 6 5 6 21 6"/>
                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                </svg>
                Bersihkan Film Kadaluarsa
            </a>
        </div>
    </div>

    <?php
    $filmsWithoutSchedule = $this->film->readFilmsWithoutSchedule()->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <?php if(empty($filmsWithoutSchedule)): ?>
        <div class="empty-state">
            <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="#999" stroke-width="2" style="margin-bottom: 15px;">
                <polyline points="20 6 9 17 4 12"/>
            </svg>
            <p>Semua film sudah memiliki jadwal tayang aktif</p>
        </div>
    <?php else: ?>
        <div class="movie-scroll" style="margin-bottom: 40px;">
            <?php foreach($filmsWithoutSchedule as $film): ?>
                <div class="movie-card-scroll">
                    <div class="movie-poster-scroll">
                        <img src="<?php echo htmlspecialchars($film['poster_url'] ?? 'https://via.placeholder.com/150x225'); ?>" 
                             alt="<?php echo htmlspecialchars($film['judul_film']); ?>">
                        <div class="rating-badge">
                            <span class="rating-circle">
                                <svg viewBox="0 0 36 36">
                                    <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
                                        fill="none" stroke="#204529" stroke-width="3"/>
                                    <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
                                        fill="none" stroke="#21d07a" stroke-width="3"
                                        stroke-dasharray="<?php echo ($film['rating'] * 10) . ', 100'; ?>"/>
                                </svg>
                                <span class="rating-number"><?php echo number_format($film['rating'] * 10, 0); ?></span>
                            </span>
                        </div>
                        <div class="card-actions-overlay">
                            <a href="index.php?module=jadwal&action=create" class="btn btn-primary btn-sm" style="font-size: 11px;">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle; margin-right: 2px;">
                                    <rect x="3" y="4" width="18" height="18" rx="2"/>
                                    <line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/>
                                    <line x1="3" y1="10" x2="21" y2="10"/>
                                </svg>
                                Tambah Jadwal
                            </a>
                            <a href="index.php?module=admin&action=editFilm&id=<?php echo $film['id_film']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="index.php?module=admin&action=deleteFilm&id=<?php echo $film['id_film']; ?>" 
                               class="btn btn-danger btn-sm" 
                               onclick="return confirm('Hapus film <?php echo htmlspecialchars($film['judul_film']); ?>?')">Hapus</a>
                        </div>
                    </div>
                    <div class="movie-info-scroll">
                        <h3><?php echo htmlspecialchars($film['judul_film']); ?></h3>
                        <p class="movie-date"><?php echo $film['tahun_rilis']; ?> • <?php echo $film['durasi_menit']; ?> menit</p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- Recent Transactions (tetap sama) -->
    <div class="section-header" style="margin-top: 40px;">
        <h2>Transaksi Terbaru</h2>
    </div>

    <?php if(empty($recentTransactions)): ?>
        <div class="empty-state">
            <p>Belum ada transaksi</p>
        </div>
    <?php else: ?>
        <div style="display: grid; gap: 15px;">
            <?php foreach($recentTransactions as $trans): ?>
                <div style="background: white; border-radius: 10px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); display: grid; grid-template-columns: auto 1fr auto; gap: 20px; align-items: center;">
                    <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 24px;">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20 7h-3a2 2 0 0 1-2-2V2"/>
                            <rect x="3" y="2" width="14" height="20" rx="2"/>
                        </svg>
                    </div>
                    <div>
                        <h4 style="margin: 0 0 5px 0; color: #032541;">
                            <?php echo htmlspecialchars($trans['kode_booking']); ?>
                        </h4>
                        <p style="margin: 3px 0; color: #666; font-size: 14px;">
                            <?php echo htmlspecialchars($trans['nama_user'] ?? $trans['email'] ?? 'User'); ?> • 
                            <?php echo htmlspecialchars($trans['email']); ?>
                        </p>
                        <p style="margin: 3px 0; color: #666; font-size: 14px;">
                            <?php echo date('d/m/Y H:i', strtotime($trans['tanggal_transaksi'])); ?> • 
                            <?php echo $trans['jumlah_tiket']; ?> tiket
                        </p>
                    </div>
                    <div style="text-align: right;">
                        <div style="color: #01b4e4; font-weight: 700; font-size: 18px; margin-bottom: 5px;">
                            Rp <?php echo number_format($trans['total_harga'], 0, ',', '.'); ?>
                        </div>
                        <span style="padding: 5px 12px; background: <?php 
                            echo $trans['status_pembayaran'] === 'berhasil' ? '#21d07a' : 
                                ($trans['status_pembayaran'] === 'pending' ? '#ffc107' : '#dc3545'); 
                        ?>; color: white; border-radius: 15px; font-size: 12px; font-weight: 600;">
                            <?php echo strtoupper($trans['status_pembayaran']); ?>
                        </span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php require_once 'views/layouts/footer.php'; ?>