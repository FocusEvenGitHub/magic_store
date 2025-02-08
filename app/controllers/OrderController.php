<?php
require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../services/OrderSevice.php';
require_once __DIR__ . '/../models/Order.php';

class OrderController extends BaseController {
    private $orderService;
    private $orderModel;

    public function __construct() {
        $this->orderService = new OrderService();
        $this->orderModel = new Order();
    }

    public function index(): void {
        $orders = $this->orderModel->getAllOrders();
        include __DIR__ . '/../views/orders/index.php';
        exit;
    }

    public function create(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'client_id'       => filter_input(INPUT_POST, 'client_id', FILTER_VALIDATE_INT),
                'product_details' => filter_input(INPUT_POST, 'product_details', FILTER_SANITIZE_STRING),
                'status'          => filter_input(INPUT_POST, 'status', FILTER_SANITIZE_STRING)
            ];
            
            $result = $this->orderService->createOrder($data);
            $this->setFlash($result['message'], $result['success'] ? 'success' : 'error');
            $this->index();
        }
        
        include __DIR__ . '/../views/orders/create.php';
    }

    public function edit($id): void {
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if (!$id) {
            $this->setFlash('ID inválido.', 'error');
            $this->index();
        }
        
        $order = $this->orderModel->getOrderById($id);
        if (!$order) {
            $this->setFlash('Pedido não encontrado.', 'error');
            $this->index();
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'client_id'       => filter_input(INPUT_POST, 'client_id', FILTER_VALIDATE_INT),
                'product_details' => filter_input(INPUT_POST, 'product_details', FILTER_SANITIZE_STRING),
                'status'          => filter_input(INPUT_POST, 'status', FILTER_SANITIZE_STRING)
            ];
            
            $result = $this->orderService->updateOrder($id, $data);
            $this->setFlash($result['message'], $result['success'] ? 'success' : 'error');
            $this->index();
        }
        
        include __DIR__ . '/../views/orders/edit.php';
    }

    public function delete($id): void {
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if (!$id) {
            $this->setFlash('ID inválido.', 'error');
            $this->index();
        }
        
        if ($this->orderModel->deleteOrder($id)) {
            $this->setFlash('Pedido excluído com sucesso!');
        } else {
            $this->setFlash('Erro ao excluir pedido.', 'error');
        }
        $this->index();
    }
}
?>
