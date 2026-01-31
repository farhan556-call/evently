<style>
    /* --- CSS VARIABLES & THEME --- */
    :root {
        --sidebar-width: 260px;
        --sidebar-collapsed-width: 80px; 
        --brand-blue: #1d4ed8;
        --brand-accent: #3b82f6;
    }

    body {
        min-height: 100vh;
        background-color: #f4f6f9;
        overflow-x: hidden;
    }

    /* --- SIDEBAR CONTAINER --- */
    #sidebar-wrapper {
        min-height: 100vh;
        width: var(--sidebar-width);
        position: fixed;
        left: 0; top: 0;
        z-index: 1000;
        background: linear-gradient(180deg, #000428 0%, #004e92 100%);
        transition: width 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        display: flex;
        flex-direction: column;
        box-shadow: 5px 0 15px rgba(0,0,0,0.15);
    }

    /* --- CONTENT AREA ADJUSTMENT --- */
    .main-content-wrapper {
        width: 100%;
        margin-left: var(--sidebar-width);
        transition: margin-left 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        padding: 30px;
    }

    /* --- HEADER STYLING (The Key Fix) --- */
    .sidebar-header {
        height: 80px;
        display: flex;
        align-items: center; /* Vertically center */
        justify-content: space-between; /* Spread Logo and Button */
        padding: 0 20px;
        border-bottom: 1px solid rgba(255,255,255,0.1);
        transition: all 0.3s ease;
    }

    .logo-full { display: block; height: 40px; width: auto; transition: 0.2s; }
    .logo-icon { display: none; height: 32px; width: auto; transition: 0.2s; }

    /* --- COLLAPSED STATE LOGIC --- */
    body.sb-collapsed #sidebar-wrapper {
        width: var(--sidebar-collapsed-width);
    }
    body.sb-collapsed .main-content-wrapper {
        margin-left: var(--sidebar-collapsed-width);
    }
    
    /* 1. Collapsed Header: Stack items vertically */
    body.sb-collapsed .sidebar-header {
        flex-direction: column; /* Stack Icon and Button */
        justify-content: center; 
        gap: 10px; /* Space between Icon and Button */
        padding: 0;
        height: 100px; /* Slightly taller to fit both */
    }

    /* 2. Toggle Visibility of Logos */
    body.sb-collapsed .logo-full { display: none !important; }
    body.sb-collapsed .logo-icon { display: block !important; }

    /* 3. Keep Button Visible but Centered */
    body.sb-collapsed #sidebarToggle {
        display: block !important; /* FORCE VISIBLE */
        margin: 0 auto;
    }

    /* 4. Hide Text Elements */
    body.sb-collapsed .sidebar-text, 
    body.sb-collapsed .profile-details {
        display: none !important;
    }

    /* 5. Center Navigation Icons */
    body.sb-collapsed .nav-link {
        justify-content: center;
        padding-left: 0; 
        padding-right: 0;
    }

    /* --- NAVIGATION LINKS --- */
    .nav-link {
        color: rgba(255,255,255,0.7);
        padding: 16px 25px;
        font-size: 0.95rem;
        white-space: nowrap;
        display: flex;
        align-items: center;
        transition: all 0.2s ease;
        border-left: 4px solid transparent;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }
    .nav-link:hover { background: rgba(255,255,255,0.1); color: white; }
    .nav-link.active {
        background: rgba(255,255,255,0.15); color: white;
        border-left-color: #38bdf8; font-weight: 600;
    }
    .nav-link i { min-width: 30px; font-size: 1.2rem; text-align: center; }

    /* --- PROFILE FOOTER --- */
    .sidebar-footer {
        margin-top: auto; padding: 20px;
        background: rgba(0,0,0,0.3);
        border-top: 1px solid rgba(255,255,255,0.1);
    }
    .user-avatar {
        width: 40px; height: 40px; background: #38bdf8; color: #000428;
        border-radius: 10px; display: flex; align-items: center; justify-content: center;
        font-weight: bold; flex-shrink: 0;
    }
    .email-text {
        max-width: 140px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        font-size: 0.85rem; cursor: help;
    }

    /* --- TOGGLE BUTTON --- */
    .toggle-btn {
        background: transparent; border: none; color: rgba(255,255,255,0.6);
        transition: color 0.2s; cursor: pointer;
    }
    .toggle-btn:hover { color: white; }

    /* Mobile Fix */
    @media (max-width: 768px) {
        #sidebar-wrapper { margin-left: calc(-1 * var(--sidebar-width)); }
        .main-content-wrapper { margin-left: 0; }
        body.sb-mobile-open #sidebar-wrapper { margin-left: 0; }
    }
</style>

<div id="sidebar-wrapper">
    
    <div class="sidebar-header">
        <img src="assets/logos/dashboardLogo.png" alt="Evently" class="logo-full">
        
        <img src="assets/logos/icon-preview.png" alt="E" class="logo-icon">

        <button class="toggle-btn" id="sidebarToggle" title="Toggle Menu">
            <i class="fas fa-bars fa-lg"></i>
        </button>
    </div>

    <div class="list-group list-group-flush mt-2">
        <?php $cp = basename($_SERVER['PHP_SELF']); ?>
        
        <a href="dashboard.php" class="nav-link <?php echo ($cp == 'dashboard.php') ? 'active' : ''; ?>">
            <i class="fas fa-home"></i> <span class="sidebar-text ms-3">Dashboard</span>
        </a>

        <a href="events.php" class="nav-link <?php echo ($cp == 'events.php') ? 'active' : ''; ?>">
            <i class="fas fa-calendar-alt"></i> <span class="sidebar-text ms-3">Events</span>
        </a>

        <a href="registrations.php" class="nav-link <?php echo ($cp == 'registrations.php') ? 'active' : ''; ?>">
            <i class="fas fa-users"></i> <span class="sidebar-text ms-3">All Entries</span>
        </a>

        <a href="checkin.php" class="nav-link <?php echo ($cp == 'checkin.php') ? 'active' : ''; ?>">
            <i class="fas fa-qrcode"></i> <span class="sidebar-text ms-3">Check-in</span>
        </a>

        <div class="my-2 border-top border-secondary opacity-25 mx-3"></div>

        <a href="index.php" target="_blank" class="nav-link text-info">
            <i class="fas fa-external-link-alt"></i> <span class="sidebar-text ms-3">Public Form</span>
        </a>
    </div>

    <div class="sidebar-footer">
        <div class="d-flex align-items-center overflow-hidden">
            <div class="user-avatar shadow-sm">
                <i class="fas fa-user-shield"></i>
            </div>
            <div class="ms-3 profile-details text-white" style="min-width: 0;">
                <small class="text-white-50 d-block" style="font-size: 11px; text-transform: uppercase;">Logged In</small>
                <div class="fw-bold email-text" id="sidebar-email" title="Loading...">Loading...</div>
            </div>
        </div>
        <button onclick="logoutApp()" class="btn btn-danger btn-sm w-100 mt-3 profile-details shadow-sm">
            <i class="fas fa-sign-out-alt me-2"></i> Logout
        </button>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const toggle = document.getElementById('sidebarToggle');
        const body = document.body;

        // Restore state
        if (localStorage.getItem('sb_collapsed') === 'true') {
            body.classList.add('sb-collapsed');
        }

        // Toggle Click
        toggle.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation(); // Stop bubbling
            body.classList.toggle('sb-collapsed');
            localStorage.setItem('sb_collapsed', body.classList.contains('sb-collapsed'));
        });
    });
</script>