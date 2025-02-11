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
            'nome_cliente' => filter_input(INPUT_POST, 'nome_cliente', FILTER_SANITIZE_STRING),
            'email' => filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL)
        ];
        
        if (!$data['nome_cliente'] || !$data['email']) {
            $this->setFlash('Nome e email são obrigatórios.', 'error');
            $this->index();
        }

        $result = $this->clientModel->create($data);
        $this->setFlash($result ? 'Cliente criado com sucesso!' : 'Erro ao criar cliente.', $result ? 'success' : 'error');
        $this->index();
    }

    public function edit() {
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
        $id = filter_input(INPUT_POST, 'id_cliente', FILTER_VALIDATE_INT);
        if (!$id) {
            $this->setFlash('ID inválido.', 'error');
            $this->index();
        }

        $data = [
            'nome_cliente' => filter_input(INPUT_POST, 'nome_cliente', FILTER_SANITIZE_STRING),
            'email' => filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL)
        ];
        
        if (!$data['nome_cliente'] || !$data['email']) {
            $this->setFlash('Nome e email são obrigatórios.', 'error');
            $this->index();
        }

        $result = $this->clientModel->update($id, $data);
        $this->setFlash($result ? 'Cliente atualizado com sucesso!' : 'Erro ao atualizar cliente.', $result ? 'success' : 'error');
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
            $this->setFlash('Nenhum arquivo foi enviado ou ocorreu um erro.',  'error');
            $this->index();
        }
    }

    public function delete() {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if (!$id) {
            $this->setFlash('ID inválido.', 'error');
            $this->index();
        }

        $result = $this->clientModel->delete($id);
        $this->setFlash($result ? 'Cliente excluído com sucesso!' : 'Erro ao excluir cliente.', $result ? 'success' : 'error');
        $this->index();
    }
}

?>
