<?php
session_start();

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../vendor/autoload.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/x-icon" href="/../assets/img/favicon.ico">
  <link rel="apple-touch-icon" sizes="180x180" href="/../assets/img/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="/../assets/img/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="/../assets/img/favicon-16x16.png">
  <link rel="manifest" href="/site.webmanifest">
  <title>Loja Mágica de Tecnologia</title>
  <link rel="stylesheet" href="../assets/css/style.css">
  <link rel="stylesheet" href="../assets/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <script src="/../assets/js/jquery-3.7.1.min.js"></script>
  <script src="/../assets/js/jquery.dataTables.min.js"></script>
</head>
<body>
  <nav>
    <ul>
      <li>
        <a href="index.php?controller=client&action=index"
           class="<?= $_GET['controller'] == 'client' ? 'active' : '' ?>">
           Clientes
        </a>
      </li>
      <li>
        <a href="index.php?controller=order&action=index"
           class="<?= $_GET['controller'] == 'order' ? 'active' : '' ?>">
           Pedidos
        </a>
      </li>
      <li>
        <a href="index.php?controller=partner&action=index"
           class="<?= $_GET['controller'] == 'partner' ? 'active' : '' ?>">
           Lojas
        </a>
      </li>
    </ul>
  </nav>

  <div class="container">
    <?php if (isset($_SESSION['flash_message'])): ?>
        <div class="alert <?= $_SESSION['flash_message']['type']; ?>">
            <?= htmlspecialchars($_SESSION['flash_message']['message']); ?>
        </div>
        <?php unset($_SESSION['flash_message']); ?>
    <?php endif; ?>
    <?php require_once __DIR__ . '/../routes/web.php'; ?>
  </div>
</body>
</html>