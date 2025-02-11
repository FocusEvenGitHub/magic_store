<?php
require_once __DIR__ . '/BaseModel.php';

class Client extends BaseModel {
    protected $table = 'clients';

    public function getAll(): array {
        $stmt = $this->db->query("SELECT id_cliente, nome_cliente, email FROM {$this->table}");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById($id) {
        $stmt = $this->db->prepare("SELECT id_cliente, nome_cliente, email FROM clients WHERE id_cliente = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create(array $data) {
        $stmt = $this->db->prepare('
            INSERT INTO clients (nome_cliente, email) 
            VALUES (?, ?)
        ');
        if ($stmt->execute([
            $data['nome_cliente'], 
            $data['email']
        ])) {
            return $this->db->lastInsertId();
        } else {
            error_log("Erro ao criar cliente: " . implode(" | ", $stmt->errorInfo()));
            return false;
        }
    }

    public function update(int $id, array $data): bool {
        $stmt = $this->db->prepare('
            UPDATE clients 
            SET nome_cliente = ?, email = ?
            WHERE id_cliente = ?
        ');
        if ($stmt->execute([
            $data['nome_cliente'], 
            $data['email'], 
            $id
        ])) {
            return true;
        } else {
            error_log("Erro ao atualizar cliente (ID: $id): " . implode(" | ", $stmt->errorInfo()));
            return false;
        }
    }

    public function delete($id): bool {
        $stmt = $this->db->prepare("DELETE FROM clients WHERE id_cliente = ?");
        if ($stmt->execute([$id])) {
            return true;
        } else {
            error_log("Erro ao excluir cliente (ID: $id): " . implode(" | ", $stmt->errorInfo()));
            return false;
        }
    }
}
?>
