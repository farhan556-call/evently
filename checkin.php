<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Gate Entry Manager</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f4f6f9; }

        /* --- LAYOUT FIXES --- */
        .main-content-wrapper {
            width: auto !important;
            max-width: 100%;
            padding: 30px;
        }

        /* Scan Box Styling */
        .scan-box { 
            background: white; 
            padding: 40px; 
            border-radius: 16px; 
            box-shadow: 0 4px 20px rgba(0,0,0,0.03); 
            text-align: center; 
            border: 1px solid rgba(0,0,0,0.05);
            height: 100%;
        }
        
        .form-control-lg { 
            font-size: 1.5rem; 
            text-align: center; 
            letter-spacing: 2px; 
            border: 2px solid #e5e7eb; 
            border-radius: 12px; 
            height: 70px; 
            font-weight: 600;
        }
        .form-control-lg:focus { 
            border-color: #3498db; 
            box-shadow: 0 0 0 4px rgba(52, 152, 219, 0.1); 
        }
        
        /* History Card */
        .history-card { 
            border: none; 
            border-radius: 16px; 
            box-shadow: 0 4px 20px rgba(0,0,0,0.03); 
            overflow: hidden; 
            background: white; 
            height: 100%;
        }
        .table thead th { 
            background: #f9fafb; 
            font-size: 0.75rem; 
            text-transform: uppercase; 
            color: #6b7280; 
            font-weight: 700;
            padding: 15px;
            letter-spacing: 0.5px;
        }
        .table tbody td {
            vertical-align: middle;
            padding: 15px;
            border-bottom: 1px solid #f3f4f6;
        }
    </style>
