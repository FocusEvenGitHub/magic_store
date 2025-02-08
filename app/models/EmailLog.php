<?php
class EmailLog {
    private PDO $pdo;

    public function __construct() {
        $this->pdo = Database::getConnection();
    }

    public function logEmail(int $clientId, string $subject, string $message): void {
        $query = "INSERT INTO email_logs (client_id, subject, message) VALUES (:client_id, :subject, :message)";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([
            ':client_id' => $clientId,
            ':subject'   => $subject,
            ':message'   => $message
        ]);
    }
}
?>
