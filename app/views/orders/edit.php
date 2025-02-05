<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Edit Order</title>
  <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body>
  <h1>Edit Order</h1>
  <form action="index.php?controller=order&action=update" method="post">
    <input type="hidden" name="id" value="<?php echo $order['id']; ?>">
    <label>Client ID</label>
    <input type="number" name="client_id" value="<?php echo $order['client_id']; ?>">
    <label>Product Details</label>
    <textarea name="product_details"><?php echo $order['product_details']; ?></textarea>
    <label>Status</label>
    <select name="status">
      <option value="pending" <?php if($order['status']=='pending') echo 'selected'; ?>>Pending</option>
      <option value="processing" <?php if($order['status']=='processing') echo 'selected'; ?>>Processing</option>
      <option value="shipped" <?php if($order['status']=='shipped') echo 'selected'; ?>>Shipped</option>
      <option value="delivered" <?php if($order['status']=='delivered') echo 'selected'; ?>>Delivered</option>
    </select>
    <input type="submit" value="Submit">
  </form>
</body>
</html>
