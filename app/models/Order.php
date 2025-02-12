<?php
require_once __DIR__ . '/BaseModel.php';

class Order extends BaseModel {
    protected $table = 'orders';

    public function checkClientExists(int $client_id): bool {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM clients WHERE id_cliente = :client_id");
        $stmt->execute([':client_id' => $client_id]);
        return $stmt->fetchColumn() > 0;
    }
    public function checkPartnerExists(int $id_loja): bool {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM partners WHERE id_loja = :id_loja");
        $stmt->execute([':id_loja' => $id_loja]);
        return $stmt->fetchColumn() > 0;
    }

    public function createOrder(?int $id_loja, ?int $id_cliente, string $produto, int $quantidade, float $valor) {

        $stmt = $this->db->prepare("
            INSERT INTO orders (id_loja, id_cliente, produto, quantidade, valor)
            VALUES (:id_loja, :id_cliente, :produto, :quantidade, :valor)
        ");
        
        if ($stmt->execute([
            ':id_loja' => $id_loja,
            ':id_cliente' => $id_cliente, 
            ':produto' => $produto,
            ':quantidade' => $quantidade,
            ':valor' => $valor
        ])) {
            return $this->db->lastInsertId();
        } else {
            error_log("Erro ao criar pedido: " . implode(" | ", $stmt->errorInfo()));
            return false;
        } 
    }
    public function getAllOrders(): array {
        $stmt = $this->db->prepare("
            SELECT 
                o.id_order, 
                o.id_loja, 
                o.id_cliente, 
                o.produto, 
                o.quantidade, 
                o.valor, 
                o.ultima_atualizacao, 
                p.nome_loja,
                c.nome_cliente
            FROM 
                {$this->table} o
            LEFT JOIN 
                partners p ON o.id_loja = p.id_loja
            LEFT JOIN 
                clients c ON o.id_cliente = c.id_cliente
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOrderById(int $id_order) {
        $stmt = $this->db->prepare("
        SELECT o.*, p.nome_loja, c.nome_cliente
        FROM {$this->table} o
        LEFT JOIN clients c ON o.id_cliente = c.id_cliente
        LEFT JOIN partners p ON o.id_loja = p.id_loja
        WHERE o.id_order = :id_order
        ");
        $stmt->bindParam(':id_order', $id_order, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateOrder(int $id_order, int $id_loja, int $id_cliente, string $produto, int $quantidade, float $valor): bool {
        $stmt = $this->db->prepare("
            UPDATE {$this->table}
            SET id_loja = :id_loja,
                id_cliente = :id_cliente,
                produto = :produto,
                quantidade = :quantidade,
                valor = :valor
            WHERE id_order = :id_order
        ");
        if ($stmt->execute([
            ':id_order' => $id_order,
            ':id_loja' => $id_loja,
            ':id_cliente' => $id_cliente,
            ':produto' => $produto,
            ':quantidade' => $quantidade,
            ':valor' => $valor
        ])) {
            return true;
        } else {
            error_log("Erro ao atualizar pedido (ID: $id_order): " . implode(" | ", $stmt->errorInfo()));
            return false;
        }
    }

    public function deleteOrder(int $id_order): bool {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id_order = :id_order");
        if ($stmt->execute([':id_order' => $id_order])) {
            return true;
        } else {
            error_log("Erro ao excluir pedido (ID: $id_order): " . implode(" | ", $stmt->errorInfo()));
            return false;
        }
    }
}
?>