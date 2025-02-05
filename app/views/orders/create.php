<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Add Order</title>
  <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body>
  <h1>Add Order</h1>
  <form action="index.php?controller=order&action=store" method="post">
    <label>Client ID</label>
    <input type="number" name="client_id">
    <label>Product Details</label>
    <textarea name="product_details"></textarea>
    <label>Status</label>
    <select name="status">
      <option value="pending">Pending</option>
      <option value="processing">Processing</option>
      <option value="shipped">Shipped</option>
      <option value="delivered">Delivered</option>
    </select>
    <input type="submit" value="Submit">
  </form>
</body>
</html>
