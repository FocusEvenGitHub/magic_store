<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Edit Order</title>
  <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body>
  <h1>Edit Order</h1>
  <form action="index.php?controller=order&action=edit&id=<?php echo $order['id']; ?>" method="POST">
    <label for="client_id">Client ID:</label>
    <input type="text" name="client_id" value="<?php echo $order['client_id']; ?>" required><br>
    
    <label for="product_details">Product Details:</label>
    <textarea name="product_details" required><?php echo $order['product_details']; ?></textarea><br>
    
    <label for="status">Status:</label>
    <select name="status">
      <option value="pending" <?php if($order['status'] == 'pending') echo 'selected'; ?>>Pending</option>
      <option value="processing" <?php if($order['status'] == 'processing') echo 'selected'; ?>>Processing</option>
      <option value="shipped" <?php if($order['status'] == 'shipped') echo 'selected'; ?>>Shipped</option>
      <option value="delivered" <?php if($order['status'] == 'delivered') echo 'selected'; ?>>Delivered</option>
    </select><br>

    <button type="submit">Update Order</button>
  </form>
  <a href="index.php?controller=order&action=index">Back to Orders</a>
</body>
</html>
