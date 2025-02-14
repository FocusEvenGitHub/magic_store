<?php

namespace App\Controllers;

use App\Services\ClientService;
use App\Controllers\BaseController;

class ClientController extends BaseController
{
    private ClientService $clientService;

    public function __construct(ClientService $clientService)
    {
        $this->clientService = $clientService;
    }

    public function index()
    {
        $clients = $this->clientService->getAllClients();
        $this->render('clients/index', ['clients' => $clients]);
    }

    public function create()
    {
        $this->render('clients/create');
    }

    public function store()
    {
        $data = [
            'nome'  => filter_input(INPUT_POST, 'nome_cliente', FILTER_SANITIZE_STRING),
            'email' => filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL)
        ];

        $result = $this->clientService->createClient($data);
        $this->redirectWithMessage('clients', $result['message'], $result['success']);
    }

    public function edit()
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if (!$id) {
            $this->redirectWithMessage('clients', 'ID inválido.', false);
        }

        $client = $this->clientService->getClientById($id);
        if (!$client) {
            $this->redirectWithMessage('clients', 'Cliente não encontrado.', false);
        }

        $this->render('clients/edit', ['client' => $client]);
    }

    public function update()
    {
        $id = filter_input(INPUT_POST, 'id_cliente', FILTER_VALIDATE_INT);
        $data = [
            'nome'  => filter_input(INPUT_POST, 'nome_cliente', FILTER_SANITIZE_STRING),
            'email' => filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL)
        ];

        $result = $this->clientService->updateClient($id, $data);
        $this->redirectWithMessage('clients', $result['message'], $result['success']);
    }

    public function delete()
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $result = $this->clientService->deleteClient($id);
        $this->redirectWithMessage('clients', $result['message'], $result['success']);
    }

    private function redirectWithMessage(string $route, string $message, bool $success)
    {
        $this->setFlash($message, $success ? 'success' : 'error');
        $this->redirect($route);
    }
}
