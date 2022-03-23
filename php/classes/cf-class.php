<?php

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\PHPMailer;

class cf extends Setup
{
    /**
     * @param $fields
     * @return string
     * @throws \Exception
     */
    public function cf_mailer($fields) {
        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        try {
            //Server settings
            $mail->SMTPDebug = $this->debug;                                 // Enable verbose debug output
            $mail->isSMTP();
            date_default_timezone_set('Africa/Johannesburg');   // Set mailer to use SMTP
            $mail->Host = $this->smtphost;                         // Specify main and backup SMTP servers
            $mail->SMTPAuth = $this->smtpauth;                               // Enable SMTP authentication
            $mail->Username = $this->email;                           // SMTP username
            $mail->Password = $this->pass;                           // SMTP password
            $mail->SMTPSecure = $this->smtpsecure;            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = $this->smtpport;                                    // TCP port to connect to

            //Recipients
            $mail->setFrom($this->email, $this->emailname);
            $mail->addAddress('gregory@realhost.co.za', "Gregory");              // Add a recipient
            $mail->addReplyTo('gregory@realhost.co.za', 'Gregory');

            if ($this->mailcc != null) {
                $mail->addCC($this->mailcc);
            }
            if ($this->mailbcc != null) {
                $mail->addCC($this->mailbcc);
            }
            /* Attachments
            $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
            $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
            */
            //Content
            $mail->isHTML(true);
            $mail->Subject = $this->subjectline;

            $message = file_get_contents(__root_path__.'./email-templates/contact-form.html');
            $message = str_replace('%firstname%', $fields['firstname'], $message);
            $message = str_replace('%lastname%', $fields['lastname'], $message);
            $message = str_replace('%email%', $fields['email'], $message);
            $message = str_replace('%telephone%', $fields['telephone'], $message);
            $message = str_replace('%message%', $fields['message'], $message);
            $mail->MsgHTML($message);
            $mail->AltBody = strip_tags($message);
            $mail->send();
            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Writes Contact Form entry to DB
     * @param $dbh
     * @param $fields
     */
    public function cf_db($dbh, $fields) {
        $stmt = $dbh->prepare("INSERT INTO contact_form (firstname, lastname, honeypot, telephone, email, message, status)
    VALUES (:firstname, :lastname, :honeypot, :telephone, :email, :message, :status)");
        $stmt->bindParam(':firstname', $fields["firstname"]);
        $stmt->bindParam(':lastname', $fields["lastname"]);
        $stmt->bindParam(':honeypot', $fields["phone"]);
        $stmt->bindParam(':telephone', $fields["telephone"]);
        $stmt->bindParam(':email', $fields["email"]);
        $stmt->bindParam(':message', $fields["message"]);
        $stmt->bindParam(':status', $fields["status"]);
        $stmt->execute();
        $dbh = null;
    }
}