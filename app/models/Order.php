<?php
require_once __DIR__ . '/../../config/database.php';

class Order {
  private $pdo;

  public function __construct() {
      $this->pdo = Database::getConnection();;
  }

  public function checkClientExists($client_id) {
    $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM clients WHERE id = :client_id");
    $stmt->execute([':client_id' => $client_id]);
    $result = $stmt->fetchColumn();
    return $result > 0; 
}

public function createOrder($client_id, $product_details, $status) {
    $stmt = $this->pdo->prepare("INSERT INTO orders (client_id, product_details, status) VALUES (:client_id, :product_details, :status)");
    $stmt->execute([
        ':client_id' => $client_id,
        ':product_details' => $product_details,
        ':status' => $status
    ]);
}


  public function getAllOrders() {
      $stmt = $this->pdo->prepare("SELECT * FROM orders");
      $stmt->execute();
      return $stmt->fetchAll();
  }

  public function getOrderById($id) {
      $stmt = $this->pdo->prepare("SELECT * FROM orders WHERE id = :id");
      $stmt->bindParam(':id', $id);
      $stmt->execute();
      return $stmt->fetch();
  }

  public function updateOrder($id, $client_id, $product_details, $status) {
      $stmt = $this->pdo->prepare("UPDATE orders SET client_id = :client_id, product_details = :product_details, status = :status WHERE id = :id");
      $stmt->bindParam(':id', $id);
      $stmt->bindParam(':client_id', $client_id);
      $stmt->bindParam(':product_details', $product_details);
      $stmt->bindParam(':status', $status);
      $stmt->execute();
  }

  public function deleteOrder($id) {
      $stmt = $this->pdo->prepare("DELETE FROM orders WHERE id = :id");
      $stmt->bindParam(':id', $id);
      $stmt->execute();
  }
}
?>
