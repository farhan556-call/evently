<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Evently | Secure Registration</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #ffffff; overflow-x: hidden; }

        /* --- THEME COLORS --- */
        :root {
            --brand-blue: #1d4ed8; 
            --brand-accent: #3b82f6;
        }

        /* --- LEFT SIDE: BRANDING (Hidden on Mobile) --- */
        .brand-section {
            min-height: 100vh;
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
            padding: 15px 25px;
            border-radius: 16px;
            display: inline-block;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        .logo-container img { height: 50px; width: auto; }

        /* --- RIGHT SIDE: FORM --- */
        .form-section { min-height: 100vh; display: flex; align-items: center; justify-content: center; background-color: #f8fafc; }
        .form-container { width: 100%; max-width: 600px; padding: 40px; }

        /* Mobile Logo (Visible only on mobile) */
        .mobile-logo { display: none; margin-bottom: 30px; text-align: center; }
        .mobile-logo img { height: 45px; }

        .form-floating > .form-control, .form-floating > .form-select {
            border: 2px solid #e2e8f0; border-radius: 12px; height: 60px; font-weight: 500;
        }
        .form-floating > .form-control:focus, .form-floating > .form-select:focus {
            border-color: var(--brand-blue); box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
        }

        .btn-register {
            background: linear-gradient(to right, var(--brand-blue), var(--brand-accent));
            border: none; padding: 16px; font-size: 16px; font-weight: 700; border-radius: 12px; color: white; transition: all 0.2s;
        }
        .btn-register:hover { transform: translateY(-2px); box-shadow: 0 10px 20px rgba(29, 78, 216, 0.3); color: white; }

        /* CAPTCHA */
        .captcha-wrapper { background: #fff; border: 2px solid #e2e8f0; border-radius: 12px; padding: 6px; display: flex; height: 60px; }
        .captcha-display { background: #f1f5f9; border-radius: 8px; padding: 0 20px; font-weight: 700; color: #475569; letter-spacing: 2px; display: flex; align-items: center; justify-content: center; min-width: 150px; }
        .captcha-input { border: none; outline: none; text-align: center; font-weight: 600; font-size: 18px; flex-grow: 1; }

        /* --- TICKET DESIGN --- */
        #ticket-result { display: none; }
        .ticket-card {
            background: white; border-radius: 20px; border: 1px solid #e2e8f0; overflow: hidden; position: relative;
            box-shadow: 0 20px 50px rgba(0,0,0,0.1); margin-top: 20px;
            /* Ensure print colors work */
            -webkit-print-color-adjust: exact; print-color-adjust: exact;
        }
        .ticket-header { background: var(--brand-blue) !important; color: white !important; padding: 20px; text-align: center; }
        .ticket-body { padding: 30px; text-align: center; position: relative; }
        
        .ticket-body::before { content: ""; position: absolute; top: -10px; left: 0; right: 0; border-top: 3px dashed #e2e8f0; }
        .ticket-card::before, .ticket-card::after {
            content: ""; position: absolute; top: 125px; width: 30px; height: 30px; background: #f8fafc; border-radius: 50%; z-index: 10;
        }
        .ticket-card::before { left: -15px; box-shadow: inset -3px 0 5px rgba(0,0,0,0.05); }
        .ticket-card::after { right: -15px; box-shadow: inset 3px 0 5px rgba(0,0,0,0.05); }

        .ticket-details-box { background: #f8fafc; border-radius: 10px; padding: 15px; text-align: left; margin-top: 20px; }
        
        /* --- MOBILE ADJUSTMENTS --- */
        @media (max-width: 991px) {
            .brand-section { display: none !important; } /* Fully hide left side */
            .mobile-logo { display: block; } /* Show logo on top */
            .form-section { padding: 20px; background: white; align-items: flex-start; }
            .form-container { padding: 10px; margin-top: 20px; }
        }

        /* --- PRINT MODE (Magic happens here) --- */
        @media print {
            body * {
                visibility: hidden; /* Hide everything */
            }
            #printableArea, #printableArea * {
                visibility: visible; /* Show only ticket */
            }
            #printableArea {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                margin: 0;
                padding: 0;
                border: 2px solid #000;
                box-shadow: none;
            }
            /* Hide the background circles in print to look cleaner */
            .ticket-card::before, .ticket-card::after { display: none; }
            
            /* Force Background Colors */
            .ticket-header { -webkit-print-color-adjust: exact; print-color-adjust: exact; background-color: #1d4ed8 !important; }
            .badge { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            
            /* Hide Buttons */
            .no-print { display: none !important; }
        }
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
                <h1 class="display-5 fw-bold mb-3">Seamless Events.</h1>
                <p class="lead opacity-75 mb-5">Secure your spot instantly. Get your digital pass in seconds and skip the queue.</p>
                <div class="d-flex gap-4 opacity-75 small fw-bold text-uppercase letter-spacing-1">
                    <span><i class="fas fa-check-circle me-2"></i>Instant Ticket</span>
                    <span><i class="fas fa-shield-alt me-2"></i>Secure</span>
                </div>
            </div>
        </div>

        <div class="col-lg-7 form-section">
            <div class="form-container">
                
                <div class="mobile-logo">
                    <img src="assets/logos/EventlyLogo-removebg.png" alt="Evently Logo">
                </div>

                <div id="registration-view">
                    <div class="mb-4">
                        <h2 class="fw-bold text-dark">Get Your Ticket</h2>
                        <p class="text-muted">Fill in your details to reserve your spot.</p>
                    </div>

                    <div id="error-alert" class="alert alert-danger d-none border-0 bg-danger bg-opacity-10 text-danger small rounded-3">
                        <i class="fas fa-exclamation-circle me-2"></i> <span id="error-msg">Error</span>
                    </div>

                    <form id="regForm" novalidate>
                        <div class="form-floating mb-3">
                            <select id="eventSelect" class="form-select" required>
                                <option value="" selected disabled>Loading events...</option>
                            </select>
                            <label for="eventSelect">Select Event</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" id="name" class="form-control" placeholder="Full Name" required>
                            <label for="name">Full Name</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="email" id="email" class="form-control" placeholder="Email Address" required>
                            <label for="email">Email Address</label>
                        </div>
                        <div class="form-floating mb-4">
                            <input type="number" id="phone" class="form-control" placeholder="Phone" required>
                            <label for="phone">Phone Number (10 Digits)</label>
                        </div>
                        <div class="mb-4">
                            <label class="form-label text-muted small fw-bold text-uppercase">Security Check</label>
                            <div class="captcha-wrapper">
                                <div class="captcha-display" id="captcha-question">...</div>
                                <input type="number" class="form-control captcha-input" id="captcha-input" placeholder="?" required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-register w-100 shadow-lg">
                            CONFIRM REGISTRATION <i class="fas fa-arrow-right ms-2"></i>
                        </button>
                    </form>
                </div>

                <div id="ticket-result">
                    <div class="text-center mb-4 no-print">
                        <div class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill mb-3">
                            <i class="fas fa-check-circle me-1"></i> Registration Confirmed
                        </div>
                        <h3 class="fw-bold">You're going to <span id="success-event-name" class="text-primary">Event</span>!</h3>
                        <p class="text-muted">Please save your ticket below.</p>
                    </div>

                    <div class="ticket-card" id="printableArea">
                        <div class="ticket-header">
                            <h5 class="mb-0 fw-bold letter-spacing-1">EVENTLY PASS</h5>
                        </div>
                        <div class="ticket-body">
                            <div id="qrcode" class="d-flex justify-content-center mb-3"></div>
                            
                            <h5 class="fw-bold text-dark mb-1" id="ticket-attendee">Name</h5>
                            <code class="text-muted bg-light px-2 rounded" id="ticket-id">ID: ...</code>

                            <div class="ticket-details-box">
                                <div class="row g-2">
                                    <div class="col-6">
                                        <small class="text-muted d-block text-uppercase" style="font-size: 10px;">Event</small>
                                        <span class="fw-bold text-dark small" id="ticket-event">...</span>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted d-block text-uppercase" style="font-size: 10px;">Date</small>
                                        <span class="fw-bold text-dark small" id="ticket-date">...</span>
                                    </div>
                                    <div class="col-6 mt-2">
                                        <small class="text-muted d-block text-uppercase" style="font-size: 10px;">Venue</small>
                                        <span class="fw-bold text-dark small" id="ticket-venue">...</span>
                                    </div>
                                    <div class="col-6 mt-2">
                                        <small class="text-muted d-block text-uppercase" style="font-size: 10px;">Status</small>
                                        <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25">Confirmed</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2 mt-4 no-print">
                        <button class="btn btn-dark py-3 fw-bold rounded-3" onclick="window.print()">
                            <i class="fas fa-print me-2"></i> Download / Print Ticket
                        </button>
                        <button class="btn btn-light py-3 text-muted fw-bold rounded-3" onclick="location.reload()">
                            Register Another Person
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

<script type="module">
    import { db, collection, addDoc, getDocs, query, orderBy, where } from "./firebase-config.js";

    let captchaAnswer = 0;
    let eventsMap = {}; 

    // 1. Init Captcha
    function generateCaptcha() {
        const n1 = Math.floor(Math.random() * 10) + 1;
        const n2 = Math.floor(Math.random() * 10) + 1;
        captchaAnswer = n1 + n2;
        $("#captcha-question").text(`${n1} + ${n2} =`);
        $("#captcha-input").val("");
    }
    generateCaptcha();

    // 2. Load Events
    async function loadEvents() {
        const select = $("#eventSelect");
        try {
            const q = query(collection(db, "events"), orderBy("timestamp", "desc"));
            const snapshot = await getDocs(q);
            
            if(snapshot.empty) {
                select.html('<option disabled selected>No active events</option>');
                return;
            }

            select.empty().append('<option value="" selected disabled>Choose an Event...</option>');
            snapshot.forEach(doc => {
                const data = doc.data();
                eventsMap[doc.id] = { name: data.name, date: data.date, venue: data.venue };
                select.append(`<option value="${doc.id}">${data.name}</option>`);
            });
        } catch (e) {
            console.error(e);
            select.html('<option>Error loading events</option>');
        }
    }
    loadEvents();

    // 3. Handle Submit
    $("#regForm").submit(async function(e) {
        e.preventDefault();
        
        const btn = $("button[type='submit']");
        const eventId = $("#eventSelect").val();
        const name = $("#name").val().trim();
        const email = $("#email").val().trim();
        const phone = $("#phone").val().trim();
        const userCaptcha = parseInt($("#captcha-input").val());
        const alertBox = $("#error-alert");
        const msg = $("#error-msg");

        const showError = (text) => {
            msg.text(text);
            alertBox.removeClass("d-none");
            btn.html('CONFIRM REGISTRATION <i class="fas fa-arrow-right ms-2"></i>').prop("disabled", false);
            generateCaptcha(); 
        };

        alertBox.addClass("d-none");
        btn.html('<span class="spinner-border spinner-border-sm me-2"></span>Processing...').prop("disabled", true);

        // --- VALIDATIONS ---
        if(!eventId) return showError("Please select an event.");
        if(name.length < 3) return showError("Please enter a valid full name.");
        
        const phoneRegex = /^\d{10}$/;
        if(!phoneRegex.test(phone)) return showError("Phone number must be exactly 10 digits.");

        if(userCaptcha !== captchaAnswer) return showError("Incorrect security answer.");

        try {
            // --- DUPLICATE CHECK ---
            const dupQuery = query(
                collection(db, "attendees"), 
                where("event_id", "==", eventId),
                where("email", "==", email)
            );
            
            const dupSnapshot = await getDocs(dupQuery);
            if(!dupSnapshot.empty) {
                return showError("This email is already registered for this event.");
            }

            // --- SAVE TO DB ---
            const eventDetails = eventsMap[eventId];
            const docRef = await addDoc(collection(db, "attendees"), {
                name: name,
                email: email,
                phone: phone,
                event_id: eventId,
                event_name: eventDetails.name,
                status: "registered",
                timestamp: new Date()
            });

            // --- SEND EMAIL (NEW FEATURE) ---
            // We do this silently in the background
            fetch("send_email.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({
                    name: name,
                    email: email,
                    event_name: eventDetails.name,
                    date: eventDetails.date || "TBA",
                    venue: eventDetails.venue || "TBA",
                    ticket_id: docRef.id
                })
            }).then(response => {
                console.log("Email sent signal fired.");
            }).catch(err => console.error("Email failed:", err));


            // --- SHOW SUCCESS TICKET ---
            $("#registration-view").slideUp(); 
            $("#ticket-result").fadeIn();      

            $("#success-event-name").text(eventDetails.name);
            $("#ticket-attendee").text(name);
            $("#ticket-id").text("ID: " + docRef.id);
            $("#ticket-event").text(eventDetails.name);
            $("#ticket-date").text(eventDetails.date || "TBA");
            $("#ticket-venue").text(eventDetails.venue || "TBA");

            // QR Code (Blue)
            new QRCode(document.getElementById("qrcode"), {
                text: docRef.id,
                width: 160,
                height: 160,
                colorDark : "#1d4ed8", 
                colorLight : "#ffffff",
                correctLevel : QRCode.CorrectLevel.H
            });

        } catch (error) {
            console.error(error);
            showError("System error. Please try again later.");
        }
    });
</script>

</body>
</html>