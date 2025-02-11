<?php
require_once __DIR__ . '/../services/PartnerImportService.php';
require_once __DIR__ . '/../services/PartnerService.php';
require_once __DIR__ . '/../services/OrderService.php';

class PartnerController extends BaseController {
    private $partnerService;
    private $orderService;

    public function __construct() {
        $this->partnerService = new PartnerService();
        $this->orderService = new orderService();
    }

    public function index(): void {
        $partners = $this->partnerService->getAllPartners();
        include __DIR__ . '/../views/partners/index.php';
    }

    public function create(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nome_loja'   => filter_input(INPUT_POST, 'nome_loja', FILTER_SANITIZE_STRING),
                'localizacao' => filter_input(INPUT_POST, 'localizacao', FILTER_SANITIZE_STRING)
            ];

            $result = $this->partnerService->createPartner($data);
            $this->setFlash($result['message'], $result['success'] ? 'success' : 'error');
            $this->index();
            exit;
        }

        include __DIR__ . '/../views/partners/create.php';
    }

    public function edit(int $id_loja): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nome_loja'   => filter_input(INPUT_POST, 'nome_loja', FILTER_SANITIZE_STRING),
                'localizacao' => filter_input(INPUT_POST, 'localizacao', FILTER_SANITIZE_STRING)
            ];

            $result = $this->partnerService->updatePartner($id_loja, $data);
            $this->setFlash($result['message'], $result['success'] ? 'success' : 'error');
            $this->index();
            exit;
        }

        $partner = $this->partnerService->getPartnerById($id_loja);
        if (!$partner) {
            $this->setFlash('Loja não encontrada.', 'error');
            $this->index();
            exit;
        }

        include __DIR__ . '/../views/partners/edit.php';
    }

    public function delete(int $id_loja): void {
        $result = $this->partnerService->deletePartner($id_loja);
        $this->setFlash($result['message'], $result['success'] ? 'success' : 'error');
        $this->index();
        exit;
    }
    public function import(): void {
        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (isset($_FILES['xml_file'])) {
                    $xmlContent = file_get_contents($_FILES['xml_file']['tmp_name']);
                    $_SESSION['import_data'] = (new PartnerImportService())->prepareImport($xmlContent);
                    $this->showConfirmationView();
                    return;
                }
    
                if (isset($_POST['confirm'])) {
                    $result = (new PartnerImportService())->processImport(
                        $_SESSION['import_data'], 
                        $_POST['valores']
                    );
                    
                    $this->setFlash(
                        "Pedidos importados: {$result['success']}. Erros: {$result['errors']}", 
                        $result['errors'] > 0 ? 'warning' : 'success'
                    );
                    
                    unset($_SESSION['import_data']);
                    $this->index();
                    exit;
                }
            }
        } catch (Exception $e) {
            $this->setFlash("Erro na importação: " . $e->getMessage(), 'error');
        }
        
        $this->index();
    }
    
    private function showConfirmationView(): void {
        include __DIR__ . '/../views/partners/import_confirm.php';
        exit;
    }

    
}
?>