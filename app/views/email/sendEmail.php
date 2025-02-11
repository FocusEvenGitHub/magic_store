<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <title>Enviar E-mail para <?= htmlspecialchars($client['nome']); ?></title>
    <link rel="stylesheet" type="text/css" href="/public/assets/css/style.css">
</head>
<body>
    <h2>Enviar E-mail para <?= htmlspecialchars($client['nome_cliente']); ?></h2>
    <h6>E-mail: <?= htmlspecialchars($client['email']); ?></h6>
    <form action="index.php?controller=email&action=sendEmail&id=<?= $client['id_cliente']; ?>" method="POST">
        <label for="subject">Assunto:</label>
        <input type="text" name="subject" id="subject" required><br>

        <label for="message">Mensagem:</label>
        <textarea name="message" id="message" required></textarea><br>

        <button type="submit">Enviar E-mail</button>
    </form>
</body>
</html>
