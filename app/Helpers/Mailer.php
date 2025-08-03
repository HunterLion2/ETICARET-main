<?php

namespace App\Helpers;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\Core\Config;

class Mailer
{
    private $mail;

    public function __construct()
    {
        $this->mail = new PHPMailer(true);
        $this->setup();
    }

    private function setup()
    {
        $this->mail->isSMTP();
        $this->mail->Host = Config::get('MAIL_HOST'); // SMTP sunucunuz
        $this->mail->SMTPAuth = true;
        $this->mail->Username = Config::get('MAIL_USERNAME'); // SMTP kullanıcı adı
        $this->mail->Password = Config::get('MAIL_PASSWORD'); // SMTP şifresi
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mail->Port = Config::get('MAIL_PORT');
        $this->mail->setFrom(Config::get('MAIL_FROM_ADDRESS'), Config::get('MAIL_FROM_NAME')); // Gönderen e-posta adresi
        $this->mail->CharSet = 'UTF-8'; // Karakter seti

        // Sertifika doğrulamasını devre dışı bırak
        $this->mail->SMTPOptions = [
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            ]
        ];
    }

    public function sendMail($to, $subject, $body)
    {
        try {
            $this->mail->addAddress($to);
            $this->mail->isHTML(true);
            $this->mail->Subject = $subject;
            $this->mail->Body    = $body;
            $this->mail->send();
            return true;
        } catch (Exception $e) {
            return "Message could not be sent. Mailer Error: {$this->mail->ErrorInfo}";
        }
    }
}