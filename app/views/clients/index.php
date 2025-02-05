<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Clients</title>
  <link rel="stylesheet" type="text/css" href="../css/style.css">
  <script src="../js/script.js"></script>
</head>
<body>
  <h1>Clients</h1>
  <a href="index.php?controller=client&action=create">Add Client</a>
  <table border="1">
    <tr>
      <th>ID</th>
      <th>Name</th>
      <th>Email</th>
      <th>Magical ID</th>
      <th>Actions</th>
    </tr>
    <?php foreach($clients as $client): ?>
    <tr>
      <td><?php echo $client['id']; ?></td>
      <td><?php echo $client['name']; ?></td>
      <td><?php echo $client['email']; ?></td>
      <td><?php echo $client['magical_id']; ?></td>
      <td>
        <a href="index.php?controller=client&action=edit&id=<?php echo $client['id']; ?>">Edit</a>
        <a href="index.php?controller=client&action=delete&id=<?php echo $client['id']; ?>">Delete</a>
      </td>
    </tr>
    <?php endforeach; ?>
  </table>
</body>
</html>
