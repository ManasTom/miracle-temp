<?php
// submit.php

// =======================
// CONFIGURATION
// =======================
$to = "admin@miracle-minds.com"; // Replace with your email
$subject_prefix = "New Callback Request";

// =======================
// HELPER FUNCTIONS
// =======================
function sanitize_input($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

function is_valid_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// =======================
// HONEYPOT (hidden field trap)
// =======================
if (!empty($_POST['website'])) { // Honeypot
    die("Spam detected.");
}

// =======================
// REQUEST METHOD CHECK
// =======================
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Collect & sanitize input
    $name    = sanitize_input($_POST['name'] ?? '');
    $email   = sanitize_input($_POST['email'] ?? '');
    $phone   = sanitize_input($_POST['phone'] ?? '');
    $message = sanitize_input($_POST['message'] ?? '');

    // =======================
    // VALIDATION
    // =======================
    if (empty($name) || empty($email) || empty($phone)) {
        die("Please fill all required fields.");
    }

    if (!is_valid_email($email)) {
        die("Invalid email format.");
    }

    // Prevent Email Header Injection
    $forbidden = array("\r", "\n", "content-type:", "bcc:", "to:", "cc:");
    foreach ($forbidden as $f) {
        if (stripos($name, $f) !== false || stripos($email, $f) !== false) {
            die("Invalid input detected.");
        }
    }

    // =======================
    // EMAIL CONTENT (HTML)
    // =======================
    $email_subject = $subject_prefix;

    $email_body = '
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <title>Callback Request</title>
    </head>
    <body style="font-family: Arial, sans-serif; background-color:#f8f9fa; padding:20px; color:#333;">
        <table align="center" cellpadding="0" cellspacing="0" width="600" style="background:#fff; border-radius:8px; box-shadow:0 2px 6px rgba(0,0,0,0.1);">
            <tr>
                <td align="center" style="padding:20px; border-bottom:1px solid #eee;">
                    <img src="https://miracle-minds.com/image/miracle-minds-logo.png" alt="Miracle Minds" style="max-width:200px;">
                </td>
            </tr>
            <tr>
                <td style="padding:20px;">
                    <h2 style="color:#0066cc; margin-bottom:20px;">New Callback Request</h2>
                    <p><strong>Name:</strong> '.$name.'</p>
                    <p><strong>Email:</strong> '.$email.'</p>
                    <p><strong>Phone:</strong> '.$phone.'</p>
                    <p><strong>Message:</strong><br>'.nl2br($message).'</p>

                    <div style="margin-top:30px; text-align:center;">
                        <a href="tel:'.$phone.'" 
                           style="display:inline-block; padding:12px 25px; margin:5px; background-color:#28a745; color:#fff; text-decoration:none; border-radius:5px; font-size:16px;">
                           📞 Call '.$phone.'
                        </a>
                        <a href="https://wa.me/'.$phone.'" 
                           style="display:inline-block; padding:12px 25px; margin:5px; background-color:#25D366; color:#fff; text-decoration:none; border-radius:5px; font-size:16px;">
                           💬 WhatsApp '.$phone.'
                        </a>
                    </div>
                </td>
            </tr>
            <tr>
                <td align="center" style="background:#f1f1f1; padding:15px; font-size:12px; color:#666; border-top:1px solid #eee;">
                    Miracle Minds - Online & Offline Counseling, Coaching & Mental Wellness Services
                </td>
            </tr>
        </table>
    </body>
    </html>';

    // Email headers
    $headers  = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: ".$name." <".$email.">\r\n";
    $headers .= "Reply-To: ".$email."\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();

    // =======================
    // SEND EMAIL
    // =======================
     if (mail($to, $email_subject, $email_body, $headers)) {
        header("Location: thankyou.html");
        exit();
    } else {
        header("Location: 404.html");
        exit();
    }
} else {
    header("Location: 404.html");
    exit();
}
?>
