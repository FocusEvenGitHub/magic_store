<?php
require_once __DIR__ . '/../models/Order.php';

class OrderService {
    private $orderModel;
    
    public function __construct() {
        $this->orderModel = new Order();
    }
    
    public function createOrder(array $data): array {
        if (empty($data['id_loja']) && empty($data['id_cliente'])) {
            return ['success' => false, 'message' => 'Informe o ID da loja ou o ID do cliente.'];
        }
    
        if (empty($data['produto']) || empty($data['quantidade']) || empty($data['valor'])) {
            return ['success' => false, 'message' => 'Preencha os campos obrigatórios: produto, quantidade e valor.'];
        }
        $result = $this->orderModel->createOrder(
            $data['id_loja'], 
            $data['id_cliente'],
            $data['produto'],
            $data['quantidade'],
            $data['valor']
        );
    
        
        if ($result) {
            return ['success' => true, 'message' => 'Pedido criado com sucesso!', 'order_id' => $result];
        } else {
            return ['success' => false, 'message' => 'Erro ao criar pedido.'];
        }
    }
    public function createOrderFromImport(array $data): array {
        try {
            $required = ['id_loja', 'produto', 'quantidade', 'valor'];
            foreach ($required as $field) {
                if (empty($data[$field])) {
                    throw new Exception("Campo obrigatório faltando: {$field}");
                }
            }
    
            $id_cliente = $data['id_cliente'] ?? null;
    
            $orderId = $this->orderModel->createOrder(
                (int)$data['id_loja'],
                $id_cliente, // Pode ser null
                $data['produto'],
                (int)$data['quantidade'],
                (float)$data['valor']
            );
    
            if ($orderId === false) {
                throw new Exception("Erro ao criar pedido no banco de dados.");
            }
    
            return ['success' => true, 'message' => 'Pedido criado!', 'order_id' => $orderId];
        } catch (Exception $e) {
            error_log("Erro OrderService: " . $e->getMessage());
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
    
    public function updateOrder(int $id_order, array $data): array {
        if (empty($data['id_loja']) || empty($data['id_cliente']) || empty($data['produto']) || empty($data['quantidade']) || empty($data['valor'])) {
            return ['success' => false, 'message' => 'Todos os campos são obrigatórios.'];
        }
        
        if (!$this->orderModel->checkClientExists($data['id_cliente'])) {
            return ['success' => false, 'message' => 'ID do cliente não encontrado.'];
        }
        
        if ($this->orderModel->updateOrder(
            $id_order,
            $data['id_loja'],
            $data['id_cliente'],
            $data['produto'],
            $data['quantidade'],
            $data['valor']
        )) {
            return ['success' => true, 'message' => 'Pedido atualizado com sucesso!'];
        } else {
            return ['success' => false, 'message' => 'Erro ao atualizar pedido.'];
        }
    }


}
?>