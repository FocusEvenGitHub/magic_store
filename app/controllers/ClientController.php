<?php
require_once __DIR__ . '/../models/Client.php';
require_once __DIR__ . '/../../' . 'utils/ImportExcel.php';
class ClientController {
    private $clientModel;

    public function __construct() {
        $this->clientModel = new Client();
    }

    public function index() {
        $clients = $this->clientModel->getAll();
        include __DIR__ . '/../views/clients/index.php';
    }

    public function create() {
        include __DIR__ . '/../views/clients/create.php';
    }

    public function store() {
        $data = [
            'documento' => $_POST['documento'],
            'cep' => $_POST['cep'],
            'endereco' => $_POST['endereco'],
            'bairro' => $_POST['bairro'],
            'cidade' => $_POST['cidade'],
            'uf' => $_POST['uf'],
            'telefone' => $_POST['telefone'],
            'email' => $_POST['email'],
            'ativo' => isset($_POST['ativo']) ? $_POST['ativo'] : 0
        ];

        $this->clientModel->create($data);
        header('Location: index.php?controller=client&action=index');
        exit;
    }

    public function edit() {
        if (!isset($_GET['id'])) {
            header('Location: index.php?controller=client&action=index');
            exit;
        }
    
        $id = $_GET['id'];
        $client = $this->clientModel->findById($id);
    
        if (!$client) {
            die("Cliente não encontrado!");
        }
    
        include __DIR__ . '/../views/clients/edit.php';
    }
    
    public function update() {
        if (!isset($_POST['id'])) {
            header('Location: index.php?controller=client&action=index');
            exit;
        }
    
        $id = $_POST['id'];
        $data = [
            'documento' => $_POST['documento'],
            'cep' => $_POST['cep'],
            'endereco' => $_POST['endereco'],
            'bairro' => $_POST['bairro'],
            'cidade' => $_POST['cidade'],
            'uf' => $_POST['uf'],
            'telefone' => $_POST['telefone'],
            'email' => $_POST['email'],
            'ativo' => isset($_POST['ativo']) ? 1 : 0 // Se não for enviado, assume como 0
        ];
    
        if ($this->clientModel->update($id, $data)) {
            header('Location: index.php?controller=client&action=index');
            exit;
        } else {
            die("Erro ao atualizar o cliente.");
        }
    }
    public function import() {
        if (isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['file']['tmp_name'];
            
            $clientImporter = new ClientImporter();
            
            $result = $clientImporter->importFromFile($fileTmpPath);
            
            echo "<script>alert('". $result ."');</script>";
            $this->index();
            
        } else {
            echo "Nenhum arquivo foi enviado ou ocorreu um erro.";
        }
    }

    public function delete() {
        $id = $_GET['id'];
        $this->clientModel->delete($id);
        header('Location: index.php?controller=client&action=index');
        exit;
    }
}
?>
