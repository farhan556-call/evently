<?php
// 1. Load Composer's autoloader
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

// 2. Get the Data sent from index.php
$data = json_decode(file_get_contents('php://input'), true);

if ($data) {
    $name = $data['name'];
    $email = $data['email'];
    $event = $data['event_name'];
    $ticket_id = $data['ticket_id'];
    $venue = $data['venue'];
    $date = $data['date'];

    // Generate QR Code URL (Blue Color to match theme)
    $qr_url = "https://quickchart.io/qr?text=" . $ticket_id . "&dark=1d4ed8&size=300&margin=1";

    $mail = new PHPMailer(true);

    try {
        // 3. SMTP Configuration
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'kureshif235@gmail.com'; 
        $mail->Password   = 'vfog dbtl tzwr cbhj'; // Your App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // 4. Email Headers
        $mail->setFrom('kureshif235@gmail.com', 'Evently Registration'); 
        $mail->addAddress($email, $name); 

        // 5. Email Content (Themed HTML)
        $mail->isHTML(true);
        $mail->Subject = "Your Ticket for $event";
        
        $mail->Body = "
        <div style='font-family: \"Segoe UI\", sans-serif; background-color: #f1f5f9; padding: 40px 0; text-align: center;'>
            <div style='max-width: 400px; margin: 0 auto; background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.1);'>
                
                <div style='background-color: #1d4ed8; padding: 30px 20px; color: white;'>
                    <h1 style='margin: 0; font-size: 24px; letter-spacing: 2px; text-transform: uppercase;'>Evently Pass</h1>
                    <p style='margin: 5px 0 0 0; opacity: 0.8; font-size: 14px;'>Secure Admission Ticket</p>
                </div>

                <div style='padding: 30px;'>
                    <p style='color: #64748b; font-size: 14px; margin: 0 0 10px 0;'>Hello, <strong>$name</strong>!</p>
                    <h2 style='margin: 0 0 20px 0; color: #0f172a; font-size: 22px;'>$event</h2>
                    
                    <div style='background: #f8fafc; display: inline-block; padding: 15px; border-radius: 12px; border: 2px dashed #cbd5e1;'>
                        <img src='$qr_url' alt='Ticket QR' style='width: 160px; height: 160px; display: block;' />
                    </div>
                    
                    <div style='margin-top: 25px; text-align: left; background: #f8fafc; padding: 20px; border-radius: 12px;'>
                        <table style='width: 100%; border-collapse: collapse;'>
                            <tr>
                                <td style='padding-bottom: 10px; color: #64748b; font-size: 12px; text-transform: uppercase;'>Ticket ID</td>
                                <td style='padding-bottom: 10px; color: #1d4ed8; font-family: monospace; font-weight: bold; text-align: right;'>$ticket_id</td>
                            </tr>
                            <tr>
                                <td style='padding-bottom: 10px; color: #64748b; font-size: 12px; text-transform: uppercase;'>Date</td>
                                <td style='padding-bottom: 10px; color: #334155; font-weight: 600; text-align: right;'>$date</td>
                            </tr>
                            <tr>
                                <td style='color: #64748b; font-size: 12px; text-transform: uppercase;'>Venue</td>
                                <td style='color: #334155; font-weight: 600; text-align: right;'>$venue</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div style='background-color: #f8fafc; padding: 15px; border-top: 1px solid #e2e8f0; font-size: 12px; color: #94a3b8;'>
                    Please present this QR code at the entrance.<br>
                    &copy; " . date("Y") . " Evently. All rights reserved.
                </div>
            </div>
        </div>
        ";

        $mail->send();
        echo json_encode(["status" => "success"]);

    } catch (Exception $e) {
        // Return error securely
        echo json_encode(["status" => "error", "message" => "Mail Error: " . $mail->ErrorInfo]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "No data received"]);
}
?>