<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Organizer Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f4f6f9; }
        
        /* Layout Fixes */
        .main-content-wrapper {
            width: auto !important;
            max-width: 100%;
            padding: 30px;
        }

        /* Stats Cards */
        .stat-card {
            background: white;
            border-radius: 16px;
            border: none;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            transition: all 0.3s ease;
            height: 100%;
            position: relative;
            overflow: hidden;
        }
        .stat-card:hover { transform: translateY(-5px); box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); }
        
        .icon-box {
            width: 50px; height: 50px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.25rem;
        }
        
        /* Table Styles */
        .table-card {
            background: white;
            border-radius: 16px;
            border: none;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .table thead th {
            background-color: #f8fafc;
            color: #64748b;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
            padding: 16px 24px;
            border-bottom: 1px solid #e2e8f0;
        }
        .table tbody td {
            padding: 16px 24px;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
        }

        /* Event Filter Select */
        .event-filter-select {
            background-color: white;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 8px 12px;
            font-weight: 600;
            color: #1e293b;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            min-width: 200px;
            cursor: pointer;
        }
        .event-filter-select:focus {
            border-color: #3b82f6;
            outline: none;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
    </style>
</head>
<body>

    <?php include 'sidebar.php'; ?>

    <div class="main-content-wrapper">
        <div class="container-fluid p-0">
            
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5 mt-2 gap-3">
                <div>
                    <h2 class="fw-bold text-dark mb-1">Dashboard Overview</h2>
                    <p class="text-muted mb-0">Live data monitoring</p>
                </div>
                
                <div class="d-flex align-items-center gap-3">
                    <select id="dashboardEventFilter" class="form-select event-filter-select">
                        <option value="all">Show All Events</option>
                        <option disabled>Loading...</option>
                    </select>

                    <span class="badge bg-white text-success px-3 py-2 border rounded-pill d-flex align-items-center shadow-sm">
                        <span class="spinner-grow spinner-grow-sm me-2" role="status" aria-hidden="true"></span>
                        Live
                    </span>
                </div>
            </div>

            <div class="row g-4 mb-5">
                <div class="col-md-4">
                    <div class="stat-card p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-uppercase text-muted fw-bold small mb-2">Total Registrations</h6>
                                <h1 class="fw-bold text-dark mb-0 display-6" id="total-count">0</h1>
                            </div>
                            <div class="icon-box bg-primary bg-opacity-10 text-primary">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="stat-card p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-uppercase text-muted fw-bold small mb-2">Checked In</h6>
                                <h1 class="fw-bold text-success mb-0 display-6" id="checkin-count">0</h1>
                            </div>
                            <div class="icon-box bg-success bg-opacity-10 text-success">
                                <i class="fas fa-check-circle"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="stat-card p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-uppercase text-muted fw-bold small mb-2">Pending Arrival</h6>
                                <h1 class="fw-bold text-secondary mb-0 display-6" id="pending-count">0</h1>
                            </div>
                            <div class="icon-box bg-secondary bg-opacity-10 text-secondary">
                                <i class="fas fa-clock"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card table-card">
                <div class="card-header bg-white py-4 px-4 border-bottom d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-dark">Recent Activity (Last 10)</h5>
                    <a href="registrations.php" class="btn btn-sm btn-outline-primary px-3 rounded-pill">View All Data</a>
                </div>
                <div class="table-responsive">
                    <table class="table mb-0 align-middle">
                        <thead>
                            <tr>
                                <th>Name / Event</th>
                                <th>Ticket ID</th>
                                <th>Phone</th>
                                <th class="text-end">Status</th>
                            </tr>
                        </thead>
                        <tbody id="attendee-list">
                            <tr><td colspan="4" class="text-center py-5 text-muted">Loading live data...</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <script type="module">
        import { db, auth, onAuthStateChanged, signOut, collection, onSnapshot, query, orderBy, limit, where, getDocs } from "./firebase-config.js";

        let currentUnsubscribe = null; // To manage switching listeners

        // 1. Auth Check
        onAuthStateChanged(auth, (user) => {
            if (!user) {
                window.location.href = "login.php";
            } else {
                const emailEl = document.getElementById("sidebar-email");
                if(emailEl) emailEl.innerText = user.email;
            }
        });

        window.logoutApp = () => {
            signOut(auth).then(() => window.location.href = "login.php");
        };

        // 2. Load Filter Dropdown
        async function loadEventFilter() {
            try {
                const q = query(collection(db, "events"), orderBy("timestamp", "desc"));
                const snapshot = await getDocs(q);
                const filter = document.getElementById("dashboardEventFilter");
                
                // Keep the 'All' option, remove 'Loading...'
                filter.innerHTML = '<option value="all">Show All Events</option>';
                
                snapshot.forEach(doc => {
                    const option = document.createElement("option");
                    option.value = doc.id;
                    option.text = doc.data().name;
                    filter.appendChild(option);
                });

                // Add listener
                filter.addEventListener("change", (e) => loadDashboardData(e.target.value));

            } catch (e) {
                console.error("Error loading events filter", e);
            }
        }
        
        loadEventFilter();

        // 3. Main Dashboard Logic
        function loadDashboardData(eventId) {
            // Unsubscribe from previous listener to avoid memory leaks/double updates
            if (currentUnsubscribe) currentUnsubscribe();

            // Build Query
            let q;
            if (eventId === "all") {
                q = query(collection(db, "attendees"), orderBy("timestamp", "desc"), limit(10));
            } else {
                q = query(collection(db, "attendees"), where("event_id", "==", eventId), orderBy("timestamp", "desc"), limit(10));
            }

            // Start Listener
            currentUnsubscribe = onSnapshot(q, 
                (snapshot) => {
                    let rows = "";
                    
                    snapshot.forEach((doc) => {
                        const data = doc.data();
                        
                        const statusBadge = data.status === "checked-in" 
                            ? '<span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3">Inside</span>' 
                            : '<span class="badge bg-secondary bg-opacity-10 text-dark rounded-pill px-3">Pending</span>';

                        const eventNameDisplay = data.event_name ? `<br><small class="text-muted fw-normal"><i class="fas fa-tag me-1 text-primary small"></i>${data.event_name}</small>` : '';

                        rows += `
                            <tr>
                                <td>
                                    <div class="fw-bold text-dark">${data.name}</div>
                                    ${eventNameDisplay}
                                </td>
                                <td><code class="text-primary bg-light px-2 py-1 rounded border small">${doc.id}</code></td>
                                <td class="text-muted">${data.phone}</td>
                                <td class="text-end">${statusBadge}</td>
                            </tr>
                        `;
                    });

                    document.getElementById("attendee-list").innerHTML = rows || '<tr><td colspan="4" class="text-center py-5 text-muted">No activity found for this selection.</td></tr>';
                    
                    // Trigger Stats Update
                    updateStats(eventId);
                }, 
                // Error Handler for "Missing Index"
                (error) => {
                    console.error(error);
                    if (error.message.includes("index")) {
                        const urlMatch = error.message.match(/https:\/\/[^\s]+/);
                        const link = urlMatch ? urlMatch[0] : "https://console.firebase.google.com";
                        document.getElementById("attendee-list").innerHTML = `<tr><td colspan="4" class="text-center py-4 text-danger fw-bold">⚠️ Missing Index. <a href="${link}" target="_blank" class="btn btn-sm btn-danger ms-2">Click to Fix</a></td></tr>`;
                    }
                }
            );
        }

        // 4. Update Global Counters
        async function updateStats(eventId) {
            let q;
            if (eventId === "all") {
                q = query(collection(db, "attendees"));
            } else {
                q = query(collection(db, "attendees"), where("event_id", "==", eventId));
            }

            const snapshot = await getDocs(q);
            let total = 0;
            let checked = 0;

            snapshot.forEach(doc => {
                total++;
                if (doc.data().status === 'checked-in') checked++;
            });

            // Animate numbers lightly? (Simple text update for now)
            document.getElementById("total-count").innerText = total;
            document.getElementById("checkin-count").innerText = checked;
            document.getElementById("pending-count").innerText = total - checked;
        }

        // Initialize
        loadDashboardData("all");

    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>