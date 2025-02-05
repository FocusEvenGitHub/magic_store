<?php
require_once __DIR__ . '/../../config/database.php';
class Order {
  public static function all() {
    $db = Database::getConnection();
    $result = $db->query('SELECT * FROM orders');
    return $result->fetch_all(MYSQLI_ASSOC);
  }
  public static function find($id) {
    $db = Database::getConnection();
    $stmt = $db->prepare('SELECT * FROM orders WHERE id = ?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
  }
  public static function create($client_id, $product_details, $status) {
    $db = Database::getConnection();
    $stmt = $db->prepare('INSERT INTO orders (client_id, product_details, status) VALUES (?, ?, ?)');
    $stmt->bind_param('iss', $client_id, $product_details, $status);
    $stmt->execute();
  }
  public static function update($id, $client_id, $product_details, $status) {
    $db = Database::getConnection();
    $stmt = $db->prepare('UPDATE orders SET client_id = ?, product_details = ?, status = ? WHERE id = ?');
    $stmt->bind_param('issi', $client_id, $product_details, $status, $id);
    $stmt->execute();
  }
  public static function delete($id) {
    $db = Database::getConnection();
    $stmt = $db->prepare('DELETE FROM orders WHERE id = ?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
  }
}
?>
