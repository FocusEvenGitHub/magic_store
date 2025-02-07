<?php
require_once __DIR__ . '/../models/Order.php';

class OrderController {
    private $orderModel;

    public function __construct() {
        $this->orderModel = new Order();
    }

    private function setFlash($message, $type = 'success') {
        $_SESSION['flash_message'] = ['message' => $message, 'type' => $type];
    }

    private function redirectToIndex() {
        $this->index();
        exit;
    }

    public function index() {
        $orders = $this->orderModel->getAllOrders();
        include __DIR__ . '/../views/orders/index.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $client_id = filter_input(INPUT_POST, 'client_id', FILTER_VALIDATE_INT);
            $product_details = filter_input(INPUT_POST, 'product_details', FILTER_SANITIZE_STRING);
            $status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_STRING);
            
            if (!$client_id || empty($product_details) || empty($status)) {
                $this->setFlash('Todos os campos são obrigatórios.', 'error');
                $this->redirectToIndex();
            }
            
            $allowedStatuses = ['pending', 'processing', 'shipped', 'delivered'];
            if (!in_array($status, $allowedStatuses)) {
                $this->setFlash('Status inválido.', 'error');
                $this->redirectToIndex();
            }
            
            if (!$this->orderModel->checkClientExists($client_id)) {
                echo "<script>alert('ID Cliente não encontrado!');</script>";
                $this->redirectToIndex();
            }
            
            $result = $this->orderModel->createOrder($client_id, $product_details, $status);
            if ($result) {
                $this->setFlash('Pedido criado com sucesso!');
            } else {
                $this->setFlash('Erro ao criar pedido.', 'error');
            }
            $this->redirectToIndex();
        }
        
        include __DIR__ . '/../views/orders/create.php';
    }

    public function edit($id) {
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if (!$id) {
            $this->setFlash('ID inválido.', 'error');
            $this->redirectToIndex();
        }
        
        $order = $this->orderModel->getOrderById($id);
        if (!$order) {
            $this->setFlash('Pedido não encontrado.', 'error');
            $this->redirectToIndex();
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $client_id = filter_input(INPUT_POST, 'client_id', FILTER_VALIDATE_INT);
            $product_details = filter_input(INPUT_POST, 'product_details', FILTER_SANITIZE_STRING);
            $status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_STRING);
            
            if (!$client_id || empty($product_details) || empty($status)) {
                $this->setFlash('Todos os campos são obrigatórios.', 'error');
                $this->redirectToIndex();
            }
            
            $allowedStatuses = ['pending', 'processing', 'shipped', 'delivered'];
            if (!in_array($status, $allowedStatuses)) {
                $this->setFlash('Status inválido.', 'error');
                $this->redirectToIndex();
            }
            
            if (!$this->orderModel->checkClientExists($client_id)) {
                echo "<script>alert('Cliente não encontrado!');</script>";
                $this->redirectToIndex();
            }
            
            if ($this->orderModel->updateOrder($id, $client_id, $product_details, $status)) {
                $this->setFlash('Pedido atualizado com sucesso!');
            } else {
                $this->setFlash('Erro ao atualizar pedido.', 'error');
            }
            $this->redirectToIndex();
        }
        
        include __DIR__ . '/../views/orders/edit.php';
    }

    public function delete($id) {
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if (!$id) {
            $this->setFlash('ID inválido.', 'error');
            $this->redirectToIndex();
        }
        
        if ($this->orderModel->deleteOrder($id)) {
            $this->setFlash('Pedido excluído com sucesso!');
        } else {
            $this->setFlash('Erro ao excluir pedido.', 'error');
        }
        $this->redirectToIndex();
    }
}
?>
