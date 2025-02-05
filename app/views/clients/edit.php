<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Edit Client</title>
  <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body>
  <h1>Edit Client</h1>
  <form action="index.php?controller=client&action=update" method="post">
    <input type="hidden" name="id" value="<?php echo $client['id']; ?>">
    <label>Name</label>
    <input type="text" name="name" value="<?php echo $client['name']; ?>">
    <label>Email</label>
    <input type="email" name="email" value="<?php echo $client['email']; ?>">
    <label>Magical ID</label>
    <input type="text" name="magical_id" value="<?php echo $client['magical_id']; ?>">
    <input type="submit" value="Submit">
  </form>
</body>
</html>
