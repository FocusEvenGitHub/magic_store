<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Controllers\ClientController;
use App\Controllers\OrderController;
use App\Controllers\EmailController;
use App\Controllers\PartnerController;
use App\Services\ClientService;
use App\Models\Client;

// Filtrando entradas para evitar ataques
$controller = filter_input(INPUT_GET, 'controller', FILTER_SANITIZE_STRING) ?? 'client';
$action     = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING) ?? 'index';
$id         = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT) ?? null;

// Criando instância do modelo Client
$clientModel = new Client();
$clientService = new ClientService($clientModel);

$routes = [
    'client'  => fn() => new ClientController($clientService),
    'order'   => fn() => new OrderController(),
    'email'   => fn() => new EmailController(),
    'partner' => fn() => new PartnerController(),
];

// Verifica se o controlador existe
if (!array_key_exists($controller, $routes)) {
    die('Controller inválido.');
}

// Instancia o controller dinamicamente
$ctrl = $routes[$controller]();

// Verifica se a ação é válida
if (!method_exists($ctrl, $action)) {
    die('Ação inválida.');
}

// Se a ação requer um ID, ele deve ser válido
if (in_array($action, ['edit', 'delete', 'sendEmail', 'import']) && is_null($id)) {
    die('ID é obrigatório para esta ação.');
}

// Chama a ação correspondente
$id !== null ? $ctrl->{$action}($id) : $ctrl->{$action}();
