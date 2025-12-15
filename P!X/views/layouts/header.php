<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>P!X - Sistem Bioskop</title>
    <link rel="stylesheet" href="assets/style.css">
    <style>
        /* Dropdown Menu Styles - FIXED VERSION */
        .nav-dropdown {
            position: relative;
            display: inline-block;
        }
        
        .nav-dropdown-btn {
            background: rgba(255,255,255,0.1);
            color: white;
            padding: 10px 18px;
            border-radius: 8px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s;
            border: 2px solid transparent;
            font-size: 14px;
            font-weight: 600;
            white-space: nowrap;
        }
        
        .nav-dropdown-btn:hover,
        .nav-dropdown.active .nav-dropdown-btn {
            background: rgba(255,255,255,0.25);
            border-color: rgba(255,255,255,0.3);
        }
        
        .dropdown-arrow {
            transition: transform 0.3s;
            font-size: 12px;
        }
        
        .nav-dropdown.active .dropdown-arrow {
            transform: rotate(180deg);
        }
        
        .nav-dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            top: calc(100% + 12px);
            background: white;
            min-width: 240px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            border-radius: 12px;
            overflow: hidden;
            z-index: 9999;
            opacity: 0;
            transform: translateY(-10px);
            transition: all 0.3s ease;
        }
        
        .nav-dropdown.active .nav-dropdown-content {
            display: block;
            opacity: 1;
            transform: translateY(0);
        }
        
        /* Arrow pointer */
        .nav-dropdown-content::before {
            content: '';
            position: absolute;
            top: -6px;
            right: 20px;
            width: 12px;
            height: 12px;
            background: white;
            transform: rotate(45deg);
            box-shadow: -2px -2px 4px rgba(0,0,0,0.1);
        }
        
        .dropdown-header {
            background: linear-gradient(135deg, #032541 0%, #01b4e4 100%);
            color: white;
            padding: 18px 20px;
            border-bottom: 2px solid rgba(255,255,255,0.1);
            position: relative;
            z-index: 1;
        }
        
        .dropdown-header h4 {
            margin: 0 0 5px 0;
            font-size: 16px;
            font-weight: 600;
        }
        
        .dropdown-header p {
            margin: 0;
            font-size: 12px;
            opacity: 0.9;
        }
        
        .dropdown-item {
            display: block;
            padding: 14px 20px;
            color: #032541;
            text-decoration: none;
            transition: all 0.3s;
            border-bottom: 1px solid #f0f0f0;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 14px;
            font-weight: 500;
        }
        
        .dropdown-item:last-child {
            border-bottom: none;
        }
        
        .dropdown-item:hover {
            background: #f8f9fa;
            padding-left: 25px;
            color: #01b4e4;
        }
        
        .dropdown-item.logout {
            color: #dc3545;
            font-weight: 600;
        }
        
        .dropdown-item.logout:hover {
            background: #fff5f5;
            color: #c82333;
        }
        
        /* Overlay untuk close dropdown saat klik di luar */
        .dropdown-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 9998;
        }
        
        .dropdown-overlay.active {
            display: block;
        }
    </style>
</head>
<body>
<!-- Overlay untuk close dropdown -->
<div class="dropdown-overlay" id="dropdownOverlay"></div>

<!-- Navbar -->
<nav class="navbar">
    <div class="nav-container">
        <a href="index.php?module=film" class="nav-brand">P!X</a>
        <div class="nav-actions">
            <div class="nav-menu">
                <?php
                if(session_status() == PHP_SESSION_NONE) session_start();
                
                if(isset($_SESSION['admin_id'])):
                    // Menu Admin - FIXED: Hanya Film, Bioskop, Jadwal
                ?>
                    <a href="index.php?module=film">🎬 Film</a>
                    <a href="index.php?module=bioskop">🏢 Bioskop</a>
                    <a href="index.php?module=jadwal">📅 Jadwal</a>
                <?php 
                elseif(isset($_SESSION['user_id'])):
                    // Menu User - FIXED: Hanya Film
                ?>
                    <a href="index.php?module=film">🎬 Film</a>
                <?php 
                else:
                    // Menu Public
                ?>
                    <a href="index.php?module=film">🎬 Film</a>
                <?php endif; ?>
            </div>
            
            <div class="nav-right">
            <?php
            if(isset($_SESSION['admin_id'])): ?>
                <!-- Admin Dropdown Menu -->
                <div class="nav-dropdown" id="adminDropdown">
                    <button class="nav-dropdown-btn" type="button">
                        <span>👤 Admin</span>
                        <span class="dropdown-arrow">▼</span>
                    </button>
                    <div class="nav-dropdown-content">
                        <div class="dropdown-header">
                            <h4><?php echo htmlspecialchars($_SESSION['admin_name'] ?? $_SESSION['admin_username']); ?></h4>
                            <p>Administrator</p>
                        </div>
                        <a href="index.php?module=admin&action=dashboard" class="dropdown-item">
                            📊 Dashboard
                        </a>
                        <a href="index.php?module=auth&action=gantiPasswordAdmin" class="dropdown-item">
                            🔐 Ganti Password
                        </a>
                        <a href="index.php?module=auth&action=logout" class="dropdown-item logout" onclick="return confirm('Yakin ingin logout?')">
                            🚪 Logout
                        </a>
                    </div>
                </div>
            <?php elseif(isset($_SESSION['user_id'])): ?>
                <!-- User Dropdown Menu -->
                <div class="nav-dropdown" id="userDropdown">
                    <button class="nav-dropdown-btn" type="button">
                        <span>👤 <?php echo htmlspecialchars($_SESSION['user_username']); ?></span>
                        <span class="dropdown-arrow">▼</span>
                    </button>
                    <div class="nav-dropdown-content">
                        <div class="dropdown-header">
                            <h4><?php echo htmlspecialchars($_SESSION['user_name'] ?? $_SESSION['user_username']); ?></h4>
                            <p>Member</p>
                        </div>
                        <a href="index.php?module=user&action=dashboard" class="dropdown-item">
                            🏠 Dashboard
                        </a>
                        <a href="index.php?module=user&action=riwayat" class="dropdown-item">
                            🎫 Riwayat Tiket
                        </a>
                        <a href="index.php?module=auth&action=gantiPasswordUser" class="dropdown-item">
                            🔐 Ganti Password
                        </a>
                        <a href="index.php?module=auth&action=logout" class="dropdown-item logout" onclick="return confirm('Yakin ingin logout?')">
                            🚪 Logout
                        </a>
                    </div>
                </div>
            <?php else: ?>
                <a href="index.php?module=auth&action=index" class="btn-link">🔐 Login</a>
                <a href="index.php?module=auth&action=register" class="btn-link">📝 Daftar</a>
            <?php endif; ?>
            </div>
        </div>
    </div>
