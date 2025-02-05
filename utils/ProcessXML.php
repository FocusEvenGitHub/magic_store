<?php
require_once __DIR__ . '/../config/database.php';
class ProcessXML {
  public static function processFile($filePath) {
    $xml = simplexml_load_file($filePath);
    $db = Database::getConnection();
    foreach ($xml->order as $order) {
      $client_id = (int)$order->client_id;
      $product_details = (string)$order->product_details;
      $status = (string)$order->status;
      $stmt = $db->prepare('INSERT INTO orders (client_id, product_details, status) VALUES (?, ?, ?)');
      $stmt->bind_param('iss', $client_id, $product_details, $status);
      $stmt->execute();
    }
  }
}
?>
