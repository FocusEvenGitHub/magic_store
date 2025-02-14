<?php

namespace App\Services;

use App\Models\Client;

class ClientService
{
    private Client $clientModel;

    public function __construct(Client $clientModel)
    {
        $this->clientModel = $clientModel;
    }

    public function getAllClients(): array
    {
        return $this->clientModel->getAll();
    }

    public function getClientById(int $id): ?array
    {
        return $this->clientModel->findById($id);
    }

    public function createClient(array $data): array
    {
        $validation = $this->validateClientData($data);
        if (!$validation['success']) {
            return $validation;
        }

        return $this->clientModel->create($data)
            ? ['success' => true, 'message' => 'Cliente criado com sucesso!']
            : ['success' => false, 'message' => 'Erro ao criar cliente.'];
    }

    public function updateClient(int $id, array $data): array
    {
        $validation = $this->validateClientData($data);
        if (!$validation['success']) {
            return $validation;
        }

        return $this->clientModel->update($id, $data)
            ? ['success' => true, 'message' => 'Cliente atualizado com sucesso!']
            : ['success' => false, 'message' => 'Erro ao atualizar cliente.'];
    }

    public function deleteClient(int $id): array
    {
        return $this->clientModel->delete($id)
            ? ['success' => true, 'message' => 'Cliente excluído com sucesso!']
            : ['success' => false, 'message' => 'Erro ao excluir cliente.'];
    }

    private function validateClientData(array $data): array
    {
        if (empty($data['nome']) || empty($data['email'])) {
            return ['success' => false, 'message' => 'Nome e E-mail são obrigatórios.'];
        }
        return ['success' => true];
    }
}