</head>
<body>

    <?php include 'sidebar.php'; ?>

    <div class="main-content-wrapper">
        <div class="container-fluid p-0">

            <div class="d-flex justify-content-between align-items-center mb-4 mt-2">
                <div>
                    <h2 class="fw-bold text-dark mb-1">Entry Gate Console</h2>
                    <p class="text-muted mb-0">Scan QR codes or enter Ticket IDs</p>
                </div>
                <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill border border-success border-opacity-25">
                    <i class="fas fa-wifi me-1"></i> System Online
                </span>
            </div>

            <div class="row g-4">
                <div class="col-lg-7">
                    <div class="scan-box d-flex flex-column justify-content-center">
                        <div class="mb-4">
                            <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                                <i class="fas fa-barcode fa-3x text-secondary"></i>
                            </div>
                            <h4 class="fw-bold text-dark">Scan Ticket</h4>
                            <p class="text-muted small">Ensure the cursor is in the box below</p>
                        </div>
                        
                        <form id="checkinForm">
                            <div class="mb-4">
                                <input type="text" id="ticket-input" class="form-control form-control-lg text-uppercase" placeholder="Ready to Scan..." autofocus autocomplete="off">
                            </div>
                            <button type="submit" class="btn btn-primary w-100 py-3 fw-bold rounded-3 shadow-sm">
                                <i class="fas fa-check me-2"></i> VERIFY ENTRY
                            </button>
                        </form>
                        
                        <div id="quick-result" class="mt-4 p-3 rounded-3" style="display:none;"></div>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="card history-card">
                        <div class="card-header bg-white py-3 border-bottom px-4">
                            <h6 class="mb-0 fw-bold text-dark"><i class="fas fa-history me-2 text-primary"></i> Live Scan History</h6>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th class="ps-4">Time</th>
                                            <th>Name</th>
                                            <th class="pe-4">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody id="scan-history">
                                        <tr><td colspan="3" class="text-center py-5 text-muted small"><span class="spinner-border spinner-border-sm me-2"></span>Connecting to feed...</td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script type="module">
        import { db, auth, onAuthStateChanged, signOut, doc, updateDoc, getDoc, collection, query, where, orderBy, limit, onSnapshot } from "./firebase-config.js";

        // 1. Auth & Sidebar Logic
        onAuthStateChanged(auth, (user) => {
            if (!user) {
                window.location.href = "login.php";
            } else {
                const emailEl = document.getElementById("sidebar-email");
                if(emailEl) {
                    emailEl.innerText = user.email;
                    emailEl.title = user.email;
                }
            }
        });

        window.logoutApp = () => {
            signOut(auth).then(() => window.location.href = "login.php");
        };

        // 2. LIVE HISTORY FEED (With Date DD/MM/YYYY)
        const historyQuery = query(
            collection(db, "attendees"), 
            where("status", "==", "checked-in"),
            orderBy("checkInTime", "desc"),
            limit(5)
        );

        onSnapshot(historyQuery, 
            (snapshot) => {
                let historyRows = "";
                
                if (snapshot.empty) {
                    $("#scan-history").html('<tr><td colspan="3" class="text-center py-5 text-muted small">No scans yet today.</td></tr>');
                    return;
                }

                snapshot.forEach((doc) => {
                    const data = doc.data();
                    
                    // Safe Date Formatting
                    let dateTimeString = "Just now";
                    if(data.checkInTime && data.checkInTime.toDate) {
                        const jsDate = data.checkInTime.toDate();
                        
                        const day = String(jsDate.getDate()).padStart(2, '0');
                        const month = String(jsDate.getMonth() + 1).padStart(2, '0');
                        const year = jsDate.getFullYear();
                        const formattedDate = `${day}/${month}/${year}`;
                        
                        const formattedTime = jsDate.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                        
                        dateTimeString = `<span class="fw-bold text-dark">${formattedDate}</span><br><small class="text-muted">${formattedTime}</small>`;
                    }

                    historyRows += `
                        <tr>
                            <td class="ps-4" style="line-height: 1.2;">${dateTimeString}</td>
                            <td class="fw-bold text-dark">${data.name}</td>
                            <td class="pe-4"><span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3">Inside</span></td>
                        </tr>
                    `;
                });

                $("#scan-history").html(historyRows);
            },
            // Error Handler for "Missing Index"
            (error) => {
                console.error("History Error:", error);
                if (error.message.includes("index")) {
                    const urlMatch = error.message.match(/https:\/\/[^\s]+/);
                    const link = urlMatch ? urlMatch[0] : "https://console.firebase.google.com";

                    $("#scan-history").html(`
                        <tr>
                            <td colspan="3" class="text-center py-4 text-danger">
                                <strong>⚠️ Database Index Missing</strong><br>
                                <a href="${link}" target="_blank" class="btn btn-sm btn-danger mt-2">
                                    Click Here to Create Index
                                </a>
                            </td>
                        </tr>
                    `);
                } else {
                    $("#scan-history").html('<tr><td colspan="3" class="text-center py-4 text-danger">Error loading history. Check console.</td></tr>');
                }
            }
        );

        // 3. SCANNING LOGIC
        $("#checkinForm").submit(async function(e) {
            e.preventDefault();
            
            const input = $("#ticket-input");
            const id = input.val().trim();
            const btn = $("button[type='submit']");
            
            if(!id) return;

            btn.prop("disabled", true).html('<span class="spinner-border spinner-border-sm me-2"></span>Verifying...');
            
            try {
                const docRef = doc(db, "attendees", id);
                const docSnap = await getDoc(docRef);

                if (docSnap.exists()) {
                    const data = docSnap.data();

                    if (data.status === "checked-in") {
                        // DUPLICATE ENTRY
                        showResult("warning", "DUPLICATE ENTRY", `${data.name} is already inside.`);
                        Swal.fire({ 
                            icon: 'warning', 
                            title: 'Stop!', 
                            text: 'Ticket was already scanned.',
                            timer: 1500, 
                            showConfirmButton: false 
                        });
                    } else {
                        // SUCCESS ENTRY
                        await updateDoc(docRef, {
                            status: "checked-in",
                            checkInTime: new Date()
                        });
                        showResult("success", "ACCESS GRANTED", `Welcome, ${data.name}!`);
                        Swal.fire({ 
                            icon: 'success', 
                            title: 'Welcome', 
                            text: data.name,
                            timer: 1500, 
                            showConfirmButton: false 
                        });
                    }
                } else {
                    // INVALID ID
                    showResult("danger", "INVALID TICKET", "ID not found in database.");
                    Swal.fire({ 
                        icon: 'error', 
                        title: 'Declined', 
                        text: 'Invalid Ticket ID', 
                        timer: 1500, 
                        showConfirmButton: false 
                    });
                }

            } catch (error) {
                console.error("Scan Error:", error);
                showResult("danger", "ERROR", "System connection failed.");
            }

            // Reset UI
            btn.prop("disabled", false).html('<i class="fas fa-check me-2"></i> VERIFY ENTRY');
            input.val("").focus();
        });

        function showResult(type, title, msg) {
            const box = $("#quick-result");
            // Mapping bootstrap colors
            const bgClass = type === 'danger' ? 'bg-danger' : (type === 'warning' ? 'bg-warning' : 'bg-success');
            const textClass = type === 'danger' ? 'text-danger' : (type === 'warning' ? 'text-warning' : 'text-success');
            const borderClass = type === 'danger' ? 'border-danger' : (type === 'warning' ? 'border-warning' : 'border-success');

            box.removeClass().addClass(`mt-4 p-3 rounded-3 ${bgClass} bg-opacity-10 border ${borderClass} border-opacity-25`);
            box.html(`
                <h5 class="fw-bold ${textClass} mb-1">${title}</h5>
                <p class="mb-0 ${textClass} small">${msg}</p>
            `).fadeIn();
        }
    </script>

</body>
</html>