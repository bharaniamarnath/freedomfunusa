<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\OAuth;
use League\OAuth2\Client\Provider\Google;


require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/../controllers/oauth/oauth_db.php');

class sendMail
{
    public function __construct($sendEmail, $sendName, $sendSubject, $sendBody, $sendWaiver = 0)
    {
        //Create a new PHPMailer instance
        $mail = new PHPMailer();
        //Comment below setting in live server
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 465;

        //Set the encryption mechanism to use:
        // - SMTPS (implicit TLS on port 465) or
        // - STARTTLS (explicit TLS on port 587)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;

        $mail->SMTPAuth = true;
        $mail->AuthType = 'XOAUTH2';

        $email = 'mail.tisocial@gmail.com'; // the email used to register google app
        $clientId = '462215736285-7qkq0ir7inic9b1vd92qtaq6ebs62urc.apps.googleusercontent.com';
        $clientSecret = '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';

        $db = new DB();
        $refreshToken = $db->get_refresh_token();

        //Create a new OAuth2 provider instance
        $provider = new Google(
            [
                'clientId' => $clientId,
                'clientSecret' => $clientSecret,
            ]
        );

        //Pass the OAuth provider instance to PHPMailer
        $mail->setOAuth(
            new OAuth(
                [
                    'provider' => $provider,
                    'clientId' => $clientId,
                    'clientSecret' => $clientSecret,
                    'refreshToken' => $refreshToken,
                    'userName' => $email,
                ]
            )
        );

        $mail->setFrom('info@tisocial.com', 'Freedom Fun');
        $mail->addAddress($sendEmail, $sendName);
        $mail->isHTML(true);
        $mail->Subject = $sendSubject;

        $mail->AddEmbeddedImage(__DIR__ . '/../public/assets/images/email/feature_image.png', 'feature_image');
        $mail->AddEmbeddedImage(__DIR__ . '/../public/assets/images/email/facilitator_logo.png', 'facilitator_logo');
        $mail->AddEmbeddedImage(__DIR__ . '/../public/assets/images/email/organisation_logo.png', 'organisation_logo');
        $mail->AddEmbeddedImage(__DIR__ . '/../public/assets/images/email/sponsor_logo.png', 'sponsor_logo');


        //Send Attachment

        if (isset($sendWaiver) && $sendWaiver == '1') {
            $mail->AddAttachment(__DIR__ . '/../public/content/FF_Waiver_Release_Of_Reliability.pdf');
        }


        //Replace the plain text body with one created manually

        $mail->Body = $sendBody;

        //send the message, check for errors
        if (!$mail->send()) {
            $this->db_console('Email Notification Error: ' . $mail->ErrorInfo . 'To: ' . $sendEmail);
        } else {
            $this->db_console('Email Notification Sent. To: ' . $sendEmail);
        }
    }

    //Print DB Console

    public function db_console($msg)
    {
        $console_file = __DIR__ . '/../public/logs/console.json';
        $log_date = date('Y-m-d H:i:s');
        $log_array = array(
            "log_date" => $log_date,
            "log_msg" => $msg
        );
        $log_data = array();
        if (file_exists($console_file)) {
            $log_data = file_get_contents($console_file);
            $log_data_array = json_decode($log_data);
            $log_data_array[] = $log_array;
            $write_log = json_encode($log_data_array, JSON_PRETTY_PRINT);
            file_put_contents($console_file, $write_log);
        }
    }
}
