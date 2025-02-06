<?php
require_once __DIR__ . '/../models/Order.php';
class OrderController {

  private $pdo;
  private $orderModel;

  public function __construct() {
      $this->orderModel = new Order();
  }

  public function index() {
      $orders = $this->orderModel->getAllOrders();
      include __DIR__ . '/../views/orders/index.php'; 
    }

    public function create() {

      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
          $client_id = $_POST['client_id'];
          $product_details = $_POST['product_details'];
          $status = $_POST['status'];
  
          $clientExists = $this->orderModel->checkClientExists($client_id);
          if (!$clientExists) {
            echo "<script>alert('ID Cliente não encontrado!');</script>";
            $this->index();
            exit;
        }
        
  
          $this->orderModel->createOrder($client_id, $product_details, $status);
          $this->index();
        }
          include __DIR__ . '/../views/orders/create.php';
  }
  

  public function edit($id) {
    $order = $this->orderModel->getOrderById($id);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $client_id = $_POST['client_id'];
        $product_details = $_POST['product_details'];
        $status = $_POST['status'];

        $clientExists = $this->orderModel->checkClientExists($client_id);
        if (!$clientExists) {
            echo "<script>alert('Cliente não encontrado!');</script>";
            $this->index();  
            exit;
        }

        $this->orderModel->updateOrder($id, $client_id, $product_details, $status);
        $this->index(); 
        exit;
    }

    include __DIR__ . '/../views/orders/edit.php';
}


  public function delete($id) {
      $this->orderModel->deleteOrder($id);
      $this->index();
  }
}
?>
