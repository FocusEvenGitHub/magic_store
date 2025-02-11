<!DOCTYPE html>
<html>
<body>
    <h1>Editar Cliente</h1>
    <form action="index.php?controller=client&action=update" method="post">
        <input type="hidden" name="id_cliente" value="<?php echo $client['id_cliente']; ?>">
        
        <label for="nome_cliente">Nome:</label>
        <input type="text" name="nome_cliente" id="nome_cliente" value="<?= htmlspecialchars($client['nome_cliente']); ?>" required><br>

        <label for="email">E-mail:</label>
        <input type="email" name="email" id="email" value="<?= htmlspecialchars($client['email']); ?>" required><br>

        <button type="submit">Salvar</button>
    </form>
</body>
</html>