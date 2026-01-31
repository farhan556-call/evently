<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Event Manager</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f4f6f9; }
        .main-content-wrapper { width: auto !important; max-width: 100%; padding: 30px; }
        .card { border: none; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
    </style>
</head>
<body>

    <?php include 'sidebar.php'; ?>

    <div class="main-content-wrapper">
        <div class="container-fluid p-0">
            <h2 class="fw-bold text-dark mb-4">Event Manager</h2>

            <div class="row">
                <div class="col-md-4">
                    <div class="card p-4 mb-4">
                        <h5 class="fw-bold mb-3">Create New Event</h5>
                        <form id="createEventForm">
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted">EVENT NAME</label>
                                <input type="text" id="eventName" class="form-control" placeholder="e.g. Summer Music Fest" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted">DATE</label>
                                <input type="date" id="eventDate" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted">VENUE</label>
                                <input type="text" id="eventVenue" class="form-control" placeholder="e.g. Grand Hall" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-plus-circle me-2"></i> Create Event
                            </button>
                        </form>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="card p-4">
                        <h5 class="fw-bold mb-3">Active Events</h5>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Name</th>
                                        <th>Date</th>
                                        <th>Venue</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="eventsList">
                                    <tr><td colspan="4" class="text-center py-4">Loading events...</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script type="module">
        import { db, auth, onAuthStateChanged, signOut, collection, addDoc, onSnapshot, deleteDoc, doc, query, orderBy } from "./firebase-config.js";

        // Auth Check
        onAuthStateChanged(auth, (user) => {
            if (!user) window.location.href = "login.php";
        });

        // 1. CREATE EVENT
        $("#createEventForm").submit(async function(e) {
            e.preventDefault();
            const btn = $(this).find("button");
            btn.prop("disabled", true).text("Creating...");

            try {
                await addDoc(collection(db, "events"), {
                    name: $("#eventName").val(),
                    date: $("#eventDate").val(),
                    venue: $("#eventVenue").val(),
                    timestamp: new Date()
                });
                
                Swal.fire("Success", "Event Created!", "success");
                $("#createEventForm")[0].reset();
            } catch (error) {
                console.error(error);
                Swal.fire("Error", "Could not create event.", "error");
            }
            btn.prop("disabled", false).html('<i class="fas fa-plus-circle me-2"></i> Create Event');
        });

        // 2. LIST EVENTS
        const q = query(collection(db, "events"), orderBy("timestamp", "desc"));
        onSnapshot(q, (snapshot) => {
            let html = "";
            snapshot.forEach((doc) => {
                const data = doc.data();
                html += `
                    <tr>
                        <td class="fw-bold">${data.name}</td>
                        <td>${data.date}</td>
                        <td>${data.venue}</td>
                        <td>
                            <button class="btn btn-sm btn-outline-danger delete-btn" data-id="${doc.id}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;
            });
            $("#eventsList").html(html || '<tr><td colspan="4" class="text-center">No active events.</td></tr>');
        });

        // 3. DELETE EVENT
        $(document).on("click", ".delete-btn", async function() {
            if(!confirm("Delete this event? (This won't delete attendees)")) return;
            const id = $(this).data("id");
            await deleteDoc(doc(db, "events", id));
        });
        
        window.logoutApp = () => signOut(auth).then(() => window.location.href = "login.php");
    </script>
</body>
</html>