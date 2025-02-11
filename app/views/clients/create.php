<!DOCTYPE html>
<body>
    <h1>Novo Cliente</h1>
    <form action="index.php?controller=client&action=store" method="POST">
        <label for="nome_cliente">Nome:</label>
        <input type="text" name="nome_cliente" id="nome_cliente" required><br>

        <label for="email">E-mail:</label>
        <input type="email" name="email" id="email" required><br>

        <button type="submit">Salvar</button>
        <a href="index.php">Cancelar</a>
    </form>
</body>
</html>