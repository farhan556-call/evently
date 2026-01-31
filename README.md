# Evently | Event Management System 🎫

![Evently Banner](assets/logos/EventlyLogo-removebg.png)

**Evently** is a lightweight, secure, and real-time event management solution designed to streamline the entire event lifecycle—from public registration to onsite check-in. Built using **PHP** for the backend logic and **Google Firebase** for real-time database capabilities.

## 🚀 Key Features

### 🌍 **Public Registration Portal**
- **Dynamic Event Selection:** Automatically fetches active events from the database.
- **Smart Validation:** Prevents duplicate registrations (same email per event).
- **Security:** Integrated Math Captcha and input sanitization.
- **Mobile Optimized:** Fully responsive split-screen design with branding.

### 📩 **Automated Ticketing System**
- **Instant Email Confirmation:** Sends a branded HTML email upon successful registration.
- **QR Code Generation:** Generates a unique, scannable QR code using QuickChart API.
- **PDF Ticket:** Users can download or print their ticket immediately after registering.

### 🛡️ **Admin Dashboard**
- **Live Statistics:** Real-time counters for Total Registrations, Checked-In, and Pending attendees.
- **Event Manager:** Create, edit, and delete events.
- **Attendee Management:** Searchable table with CSV/PDF export capabilities.
- **Secure Authentication:** Firebase Authentication for admin access.

### 📲 **On-Site Check-in**
- **QR Scanning:** Built-in scanner to verify tickets instantly.
- **Status Updates:** Updates the database from "Registered" to "Checked-In" in real-time.
- **Duplicate Entry Alert:** Warns if a ticket has already been used.

---

## 🛠️ Technology Stack

- **Frontend:** HTML5, CSS3, Bootstrap 5, jQuery
- **Backend Logic:** PHP (v7.4+)
- **Database:** Google Cloud Firestore (NoSQL)
- **Authentication:** Firebase Auth
- **Email Service:** PHPMailer (SMTP via Gmail)
- **APIs:** QuickChart.io (for QR generation)

---

## ⚙️ Installation & Setup

### 1. Clone the Repository
```bash
git clone [https://github.com/yourusername/evently.git](https://github.com/yourusername/evently.git)
cd evently
