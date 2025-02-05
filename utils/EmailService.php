<?php
require_once __DIR__ . '/../config/database.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
class EmailService {
  public static function sendEmail($client_id, $subject, $message) {
    $db = Database::getConnection();
    $stmt = $db->prepare('SELECT email FROM clients WHERE id = ?');
    $stmt->bind_param('i', $client_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $client = $result->fetch_assoc();
    if (!$client) return false;
    $mail = new PHPMailer(true);
    try {
      $mail->isSMTP();
      $mail->Host = $_ENV['SMTP_HOST'];
      $mail->SMTPAuth = true;
      $mail->Username = $_ENV['SMTP_USER'];
      $mail->Password = $_ENV['SMTP_PASSWORD'];
      $mail->SMTPSecure = 'tls';
      $mail->Port = $_ENV['SMTP_PORT'];
      $mail->setFrom($_ENV['MAIL_FROM_ADDRESS'], $_ENV['MAIL_FROM_NAME']);
      $mail->addAddress($client['email']);
      $mail->Subject = $subject;
      $mail->Body = $message;
      $mail->send();
      $stmt = $db->prepare('INSERT INTO email_logs (client_id, subject, message) VALUES (?, ?, ?)');
      $stmt->bind_param('iss', $client_id, $subject, $message);
      $stmt->execute();
      return true;
    } catch (Exception $e) {
      return false;
    }
  }
}
?>
