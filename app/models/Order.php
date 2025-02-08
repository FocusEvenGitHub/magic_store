<?php
require_once __DIR__ . '/BaseModel.php';

class Order extends BaseModel {
    protected $table = 'orders';

    public function checkClientExists(int $client_id): bool {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM clients WHERE id = :client_id");
        $stmt->execute([':client_id' => $client_id]);
        return $stmt->fetchColumn() > 0;
    }

    public function createOrder(int $client_id, string $product_details, string $status) {
        $stmt = $this->db->prepare("
            INSERT INTO {$this->table} (client_id, product_details, status)
            VALUES (:client_id, :product_details, :status)
        ");
        if ($stmt->execute([
            ':client_id' => $client_id,
            ':product_details' => $product_details,
            ':status' => $status
        ])) {
            return $this->db->lastInsertId();
        } else {
            error_log("Erro ao criar pedido: " . implode(" | ", $stmt->errorInfo()));
            return false;
        }
    }

    public function getAllOrders(): array {
        $stmt = $this->db->prepare("
            SELECT o.id, o.product_details, o.status, c.nome AS client_name
            FROM {$this->table} o
            INNER JOIN clients c ON o.client_id = c.id
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOrderById(int $id) {
        $stmt = $this->db->prepare("
            SELECT o.*, c.nome AS client_name
            FROM {$this->table} o
            INNER JOIN clients c ON o.client_id = c.id
            WHERE o.id = :id
        ");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateOrder(int $id, int $client_id, string $product_details, string $status): bool {
        $stmt = $this->db->prepare("
            UPDATE {$this->table}
            SET client_id = :client_id,
                product_details = :product_details,
                status = :status
            WHERE id = :id
        ");
        if ($stmt->execute([
            ':id' => $id,
            ':client_id' => $client_id,
            ':product_details' => $product_details,
            ':status' => $status
        ])) {
            return true;
        } else {
            error_log("Erro ao atualizar pedido (ID: $id): " . implode(" | ", $stmt->errorInfo()));
            return false;
        }
    }

    public function deleteOrder(int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = :id");
        if ($stmt->execute([':id' => $id])) {
            return true;
        } else {
            error_log("Erro ao excluir pedido (ID: $id): " . implode(" | ", $stmt->errorInfo()));
            return false;
        }
    }
}
?>
