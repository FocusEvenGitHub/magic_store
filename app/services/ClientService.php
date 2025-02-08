<?php
require_once __DIR__ . '/../models/Client.php';

class ClientService {
    private $clientModel;

    public function __construct() {
        $this->clientModel = new Client();
    }

    public function createClient(array $data): array {
        if (empty($data['nome']) || empty($data['documento']) || empty($data['email'])) {
            return ['success' => false, 'message' => 'Nome, Documento e E-mail são obrigatórios.'];
        }
        $result = $this->clientModel->create($data);
        return $result ? ['success' => true, 'message' => 'Cliente criado com sucesso!'] : ['success' => false, 'message' => 'Erro ao criar cliente.'];
    }

    public function updateClient(int $id, array $data): array {
        if (empty($data['nome']) || empty($data['documento']) || empty($data['email'])) {
            return ['success' => false, 'message' => 'Nome, Documento e E-mail são obrigatórios.'];
        }
        return $this->clientModel->update($id, $data) ? ['success' => true, 'message' => 'Cliente atualizado com sucesso!'] : ['success' => false, 'message' => 'Erro ao atualizar cliente.'];
    }
}
?>
