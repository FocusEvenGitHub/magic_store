<?php
class EmailController {
    public function sendBulkEmails($recipients, $subject, $message) {
        $mail = new PHPMailer(true);
        // Configura servidor SMTP
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $this->applyMagicalTemplate($message);

        foreach ($recipients as $email) {
            try {
                $mail->addAddress($email);
                $mail->send();
                EmailModel::logEmail($email, $subject, $message);
            } catch (Exception $e) {
                // Trata erros
            }
            $mail->clearAddresses();
        }
    }
}