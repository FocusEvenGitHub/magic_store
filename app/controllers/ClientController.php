<?php
require_once __DIR__ . '/../models/Client.php';
require_once __DIR__ . '/../../utils/ImportExcel.php';

class ClientController {
    private $clientModel;

    public function __construct() {
        $this->clientModel = new Client();
    }

    private function setFlash($message, $type = 'success') {
        $_SESSION['flash_message'] = ['message' => $message, 'type' => $type];
    }

    private function redirectToIndex() {
        $this->index();
        exit;
    }

    public function index() {
        $clients = $this->clientModel->getAll();
        include __DIR__ . '/../views/clients/index.php';
    }

    public function create() {
        include __DIR__ . '/../views/clients/create.php';
    }

    public function store() {
        $data = [];
        $data['nome']      = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
        $data['documento'] = filter_input(INPUT_POST, 'documento', FILTER_SANITIZE_STRING);
        $data['cep']       = filter_input(INPUT_POST, 'cep', FILTER_SANITIZE_STRING);
        $data['endereco']  = filter_input(INPUT_POST, 'endereco', FILTER_SANITIZE_STRING);
        $data['bairro']    = filter_input(INPUT_POST, 'bairro', FILTER_SANITIZE_STRING);
        $data['cidade']    = filter_input(INPUT_POST, 'cidade', FILTER_SANITIZE_STRING);
        $data['uf']        = filter_input(INPUT_POST, 'uf', FILTER_SANITIZE_STRING);
        $data['telefone']  = filter_input(INPUT_POST, 'telefone', FILTER_SANITIZE_STRING);
        $data['email']     = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $data['ativo']     = isset($_POST['ativo']) ? 1 : 0;
        
        if (empty($data['nome']) || empty($data['documento']) || empty($data['email'])) {
            $this->setFlash('Nome, Documento e E-mail são obrigatórios.', 'error');
            $this->redirectToIndex();
        }
        
        $result = $this->clientModel->create($data);
        if ($result) {
            $this->setFlash('Cliente criado com sucesso!');
        } else {
            $this->setFlash('Erro ao criar cliente.', 'error');
        }
        $this->redirectToIndex();
    }

    public function edit() {
        if (!isset($_GET['id'])) {
            $this->redirectToIndex();
        }
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if (!$id) {
            $this->setFlash('ID inválido.', 'error');
            $this->redirectToIndex();
        }
        $client = $this->clientModel->findById($id);
        if (!$client) {
            $this->setFlash('Cliente não encontrado.', 'error');
            $this->redirectToIndex();
        }
        include __DIR__ . '/../views/clients/edit.php';
    }
    
    public function update() {
        if (!isset($_POST['id'])) {
            $this->redirectToIndex();
        }
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        if (!$id) {
            $this->setFlash('ID inválido.', 'error');
            $this->redirectToIndex();
        }
        $data = [];
        $data['nome']      = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
        $data['documento'] = filter_input(INPUT_POST, 'documento', FILTER_SANITIZE_STRING);
        $data['cep']       = filter_input(INPUT_POST, 'cep', FILTER_SANITIZE_STRING);
        $data['endereco']  = filter_input(INPUT_POST, 'endereco', FILTER_SANITIZE_STRING);
        $data['bairro']    = filter_input(INPUT_POST, 'bairro', FILTER_SANITIZE_STRING);
        $data['cidade']    = filter_input(INPUT_POST, 'cidade', FILTER_SANITIZE_STRING);
        $data['uf']        = filter_input(INPUT_POST, 'uf', FILTER_SANITIZE_STRING);
        $data['telefone']  = filter_input(INPUT_POST, 'telefone', FILTER_SANITIZE_STRING);
        $data['email']     = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $data['ativo']     = isset($_POST['ativo']) ? 1 : 0;
        
        if (empty($data['nome']) || empty($data['documento']) || empty($data['email'])) {
            $this->setFlash('Nome, Documento e E-mail são obrigatórios.', 'error');
            $this->redirectToIndex();
        }
        
        if ($this->clientModel->update($id, $data)) {
            $this->setFlash('Cliente atualizado com sucesso!');
        } else {
            $this->setFlash('Erro ao atualizar cliente.', 'error');
        }
        $this->redirectToIndex();
    }

    public function import() {
        if (isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['file']['tmp_name'];
            $clientImporter = new ClientImporter();
            $result = $clientImporter->importFromFile($fileTmpPath);
            $this->setFlash($result);
            $this->redirectToIndex();
        } else {
            echo "Nenhum arquivo foi enviado ou ocorreu um erro.";
        }
    }

    public function delete() {
        if (!isset($_GET['id'])) {
            $this->redirectToIndex();
        }
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if (!$id) {
            $this->setFlash('ID inválido.', 'error');
            $this->redirectToIndex();
        }
        if ($this->clientModel->delete($id)) {
            $this->setFlash('Cliente excluído com sucesso!');
        } else {
            $this->setFlash('Erro ao excluir cliente.', 'error');
        }
        $this->redirectToIndex();
    }
}
?>
