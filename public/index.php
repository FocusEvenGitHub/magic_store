<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../vendor/autoload.php';

$controller = isset($_GET['controller']) ? $_GET['controller'] : 'client';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

switch($controller) {
  case 'client':
    require_once __DIR__ . '/../app/controllers/ClientController.php';
    $ctrl = new ClientController();
    break;
  case 'order':
    require_once __DIR__ . '/../app/controllers/OrderController.php';
    $ctrl = new OrderController();
    break;
  default:
    die('Invalid controller');
}

if(method_exists($ctrl, $action)) {
  $ctrl->{$action}();
} else {
  die('Invalid action');
}
?>
