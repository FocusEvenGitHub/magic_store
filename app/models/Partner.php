<?php
namespace App\Models;
use PDO; 

class Partner extends BaseModel {
    protected $table = 'partners';

    public function createPartner(array $data) {
        $required = [ 'nome_loja', 'localizacao'];
        foreach ($required as $field) {
            if (empty($data[$field])) {
                throw new Exception("Campo obrigatório faltando: $field");
            }
        }
    
        $stmt = $this->db->prepare("
            INSERT INTO partners ( nome_loja, localizacao)
            VALUES ( :nome_loja, :localizacao)
        ");
    
        try {
            $stmt->execute([
                ':nome_loja' => $data['nome_loja'],
                ':localizacao' => $data['localizacao']
            ]);
            return ['success' => true, 'id_loja' => $data['id_loja']];
        } catch (PDOException $e) {
            if ($e->errorInfo[1] == 1062) {
                // Duplicado (parceiro já existe)
                return ['success' => true, 'id_loja' => $data['id_loja']];
            }
            error_log("Erro ao criar parceiro: " . $e->getMessage());
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function getAllPartners(): array {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table}");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPartnerById(int $id_loja) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id_loja = :id_loja");
        $stmt->bindParam(':id_loja', $id_loja, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updatePartner(int $id_loja, string $nome_loja, string $localizacao) {
        $stmt = $this->db->prepare("
            UPDATE {$this->table}
            SET nome_loja = :nome_loja,
                localizacao = :localizacao
            WHERE id_loja = :id_loja
        ");
        if ($stmt->execute([
            ':id_loja' => $id_loja,
            ':nome_loja' => $nome_loja,
            ':localizacao' => $localizacao
        ])) {
            return true;
        } else {
            error_log("Erro ao atualizar loja (ID: $id_loja): " . implode(" | ", $stmt->errorInfo()));
            return false;
        }
    }

    public function deletePartner(int $id_loja) {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id_loja = :id_loja");
        if ($stmt->execute([':id_loja' => $id_loja])) {
            return true;
        } else {
            error_log("Erro ao excluir loja (ID: $id_loja): " . implode(" | ", $stmt->errorInfo()));
            return false;
        }
    }

    public function checkPartnerExists(int $id_loja) {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM partners WHERE id_loja = :id_loja");
        $stmt->execute([':id_loja' => $id_loja]);
        return $stmt->fetchColumn() > 0;
    }
}
?>