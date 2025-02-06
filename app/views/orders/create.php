<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Create Order</title>
  <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body>
  <h1>Create New Order</h1>
  <form action="index.php?controller=order&action=create" method="POST">
    <label for="client_id">Client ID:</label>
    <input type="text" name="client_id" required><br>
    
    <label for="product_details">Product Details:</label>
    <textarea name="product_details" required></textarea><br>
    
    <label for="status">Status:</label>
    <select name="status">
      <option value="pending">Pendente</option>
      <option value="processing">Processando</option>
      <option value="shipped">Enviado</option>
      <option value="delivered">Entregue</option>
    </select><br>

    <button type="submit">Create Order</button>
  </form>
  <a href="index.php?controller=order&action=index">Back to Orders</a>
</body>
</html>
