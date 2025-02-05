<?php
require_once __DIR__ . '/../models/Order.php';
class OrderController {
  public function index() {
    $orders = Order::all();
    include __DIR__ . '/../views/orders/index.php';
  }
  public function create() {
    include __DIR__ . '/../views/orders/create.php';
  }
  public function store() {
    $client_id = $_POST['client_id'];
    $product_details = $_POST['product_details'];
    $status = $_POST['status'];
    Order::create($client_id, $product_details, $status);
    header('Location: index.php?controller=order&action=index');
  }
  public function edit() {
    $id = $_GET['id'];
    $order = Order::find($id);
    include __DIR__ . '/../views/orders/edit.php';
  }
  public function update() {
    $id = $_POST['id'];
    $client_id = $_POST['client_id'];
    $product_details = $_POST['product_details'];
    $status = $_POST['status'];
    Order::update($id, $client_id, $product_details, $status);
    header('Location: index.php?controller=order&action=index');
  }
  public function delete() {
    $id = $_GET['id'];
    Order::delete($id);
    header('Location: index.php?controller=order&action=index');
  }
}
?>
