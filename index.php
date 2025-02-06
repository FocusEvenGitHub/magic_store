<?php

session_start(); 

require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/vendor/autoload.php';

$controller = $_GET['controller'] ?? 'client';
$action     = $_GET['action'] ?? 'index';
$id         = $_GET['id'] ?? null;
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Magic Store</title>
  <link rel="stylesheet" href="/public/assets/css/style.css">
</head>
<body>
  <!-- Navbar -->
  <nav>
    <ul>
      <li>
        <a href="index.php?controller=client&action=index"
           class="<?= $controller == 'client' ? 'active' : '' ?>">
           Clientes
        </a>
      </li>
      <li>
        <a href="index.php?controller=order&action=index"
           class="<?= $controller == 'order' ? 'active' : '' ?>">
           Pedidos
        </a>
      </li>
    </ul>
  </nav>

  <div class="container">
    <?php
      // Roteamento baseado no controlador e ação
      switch ($controller) {
        case 'client':
          require_once __DIR__ . '/app/controllers/ClientController.php';
          $ctrl = new ClientController();
          if (method_exists($ctrl, $action)) {
              $ctrl->{$action}();
          } else {
              die('Ação inválida para o controller client.');
          }
          break;

        case 'order':
          require_once __DIR__ . '/app/controllers/OrderController.php';
          $ctrl = new OrderController();
          
          if (($action === 'edit' || $action === 'delete') && $id !== null) {
              $ctrl->{$action}($id);
          } elseif (method_exists($ctrl, $action)) {
              $ctrl->{$action}();
          } else {
              die('Ação inválida para o controller order.');
          }
          break;
        case 'email':
          require_once __DIR__ . '/app/controllers/EmailController.php';
          $ctrl = new EmailController();
          if (($action === 'sendEmail') && $id !== null) {
              $ctrl->{$action}($id);
          } elseif (method_exists($ctrl, $action)) {
              $ctrl->{$action}();
          } else {
              die('Ação inválida para o controller email.');
          }
          break;

        default:
          die('Controller inválido.');
      }
    ?>
  </div>
</body>
</html>
