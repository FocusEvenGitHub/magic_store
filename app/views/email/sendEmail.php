<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <title>Enviar E-mail para <?= htmlspecialchars($client['nome']); ?></title>
    <link rel="stylesheet" type="text/css" href="/public/assets/css/style.css">
</head>
<body>
    <h1>Enviar E-mail para <?= htmlspecialchars($client['nome']); ?></h1>
    <h6>Enviar E-mail para <?= htmlspecialchars($client['email']); ?></h6>
    <form action="index.php?controller=email&action=sendEmail&id=<?= $client['id']; ?>" method="POST">
        <label for="subject">Assunto:</label>
        <input type="text" name="subject" id="subject" required><br><br>
        
        <label for="message">Mensagem:</label><br>
        <textarea name="message" id="message" cols="50" rows="10" required></textarea><br><br>
        
        <button type="submit">Enviar E-mail</button>
    </form>
</body>
</html>
