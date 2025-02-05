<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Add Client</title>
  <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body>
  <h1>Add Client</h1>
  <form action="index.php?controller=client&action=store" method="post">
    <label>Name</label>
    <input type="text" name="name">
    <label>Email</label>
    <input type="email" name="email">
    <label>Magical ID</label>
    <input type="text" name="magical_id">
    <input type="submit" value="Submit">
  </form>
</body>
</html>
