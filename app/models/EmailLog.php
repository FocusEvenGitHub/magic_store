<?php
class EmailLog {
    private PDO $pdo;

    public function __construct() {
        $this->pdo = Database::getConnection();
    }

    public function logEmail(int $clientId, string $subject, string $message): void {
        $query = "INSERT INTO email_logs (id_cliente, subject, message) VALUES (:id_cliente, :subject, :message)";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([
            ':id_cliente' => $clientId,
            ':subject'   => $subject,
            ':message'   => $message
        ]);
    }
}
?>
