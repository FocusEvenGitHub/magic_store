<!DOCTYPE html>
<html lang="pt-br">
<body>
    <h1>Criar Loja</h1>
    <form action="index.php?controller=partner&action=create" method="POST">
        <label for="nome_loja">Nome da Loja:</label>
        <input type="text" name="nome_loja" required><br>
        <label for="localizacao">Localização:</label>
        <input type="text" name="localizacao" required><br>
        <button type="submit">Criar</button>
    </form>
    <a href="index.php?controller=partner&action=index">Voltar</a>
</body>
</html>