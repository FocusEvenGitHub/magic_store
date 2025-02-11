<?php

require_once __DIR__ . '/../app/controllers/ClientController.php';
require_once __DIR__ . '/../app/controllers/OrderController.php';
require_once __DIR__ . '/../app/controllers/EmailController.php';
require_once __DIR__ . '/../app/controllers/PartnerController.php'; 
$controller = $_GET['controller'] ?? 'client';
$action     = $_GET['action'] ?? 'index';
$id         = $_GET['id'] ?? null;

$routes = [
    'client'  => ClientController::class,
    'order'   => OrderController::class,
    'email'   => EmailController::class,
    'partner' => PartnerController::class, 
];

if (array_key_exists($controller, $routes)) {
    $ctrl = new $routes[$controller]();
    
    if (($action === 'edit' || $action === 'delete' || $action === 'sendEmail' || $action === 'import') && $id !== null) {
        if (method_exists($ctrl, $action)) {
            $ctrl->{$action}($id);
        } else {
            die('Ação inválida.');
        }
    } elseif (method_exists($ctrl, $action)) {
        $ctrl->{$action}();
    } else {
        die('Ação inválida.');
    }
} else {
    die('Controller inválido.');
}