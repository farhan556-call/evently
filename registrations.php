<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registration Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.bootstrap5.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #f4f6f9; }

        /* --- LAYOUT FIXES (Same as Dashboard) --- */
        .main-content-wrapper {
            width: auto !important;
            max-width: 100%;
            padding: 30px;
        }

        .card { border-radius: 12px; border: none; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }

        /* DataTables Customization */
        .dt-buttons .btn { background: #2c3e50; color: white; border-radius: 5px; font-size: 0.85rem; margin-right: 5px; border: none; }
        .dt-buttons .btn:hover { background: #1a252f; }
        .dataTables_filter input { border-radius: 20px; padding: 5px 15px; border: 1px solid #ddd; outline: none; }
        .dataTables_filter input:focus { border-color: #3498db; box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25); }

        /* Status Badges */
        .status-badge-inside {
            background-color: #dcfce7;
            color: #166534;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8em;
            font-weight: 600;
        }
        .status-badge-pending {
            background-color: #f3f4f6;
            color: #4b5563;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8em;
            font-weight: 600;
        }
        
        /* Modal QR */
        #qrcode img { margin: 0 auto; display: block; }
        
        /* Filter Select Style */
        .event-filter-select {
            border-radius: 20px;
            padding: 8px 15px;
            border: 1px solid #ced4da;
            font-size: 0.9rem;
            min-width: 200px;
            margin-right: 10px;
            cursor: pointer;
        }
    </style>
</head>
<body>

    <?php include 'sidebar.php'; ?>

    <div class="main-content-wrapper">
        <div class="container-fluid p-0">
            
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 mt-2 gap-3">
                <div>
                    <h2 class="fw-bold text-dark mb-1">Registration Database</h2>
                    <p class="text-muted mb-0">Manage all event attendees</p>
                </div>
                
                <div class="d-flex align-items-center">
                    <select id="regEventFilter" class="form-select event-filter-select shadow-sm">
                        <option value="all">Show All Events</option>
                        <option disabled>Loading events...</option>
                    </select>

                    <a href="index.php" target="_blank" class="btn btn-primary rounded-pill px-4 shadow-sm text-nowrap">
                        <i class="fas fa-plus me-2"></i> New Registration
                    </a>
                </div>
            </div>

            <div class="card p-4">
                <table id="attendeesTable" class="table table-striped table-hover align-middle" style="width:100%">
                    <thead class="table-dark">
                        <tr>
                            <th class="py-3">Name / Event</th>
                            <th class="py-3">Email</th>
                            <th class="py-3">Phone</th>
                            <th class="py-3">Status</th>
                            <th class="py-3">Reg. Date</th>
                            <th class="py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>

        </div>
    </div>

    <div class="modal fade" id="viewModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title fw-bold"><i class="fas fa-ticket-alt me-2"></i> Attendee Ticket</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center p-4">
                    <h3 id="modal-name" class="fw-bold text-dark mb-0">...</h3>
                    <p id="modal-id" class="text-muted font-monospace small mb-4">...</p>
                    
                    <div class="p-4 bg-light rounded-3 mb-4 border d-inline-block shadow-sm">
                        <div id="qrcode"></div>
                    </div>

                    <div class="text-start px-3 py-3 bg-light rounded border">
                        <div class="d-flex justify-content-between mb-2 border-bottom pb-2">
                            <strong class="text-muted">Email:</strong>
                            <span id="modal-email" class="text-dark fw-bold"></span>
                        </div>
                        <div class="d-flex justify-content-between mb-2 border-bottom pb-2">
                            <strong class="text-muted">Phone:</strong>
                            <span id="modal-phone" class="text-dark fw-bold"></span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <strong class="text-muted">Status:</strong>
                            <span id="modal-status" class="fw-bold"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="window.print()">
                        <i class="fas fa-print me-2"></i> Print Ticket
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

    <script type="module">
        import { db, auth, onAuthStateChanged, signOut, collection, getDocs, deleteDoc, doc, query, orderBy, where } from "./firebase-config.js";

        // Auth & Sidebar Update
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

        let table;

        // 1. Load Events into Filter Dropdown
        async function loadEventFilter() {
            try {
                const q = query(collection(db, "events"), orderBy("timestamp", "desc"));
                const snapshot = await getDocs(q);
                const filter = document.getElementById("regEventFilter");
                
                // Keep 'All' option
                filter.innerHTML = '<option value="all">Show All Events</option>';
                
                snapshot.forEach(doc => {
                    const option = document.createElement("option");
                    option.value = doc.id;
                    option.text = doc.data().name;
                    filter.appendChild(option);
                });

                // Add listener
                filter.addEventListener("change", (e) => loadData(e.target.value));

            } catch (e) {
                console.error("Error loading events filter", e);
            }
        }
        
        loadEventFilter(); // Call on load

        // 2. Load Data Function (With Filter Logic)
        async function loadData(eventId = "all") {
            Swal.fire({ title: 'Loading Database...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });

            try {
                // Determine Query
                let q;
                if (eventId === "all") {
                    q = query(collection(db, "attendees"), orderBy("timestamp", "desc"));
                } else {
                    q = query(collection(db, "attendees"), where("event_id", "==", eventId), orderBy("timestamp", "desc"));
                }

                const querySnapshot = await getDocs(q);
                let rows = [];

                querySnapshot.forEach((docSnap) => {
                    const data = docSnap.data();
                    const id = docSnap.id;
                    
                    // Date Formatting
                    let dateStr = "N/A";
                    if(data.timestamp) {
                        const d = new Date(data.timestamp.seconds * 1000);
                        dateStr = d.toLocaleDateString() + " <small class='text-muted'>" + d.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'}) + "</small>";
                    }

                    // Badge Logic
                    const statusBadge = data.status === "checked-in" 
                        ? `<span class='status-badge-inside'><i class="fas fa-check me-1"></i> Inside</span>` 
                        : `<span class='status-badge-pending'>Registered</span>`;
                    
                    // Event Name Tag (if showing all events)
                    let nameDisplay = `<span class="fw-bold text-dark">${data.name}</span>`;
                    if (eventId === "all" && data.event_name) {
                         nameDisplay += `<br><small class="text-muted"><i class="fas fa-tag me-1 text-primary small"></i>${data.event_name}</small>`;
                    }

                    rows.push([
                        nameDisplay,
                        data.email,
                        data.phone,
                        statusBadge,
                        dateStr,
                        `<button class="btn btn-sm btn-info text-white view-btn me-1" title="View Ticket" data-id="${id}" data-name="${data.name}" data-email="${data.email}" data-phone="${data.phone}" data-status="${data.status}"><i class="fas fa-eye"></i></button>
                         <button class="btn btn-sm btn-danger delete-btn" title="Delete" data-id="${id}"><i class="fas fa-trash"></i></button>`
                    ]);
                });

                if ($.fn.DataTable.isDataTable('#attendeesTable')) {
                    $('#attendeesTable').DataTable().destroy();
                }

                table = $('#attendeesTable').DataTable({
                    data: rows,
                    dom: 'Bfrtip',
                    buttons: [
                        { extend: 'csv', className: 'btn btn-dark shadow-sm', text: '<i class="fas fa-file-csv me-1"></i> CSV' },
                        { extend: 'pdf', className: 'btn btn-dark shadow-sm', text: '<i class="fas fa-file-pdf me-1"></i> PDF' },
                        { extend: 'print', className: 'btn btn-dark shadow-sm', text: '<i class="fas fa-print me-1"></i> Print' }
                    ],
                    order: [], // Use Firestore order
                    pageLength: 25,
                    language: { search: "_INPUT_", searchPlaceholder: "Search attendees..." }
                });

                Swal.close();

            } catch (error) {
                console.error(error);
                // Handle missing index specifically
                if(error.message.includes("index")) {
                    const urlMatch = error.message.match(/https:\/\/[^\s]+/);
                    const link = urlMatch ? urlMatch[0] : "#";
                    Swal.fire({
                        icon: 'error',
                        title: 'Missing Index',
                        html: `Please create the required index in Firebase.<br><a href="${link}" target="_blank" class="btn btn-danger mt-2">Create Index</a>`
                    });
                } else {
                    Swal.fire("Error", "Failed to load data.", "error");
                }
            }
        }

        // View Button
        $(document).on('click', '.view-btn', function() {
            const btn = $(this);
            $("#modal-name").text(btn.data('name'));
            $("#modal-email").text(btn.data('email'));
            $("#modal-phone").text(btn.data('phone'));
            $("#modal-id").text(btn.data('id'));
            
            const status = btn.data('status');
            const statusHtml = status === 'checked-in' 
                ? '<span class="text-success"><i class="fas fa-check-circle"></i> Inside Event</span>' 
                : '<span class="text-warning"><i class="fas fa-clock"></i> Pending Arrival</span>';
            $("#modal-status").html(statusHtml);
            
            $("#qrcode").empty();
            new QRCode(document.getElementById("qrcode"), {
                text: btn.data('id'),
                width: 140,
                height: 140
            });

            new bootstrap.Modal(document.getElementById('viewModal')).show();
        });

        // Delete Button
        $(document).on('click', '.delete-btn', function() {
            const id = $(this).data('id');
            const row = $(this).parents('tr');

            Swal.fire({
                title: 'Are you sure?',
                text: "This action cannot be undone!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                confirmButtonText: 'Yes, Delete it'
            }).then(async (result) => {
                if (result.isConfirmed) {
                    try {
                        await deleteDoc(doc(db, "attendees", id));
                        table.row(row).remove().draw();
                        Swal.fire('Deleted!', 'Record removed.', 'success');
                    } catch (e) {
                        Swal.fire('Error', 'Permission Denied.', 'error');
                    }
                }
            });
        });

        // Initial Load (Show All)
        loadData("all");
    </script>

</body>
</html>