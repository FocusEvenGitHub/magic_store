<?php
class Order {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getConnection();
    }

    public function checkClientExists($client_id) {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM clients WHERE id = :client_id");
        $stmt->execute([':client_id' => $client_id]);
        return $stmt->fetchColumn() > 0;
    }

    public function createOrder($client_id, $product_details, $status) {
        $stmt = $this->pdo->prepare("
            INSERT INTO orders (client_id, product_details, status) 
            VALUES (:client_id, :product_details, :status)
        ");
        if ($stmt->execute([
            ':client_id'       => $client_id,
            ':product_details' => $product_details,
            ':status'          => $status
        ])) {
            return $this->pdo->lastInsertId();
        } else {
            error_log("Erro ao criar pedido: " . implode(" | ", $stmt->errorInfo()));
            return false;
        }
    }

    public function getAllOrders() {
        $stmt = $this->pdo->prepare("
            SELECT o.id, o.product_details, o.status, c.nome AS client_name 
            FROM orders o
            INNER JOIN clients c ON o.client_id = c.id
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOrderById($id) {
        $stmt = $this->pdo->prepare("
            SELECT o.*, c.nome AS client_name 
            FROM orders o
            INNER JOIN clients c ON o.client_id = c.id
            WHERE o.id = :id
        ");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateOrder($id, $client_id, $product_details, $status) {
        $stmt = $this->pdo->prepare("
            UPDATE orders 
            SET client_id = :client_id, product_details = :product_details, status = :status 
            WHERE id = :id
        ");
        if ($stmt->execute([
            ':id'              => $id,
            ':client_id'       => $client_id,
            ':product_details' => $product_details,
            ':status'          => $status
        ])) {
            return true;
        } else {
            error_log("Erro ao atualizar pedido (ID: $id): " . implode(" | ", $stmt->errorInfo()));
            return false;
        }
    }

    public function deleteOrder($id) {
        $stmt = $this->pdo->prepare("DELETE FROM orders WHERE id = :id");
        if ($stmt->execute([':id' => $id])) {
            return true;
        } else {
            error_log("Erro ao excluir pedido (ID: $id): " . implode(" | ", $stmt->errorInfo()));
            return false;
        }
    }
}
?>
