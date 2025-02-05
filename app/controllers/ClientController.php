<?php
require_once __DIR__ . '/../models/Client.php';

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
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'magical_id' => $_POST['magical_id']
        ];

        $this->clientModel->create($data);
        header('Location: index.php?controller=client&action=index');
        exit;
    }

    public function edit() {
        $id = $_GET['id'];
        $client = $this->clientModel->findById($id);
        include __DIR__ . '/../views/clients/edit.php';
    }

    public function update() {
        $id = $_POST['id'];
        $data = [
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'magical_id' => $_POST['magical_id']
        ];

        $this->clientModel->update($id, $data);
        header('Location: index.php?controller=client&action=index');
        exit;
    }

    public function delete() {
        $id = $_GET['id'];
        $this->clientModel->delete($id);
        header('Location: index.php?controller=client&action=index');
        exit;
    }
}
