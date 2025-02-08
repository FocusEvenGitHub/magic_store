<?php
require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../models/Client.php';
require_once __DIR__ . '/../services/ClientService.php';
require_once __DIR__ . '/../../utils/ImportExcel.php';

class ClientController extends BaseController {
    private $clientService;
    private $clientModel;

    public function __construct() {
        $this->clientService = new ClientService();
        $this->clientModel = new Client();
    }

    public function index() {
        $clients = $this->clientModel->getAll();
        include __DIR__ . '/../views/clients/index.php';
        exit;
    }

    public function create() {
        include __DIR__ . '/../views/clients/create.php';
        exit;
    }

    public function store() {
        $data = [
            'nome'      => filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING),
            'documento' => filter_input(INPUT_POST, 'documento', FILTER_SANITIZE_STRING),
            'cep'       => filter_input(INPUT_POST, 'cep', FILTER_SANITIZE_STRING),
            'endereco'  => filter_input(INPUT_POST, 'endereco', FILTER_SANITIZE_STRING),
            'bairro'    => filter_input(INPUT_POST, 'bairro', FILTER_SANITIZE_STRING),
            'cidade'    => filter_input(INPUT_POST, 'cidade', FILTER_SANITIZE_STRING),
            'uf'        => filter_input(INPUT_POST, 'uf', FILTER_SANITIZE_STRING),
            'telefone'  => filter_input(INPUT_POST, 'telefone', FILTER_SANITIZE_STRING),
            'email'     => filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL),
            'ativo'     => isset($_POST['ativo']) ? 1 : 0
        ];

        $result = $this->clientService->createClient($data);
        $this->setFlash($result['message'], $result['success'] ? 'success' : 'error');
        $this->index();
    }

    public function edit() {
        if (!isset($_GET['id'])) {
            $this->index();
        }
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if (!$id) {
            $this->setFlash('ID inválido.', 'error');
            $this->index();
        }
        $client = $this->clientModel->findById($id);
        if (!$client) {
            $this->setFlash('Cliente não encontrado.', 'error');
            $this->index();
        }
        include __DIR__ . '/../views/clients/edit.php';
    }

    public function update() {
        if (!isset($_POST['id'])) {
            $this->index();
        }
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        if (!$id) {
            $this->setFlash('ID inválido.', 'error');
            $this->index();
        }
        $data = [
            'nome'      => filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING),
            'documento' => filter_input(INPUT_POST, 'documento', FILTER_SANITIZE_STRING),
            'cep'       => filter_input(INPUT_POST, 'cep', FILTER_SANITIZE_STRING),
            'endereco'  => filter_input(INPUT_POST, 'endereco', FILTER_SANITIZE_STRING),
            'bairro'    => filter_input(INPUT_POST, 'bairro', FILTER_SANITIZE_STRING),
            'cidade'    => filter_input(INPUT_POST, 'cidade', FILTER_SANITIZE_STRING),
            'uf'        => filter_input(INPUT_POST, 'uf', FILTER_SANITIZE_STRING),
            'telefone'  => filter_input(INPUT_POST, 'telefone', FILTER_SANITIZE_STRING),
            'email'     => filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL),
            'ativo'     => isset($_POST['ativo']) ? 1 : 0
        ];

        $result = $this->clientService->updateClient($id, $data);
        $this->setFlash($result['message'], $result['success'] ? 'success' : 'error');
        $this->index();
    }

    public function import() {
        if (isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['file']['tmp_name'];
            $clientImporter = new ClientImporter();
            $result = $clientImporter->importFromFile($fileTmpPath);
            $this->setFlash($result);
            $this->index();
        } else {
            echo "Nenhum arquivo foi enviado ou ocorreu um erro.";
        }
    }

    public function delete() {
        if (!isset($_GET['id'])) {
            $this->index();
        }
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if (!$id) {
            $this->setFlash('ID inválido.', 'error');
            $this->index();
        }
        if ($this->clientModel->delete($id)) {
            $this->setFlash('Cliente excluído com sucesso!');
        } else {
            $this->setFlash('Erro ao excluir cliente.', 'error');
        }
        $this->index();
    }
}
?>
