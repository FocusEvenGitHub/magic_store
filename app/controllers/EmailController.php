<?php

require_once __DIR__ . '/../models/EmailLog.php';
require_once __DIR__ . '/../models/Client.php';
require_once __DIR__ . '/../../utils/EmailService.php';
class EmailController {
    private $emailLog;
    private $emailService;
    private $clientModel;

    public function __construct() {
        $this->emailLog = new EmailLog();
        $this->emailService = new EmailService();
        $this->clientModel = new Client();
    }

    public function sendEmail(int $clientId): void {
        $client = $this->clientModel->findById($clientId);

        if (!$client) {
            $this->redirectToClientControllerWithMessage('Cliente não encontrado!');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $subject = $_POST['subject'] ?? 'Sem Assunto';
            $message = $_POST['message'] ?? '';

            $this->processEmailSending($client, $subject, $message);
            return;
        }

        include __DIR__ . '/../views/email/sendEmail.php';
    }

    private function processEmailSending(array $client, string $subject, string $message): void {
        $sent = $this->emailService->send($client['email'], $client['nome'], $subject, $message);
        $alertMessage = $sent ? 'E-mail enviado com sucesso!' : 'Falha ao enviar e-mail!';
        $this->emailLog->logEmail($client['id'], $subject, $message);
        echo "<script>alert('$alertMessage');</script>";
        $this->redirectToClientController();
    }

    private function redirectToClientControllerWithMessage(string $message): void {
        echo "<script>alert('$message');</script>";
        $this->redirectToClientController();
    }

    private function redirectToClientController(): void {
        require_once __DIR__ . '/ClientController.php';
        $clientCtrl = new ClientController();
        $clientCtrl->index();
    }
}

?>
