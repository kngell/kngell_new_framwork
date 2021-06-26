<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use \SendGrid\Mail\Mail;

class H_Email
{
    private static $_mail_instance = null;

    //=======================================================================
    //Getters
    //=======================================================================
    //mailling instance
    public static function getMailingInstance()
    {
        if (!isset(self::$_mail_instance)) {
            self::$_mail_instance = new PHPMailer();
        }

        return self::$_mail_instance;
    }

    //=======================================================================
    //Sinding Email
    //=======================================================================

    public static function sendmailgrid($to, $subject, $body)
    {
        header('Access-Control-Allow-Origin: *');
        $email = new \SendGrid\Mail\Mail();
        $email->setFrom('admin@kngell.com', "K'nGELL Consulting & Services");
        $email->setSubject($subject);
        $email->addTo($to);
        //$email->addContent("text/plain", "and easy to do anywhere, even with PHP");
        $email->addContent('text/html', $body);
        $sendgrid = new \SendGrid(EMAIL_KEY);
        try {
            $response = $sendgrid->send($email);
            if ($response->statusCode() == 202) {
                return true;
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public static function sendEmailPHP($email, $subject, $body)
    {
        ini_set('dysplay_errors', 1);
        error_reporting(E_ALL);
        $from = 'no-reply@mydomain.com';
        $headers = 'From :' . $from;
        $headers .= PHP_EOL;
        $headers .= 'Return-Path: ' . $email;
        $headers .= PHP_EOL;
        $headers .= 'Reply-To: ' . $email;
        $headers .= PHP_EOL;
        $headers .= 'MIME-Version: 1.0' . PHP_EOL;
        $headers .= 'Content-Type: multipart/mixed;' . PHP_EOL;
        $headers .= ' boundary="boundary_sdfsfsdfs345345sfsgs"';
        if (mail($email, $subject, $body, $headers)) {
            return;
        }

        return 'Server encountered errors!<br>Please try later.';
    }

    // PHP Mailler
    public static function sendEmail($to, $toName, $subject, $msg)
    {
        $mail = self::getMailingInstance();
        try {
            //Server settings
            $mail->isSMTP();
            $mail->Host = SMTP_HOST;
            $mail->SMTPAuth = true;
            $mail->Username = SMTP_USERNAME;
            $mail->Password = SMTP_PASSWORD;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = SMTP_PORT;

            //Recipients
            $mail->setFrom(SMTP_FROM, SMTP_FROM_NAME);
            $mail->addAddress($to, $toName);

            //Content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $msg;

            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
