<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Orders</title>
  <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body>
  <h1>Orders</h1>
  <a href="index.php?controller=order&action=create">Add Order</a>
  <table border="1">
    <tr>
      <th>ID</th>
      <th>Client ID</th>
      <th>Product Details</th>
      <th>Status</th>
      <th>Actions</th>
    </tr>
    <?php foreach($orders as $order): ?>
    <tr>
      <td><?php echo $order['id']; ?></td>
      <td><?php echo $order['client_id']; ?></td>
      <td><?php echo $order['product_details']; ?></td>
      <td><?php echo $order['status']; ?></td>
      <td>
        <a href="index.php?controller=order&action=edit&id=<?php echo $order['id']; ?>">Edit</a>
        <a href="index.php?controller=order&action=delete&id=<?php echo $order['id']; ?>">Delete</a>
      </td>
    </tr>
    <?php endforeach; ?>
  </table>
</body>
</html>
