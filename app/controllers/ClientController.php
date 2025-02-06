<?php
require_once __DIR__ . '/../models/Client.php';
require_once __DIR__ . '/../../utils/ImportExcel.php';

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
            'nome'      => $_POST['nome'],        
            'documento' => $_POST['documento'],
            'cep'       => $_POST['cep'],
            'endereco'  => $_POST['endereco'],
            'bairro'    => $_POST['bairro'],
            'cidade'    => $_POST['cidade'],
            'uf'        => $_POST['uf'],
            'telefone'  => $_POST['telefone'],
            'email'     => $_POST['email'],
            'ativo'     => isset($_POST['ativo']) ? 1 : 0
        ];

        $this->clientModel->create($data);
        $this->index();
        exit;
    }

    public function edit() {
        if (!isset($_GET['id'])) {
            $this->index();
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
            $this->index();
            exit;
        }
    
        $id = $_POST['id'];
        $data = [
            'nome'      => $_POST['nome'],        
            'documento' => $_POST['documento'],
            'cep'       => $_POST['cep'],
            'endereco'  => $_POST['endereco'],
            'bairro'    => $_POST['bairro'],
            'cidade'    => $_POST['cidade'],
            'uf'        => $_POST['uf'],
            'telefone'  => $_POST['telefone'],
            'email'     => $_POST['email'],
            'ativo'     => isset($_POST['ativo']) ? 1 : 0
        ];
    
        if ($this->clientModel->update($id, $data)) {
            $this->index();
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
        $this->index();
        exit;
    }
}
?>
