<?php

class EmailLog {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getConnection();
    }

    /**
     * Registra um log de envio de e-mail.
     *
     * @param int $client_id ID do cliente.
     * @param string $subject Assunto do e-mail.
     * @param string $message Mensagem enviada.
     */
    public function logEmail($client_id, $subject, $message) {
        $stmt = $this->pdo->prepare("INSERT INTO email_logs (client_id, subject, message) VALUES (:client_id, :subject, :message)");
        $stmt->execute([
            ':client_id' => $client_id,
            ':subject'   => $subject,
            ':message'   => $message
        ]);
    }
}
?>
