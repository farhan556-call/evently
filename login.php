<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Evently | Admin Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #ffffff;
            overflow-x: hidden;
        }

        /* --- THEME COLORS --- */
        :root {
            --brand-blue: #1d4ed8; 
            --brand-accent: #3b82f6;
        }

        /* --- LEFT SIDE: BRANDING --- */
        .brand-section {
            min-height: 100vh;
            /* THEME: Deep Blue Night Gradient matching Sidebar/Index */
            background: linear-gradient(135deg, #000428 0%, #004e92 100%);
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 60px;
            color: white;
        }

        /* Background Shapes */
        .shape { position: absolute; border-radius: 50%; filter: blur(80px); opacity: 0.3; z-index: 0; }
        .shape-1 { background: #ffffff; width: 300px; height: 300px; top: -50px; left: -50px; }
        .shape-2 { background: var(--brand-accent); width: 400px; height: 400px; bottom: 0; right: -100px; }
        .brand-content { position: relative; z-index: 1; }
        
        /* Logo Container */
        .logo-container {
            background: rgba(255, 255, 255, 0.95);
            padding: 20px 30px;
            border-radius: 16px;
            display: inline-block;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        .logo-container img { height: 50px; width: auto; }

        /* --- RIGHT SIDE: FORM --- */
        .login-section {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8fafc;
        }

        .login-container { width: 100%; max-width: 500px; padding: 40px; }

        .form-floating > .form-control {
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            height: 60px;
            font-weight: 500;
            background-color: #ffffff;
        }
        .form-floating > .form-control:focus {
            border-color: var(--brand-blue);
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
        }
        .form-floating > label { padding-top: 1.1rem; }

        .btn-primary-custom {
            background: linear-gradient(to right, var(--brand-blue), var(--brand-accent));
            border: none;
            padding: 16px;
            font-size: 16px;
            font-weight: 700;
            border-radius: 12px;
            transition: all 0.2s;
            color: white;
        }
        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(29, 78, 216, 0.3);
            color: white;
        }
        
        .password-toggle {
            position: absolute; right: 20px; top: 20px; color: #94a3b8; cursor: pointer; z-index: 10;
        }
        .password-toggle:hover { color: #334155; }

        /* --- CAPTCHA --- */
        .captcha-wrapper {
            background: #ffffff;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 6px;
            display: flex;
            height: 60px;
        }
        .captcha-display {
            background: #f1f5f9;
            border-radius: 8px;
            padding: 0 24px;
            font-weight: 700;
            color: #475569;
            letter-spacing: 2px;
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 120px;
        }
        .captcha-input {
            border: none; outline: none; text-align: center; font-weight: 600; font-size: 18px; flex-grow: 1; background: transparent;
        }

        /* Animation */
        .shake { animation: shake 0.4s cubic-bezier(.36,.07,.19,.97) both; }
        @keyframes shake {
            10%, 90% { transform: translate3d(-1px, 0, 0); }
            20%, 80% { transform: translate3d(2px, 0, 0); }
            30%, 50%, 70% { transform: translate3d(-4px, 0, 0); }
            40%, 60% { transform: translate3d(4px, 0, 0); }
        }

        /* Mobile Adjustments */
        @media (max-width: 991px) {
            .brand-section { display: none; }
            .login-section { padding: 20px; background: white; }
            .login-container { padding: 0; margin-top: 40px; }
            
            /* Show Logo on Mobile Top */
            .mobile-logo { display: block; text-align: center; margin-bottom: 30px; }
            .mobile-logo img { height: 50px; }
        }
        @media (min-width: 992px) { .mobile-logo { display: none; } }
    </style>
</head>
<body>

<div class="container-fluid g-0">
    <div class="row g-0">
        
        <div class="col-lg-5 d-none d-lg-block brand-section">
            <div class="shape shape-1"></div>
            <div class="shape shape-2"></div>
            
            <div class="brand-content">
                <div class="logo-container">
                    <img src="assets/logos/EventlyLogo-removebg.png" alt="Evently Logo">
                </div>
                
                <h1 class="display-4 fw-bold mb-3">Admin Portal</h1>
                <p class="lead opacity-75 mb-5">Secure access to your event management dashboard. Track registrations and live check-ins.</p>
                
                <div class="d-flex align-items-center opacity-75 small fw-bold text-uppercase letter-spacing-1">
                    <div class="me-4"><i class="fas fa-shield-alt me-2"></i>Secure</div>
                    <div class="me-4"><i class="fas fa-bolt me-2"></i>Fast</div>
                    <div><i class="fas fa-sync me-2"></i>Real-time</div>
                </div>
            </div>
        </div>

        <div class="col-lg-7 login-section">
            <div class="login-container" id="loginCard">
                
                <div class="mobile-logo">
                    <img src="assets/logos/EventlyLogo-removebg.png" alt="Evently Logo">
                </div>

                <div class="mb-5">
                    <h2 class="fw-bold text-dark display-6">Welcome Back! 👋</h2>
                    <p class="text-muted">Please sign in to manage your events.</p>
                </div>

                <div id="error-alert" class="alert alert-danger border-0 bg-danger bg-opacity-10 text-danger d-none d-flex align-items-center p-3 rounded-3 mb-4" role="alert">
                    <i class="fas fa-exclamation-circle me-2 fs-5"></i>
                    <span id="error-msg" class="fw-medium">Error message</span>
                </div>

                <form id="loginForm" novalidate>
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="email" placeholder="name@example.com" value="admin@gmail.com" required>
                        <label for="email" class="text-muted">Email Address</label>
                    </div>

                    <div class="form-floating mb-4 position-relative">
                        <input type="password" class="form-control" id="password" placeholder="Password" value="admin123" required>
                        <label for="password" class="text-muted">Password</label>
                        <i class="fas fa-eye password-toggle fs-5" id="togglePassword"></i>
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-muted small fw-bold text-uppercase">Security Check</label>
                        <div class="captcha-wrapper">
                            <div class="captcha-display" id="captcha-question">...</div>
                            <input type="number" class="form-control captcha-input" id="captcha-input" placeholder="?" required>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="rememberMe" checked>
                            <label class="form-check-label text-muted" for="rememberMe">Remember me</label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary-custom w-100" id="loginBtn">
                        Sign In to Dashboard <i class="fas fa-arrow-right ms-2"></i>
                    </button>
                </form>

                <div class="mt-5 text-center text-muted small">
                    <p class="mb-0">Designed and Developed by TM037 &copy; <?php echo date("Y"); ?></p>
                </div>

            </div>
        </div>

    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script type="module">
    import { auth, signInWithEmailAndPassword } from "./firebase-config.js";
    import { setPersistence, browserLocalPersistence, browserSessionPersistence } from "https://www.gstatic.com/firebasejs/12.8.0/firebase-auth.js";

    let captchaAnswer = 0;

    // 1. Initialize Captcha
    function generateCaptcha() {
        const num1 = Math.floor(Math.random() * 10) + 1;
        const num2 = Math.floor(Math.random() * 10) + 1;
        captchaAnswer = num1 + num2;
        $("#captcha-question").text(`${num1} + ${num2} =`);
        $("#captcha-input").val('');
    }

    // 2. Toggle Password Visibility
    $("#togglePassword").click(function() {
        const passInput = $("#password");
        const icon = $(this);
        if (passInput.attr("type") === "password") {
            passInput.attr("type", "text");
            icon.removeClass("fa-eye").addClass("fa-eye-slash");
        } else {
            passInput.attr("type", "password");
            icon.removeClass("fa-eye-slash").addClass("fa-eye");
        }
    });

    // 3. Handle Login Submit
    $("#loginForm").submit(async function(e) {
        e.preventDefault();
        
        const email = $("#email").val().trim();
        const password = $("#password").val().trim();
        const userCaptcha = parseInt($("#captcha-input").val());
        const rememberMe = $("#rememberMe").is(":checked");
        const btn = $("#loginBtn");
        const alertBox = $("#error-alert");

        // UI Reset
        alertBox.addClass("d-none");
        $("#loginCard").removeClass("shake");

        // Validation
        if (!email || !password) {
            showError("Please enter both email and password.");
            return;
        }

        if (isNaN(userCaptcha) || userCaptcha !== captchaAnswer) {
            showError("Incorrect security answer. Please try again.");
            generateCaptcha();
            $("#captcha-input").focus();
            return;
        }

        // Firebase Login
        btn.html('<span class="spinner-border spinner-border-sm me-2"></span>Authenticating...').prop("disabled", true);

        try {
            const persistenceType = rememberMe ? browserLocalPersistence : browserSessionPersistence;
            
            await setPersistence(auth, persistenceType);
            await signInWithEmailAndPassword(auth, email, password);
            
            // Success
            window.location.href = "dashboard.php";

        } catch (error) {
            console.error(error);
            
            // User-Friendly Error Messages
            let msg = "Invalid login credentials.";
            if(error.code === 'auth/user-not-found') msg = "No account found with this email.";
            if(error.code === 'auth/wrong-password') msg = "Incorrect password.";
            if(error.code === 'auth/too-many-requests') msg = "Too many failed attempts. Please wait.";
            if(error.code === 'auth/invalid-email') msg = "Invalid email format.";

            showError(msg);
            btn.html('Sign In to Dashboard <i class="fas fa-arrow-right ms-2"></i>').prop("disabled", false);
            generateCaptcha();
        }
    });

    function showError(msg) {
        $("#error-msg").text(msg);
        $("#error-alert").removeClass("d-none");
        $("#loginCard").addClass("shake");
        setTimeout(() => $("#loginCard").removeClass("shake"), 500);
    }

    // Init
    generateCaptcha();
</script>

</body>
</html>