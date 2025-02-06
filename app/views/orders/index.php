<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <title>Pedidos</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body>

    <a href="index.php?controller=order&action=create">Novo Pedido</a>

    <table class="table" border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Detalhes do Produto</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
          <?php foreach($orders as $order): ?>
          <tr>
            <td><?php echo $order['id']; ?></td>
            <td><?php echo htmlspecialchars($order['client_name']); ?></td>
            <td><?php echo htmlspecialchars($order['product_details']); ?></td>
            <td><?php echo htmlspecialchars($order['status']); ?></td>
            <td>
              <a href="index.php?controller=order&action=edit&id=<?php echo $order['id']; ?>">Editar</a>
              <a href="index.php?controller=order&action=delete&id=<?php echo $order['id']; ?>">Deletar</a>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
    </table>

</body>
</html>