</nav>
    
    <?php
    // Toast notification
    if(isset($_SESSION['flash'])) {
        $msg = htmlspecialchars($_SESSION['flash']);
        echo "<div class=\"toast toast-success\" id=\"toast\">";
        echo "<div class=\"toast-body\">$msg</div>";
        echo "<button class=\"toast-close\" aria-label=\"Tutup\">&times;</button>";
        echo "</div>";
        unset($_SESSION['flash']);
    }
    if(isset($_GET['error'])) {
        $err = htmlspecialchars($_GET['error']);
        echo "<div class=\"toast toast-error\" id=\"toast\">";
        echo "<div class=\"toast-body\">$err</div>";
        echo "<button class=\"toast-close\" aria-label=\"Tutup\">&times;</button>";
        echo "</div>";
    }
    ?>

    <script>
        // Toast notification script
        (function(){
            var t = document.getElementById('toast');
            if(!t) return;
            function hideToast(){ t.classList.remove('show'); setTimeout(function(){ t.remove(); }, 400); }
            setTimeout(hideToast, 3500);
            var btn = t.querySelector('.toast-close');
            if(btn) btn.addEventListener('click', hideToast);
            setTimeout(function(){ t.classList.add('show'); }, 50);
        })();
        
        // Dropdown menu script - FIXED VERSION
        document.addEventListener('DOMContentLoaded', function() {
            const adminDropdown = document.getElementById('adminDropdown');
            const userDropdown = document.getElementById('userDropdown');
            const overlay = document.getElementById('dropdownOverlay');
            
            // Function to toggle dropdown
            function toggleDropdown(dropdown) {
                if (!dropdown) return;
                
                const isActive = dropdown.classList.contains('active');
                
                // Close all dropdowns first
                document.querySelectorAll('.nav-dropdown').forEach(d => {
                    d.classList.remove('active');
                });
                
                // Toggle current dropdown
                if (!isActive) {
                    dropdown.classList.add('active');
                    overlay.classList.add('active');
                } else {
                    overlay.classList.remove('active');
                }
            }
            
            // Add click event to dropdown buttons
            if (adminDropdown) {
                const btn = adminDropdown.querySelector('.nav-dropdown-btn');
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    toggleDropdown(adminDropdown);
                });
            }
            
            if (userDropdown) {
                const btn = userDropdown.querySelector('.nav-dropdown-btn');
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    toggleDropdown(userDropdown);
                });
            }
            
            // Close dropdown when clicking overlay
            overlay.addEventListener('click', function() {
                document.querySelectorAll('.nav-dropdown').forEach(d => {
                    d.classList.remove('active');
                });
                overlay.classList.remove('active');
            });
            
            // Close dropdown when pressing ESC
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    document.querySelectorAll('.nav-dropdown').forEach(d => {
                        d.classList.remove('active');
                    });
                    overlay.classList.remove('active');
                }
            });
            
            // Prevent dropdown from closing when clicking inside
            document.querySelectorAll('.nav-dropdown-content').forEach(content => {
                content.addEventListener('click', function(e) {
                    // Only stop propagation for non-link elements
                    if (e.target.tagName !== 'A') {
                        e.stopPropagation();
                    }
                });
            });
        });
    </script>
</body>
</html>