<?php
require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../services/OrderService.php';
require_once __DIR__ . '/../models/Order.php';
require_once __DIR__ . '/../models/Partner.php';

class OrderController extends BaseController {
    private $orderService;
    private $orderModel;

    public function __construct() {
        $this->orderService = new OrderService();
        $this->partnerModel = new Partner();
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
                'id_loja'    => filter_input(INPUT_POST, 'id_loja', FILTER_VALIDATE_INT),
                'id_cliente' => filter_input(INPUT_POST, 'id_cliente', FILTER_VALIDATE_INT),
                'produto'    => filter_input(INPUT_POST, 'produto', FILTER_SANITIZE_STRING),
                'quantidade' => filter_input(INPUT_POST, 'quantidade', FILTER_VALIDATE_INT),
                'valor'      => filter_input(INPUT_POST, 'valor', FILTER_VALIDATE_FLOAT)
            ];
            if (empty($data['id_loja']) && empty($data['id_cliente'])) {
                $this->setFlash('Informe o ID da loja ou o ID do cliente.', 'error');
                $this->index();
                return;
            }
    
            if (!empty($data['id_cliente']) && !$this->orderModel->checkClientExists($data['id_cliente'])) {
                $this->setFlash('ID do cliente não encontrado.', 'error');
                $this->index();
                return;
            }
    
            if (!empty($data['id_loja']) && !$this->partnerModel->checkPartnerExists($data['id_loja'])) {
                $this->setFlash('ID da loja não encontrado.', 'error');
                $this->index();
                return;
            }
    
            if (empty($data['produto']) || empty($data['quantidade']) || empty($data['valor'])) {
                $this->setFlash('Preencha os campos obrigatórios: produto, quantidade e valor.', 'error');
                $this->index();
                return;
            }
    
            $result = $this->orderService->createOrder($data);
            $this->setFlash($result['message'], $result['success'] ? 'success' : 'error');
            $this->index();
        }
    
        include __DIR__ . '/../views/orders/create.php';
    }

    public function edit($id_order): void {
        $id_order = filter_var($id_order, FILTER_VALIDATE_INT);
        if (!$id_order) {
            $this->setFlash('ID inválido.', 'error');
            $this->index();
        }

        $order = $this->orderModel->getOrderById($id_order);
        if (!$order) {
            $this->setFlash('Pedido não encontrado.', 'error');
            $this->index();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'id_loja'    => filter_input(INPUT_POST, 'id_loja', FILTER_VALIDATE_INT),
                'id_cliente' => filter_input(INPUT_POST, 'id_cliente', FILTER_VALIDATE_INT),
                'produto'    => filter_input(INPUT_POST, 'produto', FILTER_SANITIZE_STRING),
                'quantidade' => filter_input(INPUT_POST, 'quantidade', FILTER_VALIDATE_INT),
                'valor'      => filter_input(INPUT_POST, 'valor', FILTER_VALIDATE_FLOAT)
            ];

            if ($this->orderModel->checkClientExists($data['id_cliente'])) {
                $result = $this->orderService->updateOrder($id_order, $data);
                $this->setFlash($result['message'], $result['success'] ? 'success' : 'error');
            } else {
                $this->setFlash('Cliente não encontrado.', 'error');
            }
            $this->index();
        }

        include __DIR__ . '/../views/orders/edit.php';
    }

    public function delete($id_order): void {
        $id_order = filter_var($id_order, FILTER_VALIDATE_INT);
        if (!$id_order) {
            $this->setFlash('ID inválido.', 'error');
            $this->index();
        }

        if ($this->orderModel->deleteOrder($id_order)) {
            $this->setFlash('Pedido excluído com sucesso!', 'success');
        } else {
            $this->setFlash('Erro ao excluir pedido.', 'error');
        }
        $this->index();
    }
}
?>