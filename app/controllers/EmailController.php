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

    public function sendEmail($client_id) {
        $client = $this->clientModel->findById($client_id);

        if (!$client) {
            echo "<script>alert('Cliente não encontrado!');</script>";
            require_once __DIR__ . '/ClientController.php';
            $clientCtrl = new ClientController();
            $clientCtrl->index();
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $subject = $_POST['subject'] ?? 'Sem Assunto';
            $message = $_POST['message'] ?? '';

            $sent = $this->emailService->send($client['email'], $client['nome'], $subject, $message);

            if ($sent) {
                $this->emailLog->logEmail($client['id'], $subject, $message);
                echo "<script>alert('E-mail enviado com sucesso!');</script>";
            } else {
                echo "<script>alert('Falha ao enviar e-mail!');</script>";
            }

            require_once __DIR__ . '/ClientController.php';
            $clientCtrl = new ClientController();
            $clientCtrl->index();
            return;
        }

        include __DIR__ . '/../views/email/sendEmail.php';
    }
}
?>
