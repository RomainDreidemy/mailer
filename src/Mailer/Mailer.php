<?php
namespace App\Mailer;

use PHPMailer\PHPMailer\PHPMailer;

class Mailer
{
    public static function envoi(string $to, string $body, array $joints) {
        $mail = new PHPMailer();  // Cree un nouvel objet PHPMailer
        $mail->CharSet  = "UTF-8";
        $mail->IsSMTP(); // active SMTP
        $mail->SMTPDebug = 0;  // debogage: 1 = Erreurs et messages, 2 = messages seulement
        $mail->SMTPAuth = true;  // Authentification SMTP active
        $mail->SMTPSecure = 'ssl'; // Gmail REQUIERT Le transfert securise
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 465;
        $mail->Username = 'dreidemyromain@gmail.com';
        $mail->Password = 'lebossdukill77';
        $mail->SetFrom('dreidemyromain@gmail.com', 'Romain Dreidemy');
        $mail->Subject = 'Candidature spontannée pour alternance';
        $mail->Body = $body;
        $mail->AddAddress($to);

        foreach($joints as $joint){
            $mail->AddAttachment(__DIR__ . "/../../public/assets/" . $joint);
        }

        if(!$mail->Send()) {
            return 'Mail error: '.$mail->ErrorInfo;
        } else {
            return true;
        }
    }
}
