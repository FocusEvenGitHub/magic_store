<?php
require_once __DIR__ . '/../models/Partner.php';

class PartnerService {
    private $partnerModel;

    public function __construct() {
        $this->partnerModel = new Partner();
    }

    public function getAllPartners(): array {
        return $this->partnerModel->getAllPartners();
    }

    public function getPartnerById(int $id_loja) {
        return $this->partnerModel->getPartnerById($id_loja);
    }

    public function createPartner(array $data): array {
        if (empty($data['id_loja']) || empty($data['nome_loja']) || empty($data['localizacao'])) {
            return ['success' => false, 'message' => 'Todos os campos são obrigatórios.'];
        }

        $result = $this->partnerModel->createPartner($data);
        if ($result) {
            return ['success' => true, 'message' => 'Loja criada com sucesso!', 'id_loja' => $result];
        } else {
            return ['success' => false, 'message' => 'Erro ao criar loja.'];
        }
    }

    public function updatePartner(int $id_loja, array $data): array {
        if (empty($data['nome_loja']) || empty($data['localizacao'])) {
            return ['success' => false, 'message' => 'Todos os campos são obrigatórios.'];
        }

        if ($this->partnerModel->updatePartner($id_loja, $data['nome_loja'], $data['localizacao'])) {
            return ['success' => true, 'message' => 'Loja atualizada com sucesso!'];
        } else {
            return ['success' => false, 'message' => 'Erro ao atualizar loja.'];
        }
    }

    public function deletePartner(int $id_loja): array {
        if ($this->partnerModel->deletePartner($id_loja)) {
            return ['success' => true, 'message' => 'Loja excluída com sucesso!'];
        } else {
            return ['success' => false, 'message' => 'Erro ao excluir loja.'];
        }
    }
    public function upsertPartner(array $data): void {
        $existing = $this->partnerModel->getPartnerById((int)$data['id_loja']);
        
        if (!$existing) {
            $this->createPartner([
                'nome_loja' => $data['nome_loja'],
                'localizacao' => $data['localizacao']
            ]);
        }
    }
    public function partnerExists(int $id_loja): bool {
        return (bool)$this->partnerModel->getPartnerById($id_loja);
    }
}
?>