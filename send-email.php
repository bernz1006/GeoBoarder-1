<?php
require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function generateEmailContent($userName, $messageType, $message, $receiverName) {
    $htmlContent = '
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Geo Boarder Notification</title>
            <style>
            /* Global Styles */
            body {
              background-color: #f6f6f6;
              font-family: Arial, sans-serif;
              -webkit-font-smoothing: antialiased;
              font-size: 16px;
              line-height: 1.6;
              margin: 0;
              padding: 0;
              -ms-text-size-adjust: 100%;
              -webkit-text-size-adjust: 100%;
            }
        
            /* Container Styles */
            .container {
              margin: 0 auto !important;
              max-width: 580px;
              padding: 20px;
            }
        
            /* Content Styles */
            .content {
              background: #ffffff;
              border-radius: 5px;
              padding: 20px;
            }
        
            /* Typography Styles */
            h1, h2, h3, h4 {
              color: #000000;
              font-family: Arial, sans-serif;
              font-weight: 400;
              margin: 0;
            }
        
            h1 {
              font-size: 32px;
              text-align: center;
              text-transform: capitalize;
            }
        
            p {
              margin: 0 0 20px 0;
            }

            /* Card Styles */
            .card {
              background-color: #f6f6f6;
              border-radius: 5px;
              padding: 15px;
              margin-top: 20px;
            }

            .card h4, .card p {
              margin: 0;
            }
        
            /* Button Styles */
            .btn {
              display: inline-block;
              text-decoration: none;
              background-color: #3498db;
              color: #ffffff;
              padding: 12px 25px;
              border-radius: 5px;
              font-size: 16px;
              font-weight: bold;
            }
        
            /* Footer Styles */
            .footer {
              margin-top: 20px;
              text-align: center;
              color: #999999;
              font-size: 12px;
            }
            </style>
        </head>

        <body>
            <div class="container">
                <h1>Important Notification: Updates and Exciting Features on Geo Boarder!</h1>
                <p>
                    Dear ' . $userName . ',
                </p>
                <p>
                    We hope this message finds you well. At Geo Boarder, we have an important message for you.
                    <strong>' . $messageType . '</strong>
                </p>

                <h2>' . $message . '</h2>

                <p>
                    Thank you for being a part of the Geo Boarder community. If you have any questions or need
                    assistance, feel
                    free to reach out to our support team at <a
                        href="mailto:support@email.com">support@email.com</a>.
                </p>

                <p>
                    Happy home hunting!
                </p>

                <p>Best regards,<br>[Your Name]<br>Geo Boarder Team</p>
            </div>
        </body>

        </html>
    ';

    return $htmlContent;
}

function sendEmail($to, $subject, $type, $message, $topic, $datetime, $sender) {
    // Create a new PHPMailer instance
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->SMTPAuth   = true;
        $mail->SMTPSecure = 'tls';
        $mail->Host       = 'smtp.gmail.com';
        $mail->Port       = 587;
        $mail->Username   = 'officialnexuslink@gmail.com';
        $mail->Password   = 'ypqsfuzaqdgwndjx';
        $mail->isHTML(true);

        // Recipients
        $mail->setFrom('officialnexuslink@gmail.com', 'GeoBoarder Platform');
        $mail->addAddress($to);
        $mail->addReplyTo('officialnexuslink@gmail.com', 'GeoBoarder Hub Team');

        // Content
        $mail->Subject = $subject;
        $mail->Body    = generateEmailContent($to, $type, $message, $topic, $datetime, $sender);
        $mail->AltBody = $message;

        $mail->send();
    } catch (Exception $e) {
        // Handle exceptions
        echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
    }
}

// $to = 'owenduque25@gmail.com';
// $subject = 'Important Notification: Updates and Exciting Features on Geo Boarder!';
// $type = 'Important Notification';
// $message = 'We hope this message finds you well. At Geo Boarder, we have an important message for you.';
// $topic = 'Important Notification: Updates and Exciting Features on Geo Boarder!';
// $datetime = '2021-08-01 12:00:00';
// $sender = 'Geo Boarder Team';

// sendEmail($to, $subject, $type, $message, $topic, $datetime, $sender);
?>
