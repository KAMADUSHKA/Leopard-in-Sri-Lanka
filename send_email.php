<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Load Composer's autoloader

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Retrieve form data safely
    $name = htmlspecialchars($_POST["name"]);
    $email = htmlspecialchars($_POST["email"]);
    $phone = htmlspecialchars($_POST["phone"]);
    $accommodation = htmlspecialchars($_POST["accommodation"]);
    $budget = htmlspecialchars($_POST["budget"]);
    $tourMonth = htmlspecialchars($_POST["tourMonth"]);
    $tourDuration = htmlspecialchars($_POST["tourDuration"]);
    $requirements = htmlspecialchars($_POST["requirements"]);

    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp-relay.brevo.com'; // Brevo SMTP server
        $mail->SMTPAuth = true;
        $mail->Port = 587;
        $mail->Username = '896607001@smtp-brevo.com'; 
        $mail->Password = 'QDNRjgJ6s8vUpPqK';

        // Email sender and recipients
        $mail->setFrom('info@travelsgolanka.com', 'Travel Go Lanka');
        // $mail->addAddress('nawanjanaenda@gmail.com', 'Tharindu');
        $mail->addAddress('travelsgolanka@gmail.com');
        $mail->addAddress('info@travelsgolanka.com');
        $mail->addReplyTo($email, $name); // User's email for reply

        // Email subject
        $mail->Subject = "New Tour Inquiry from $name";

        // Load email template
        $emailBody = file_get_contents('email_template.html');

        // Replace placeholders with actual form data
        $emailBody = str_replace('{{name}}', $name, $emailBody);
        $emailBody = str_replace('{{email}}', $email, $emailBody);
        $emailBody = str_replace('{{phone}}', $phone, $emailBody);
        $emailBody = str_replace('{{accommodation}}', $accommodation, $emailBody);
        $emailBody = str_replace('{{budget}}', $budget, $emailBody);
        $emailBody = str_replace('{{tourMonth}}', $tourMonth, $emailBody);
        $emailBody = str_replace('{{tourDuration}}', $tourDuration, $emailBody);
        $emailBody = str_replace('{{requirements}}', nl2br($requirements), $emailBody);

        // Email content
        $mail->isHTML(true);
        $mail->Body = $emailBody;

        // Send email
        if ($mail->send()) {
            http_response_code(200);
        } else {
            http_response_code(500); 
        }
        
    } catch (Exception $e) {
        http_response_code(500); 
    }
} else {
    http_response_code(500); 
}

?>
