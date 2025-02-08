<?php
require_once __DIR__ . '/../models/Order.php';

class OrderService {
    private $orderModel;
    
    public function __construct() {
        $this->orderModel = new Order();
    }
    
    public function createOrder(array $data): array {
        if (empty($data['client_id']) || empty($data['product_details']) || empty($data['status'])) {
            return ['success' => false, 'message' => 'Todos os campos são obrigatórios.'];
        }
        
        $allowedStatuses = ['pending', 'processing', 'shipped', 'delivered'];
        if (!in_array($data['status'], $allowedStatuses)) {
            return ['success' => false, 'message' => 'Status inválido.'];
        }
        
        if (!$this->orderModel->checkClientExists($data['client_id'])) {
            return ['success' => false, 'message' => 'ID do cliente não encontrado.'];
        }
        
        $result = $this->orderModel->createOrder($data['client_id'], $data['product_details'], $data['status']);
        if ($result) {
            return ['success' => true, 'message' => 'Pedido criado com sucesso!', 'order_id' => $result];
        } else {
            return ['success' => false, 'message' => 'Erro ao criar pedido.'];
        }
    }
    
    public function updateOrder(int $id, array $data): array {
        if (empty($data['client_id']) || empty($data['product_details']) || empty($data['status'])) {
            return ['success' => false, 'message' => 'Todos os campos são obrigatórios.'];
        }
        
        $allowedStatuses = ['pending', 'processing', 'shipped', 'delivered'];
        if (!in_array($data['status'], $allowedStatuses)) {
            return ['success' => false, 'message' => 'Status inválido.'];
        }
        
        if (!$this->orderModel->checkClientExists($data['client_id'])) {
            return ['success' => false, 'message' => 'ID do cliente não encontrado.'];
        }
        
        if ($this->orderModel->updateOrder($id, $data['client_id'], $data['product_details'], $data['status'])) {
            return ['success' => true, 'message' => 'Pedido atualizado com sucesso!'];
        } else {
            return ['success' => false, 'message' => 'Erro ao atualizar pedido.'];
        }
    }
}
?>
