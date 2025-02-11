<!DOCTYPE html>
<html lang="pt-br">
<body>
    <h1>Editar Loja</h1>
    <form action="index.php?controller=partner&action=edit&id=<?= $partner['id_loja'] ?>" method="POST">
        <label for="nome_loja">Nome da Loja:</label>
        <input type="text" name="nome_loja" value="<?= htmlspecialchars($partner['nome_loja']) ?>" required><br>
        <label for="localizacao">Localização:</label>
        <input type="text" name="localizacao" value="<?= htmlspecialchars($partner['localizacao']) ?>" required><br>
        <button type="submit">Atualizar</button>
    </form>
    <a href="index.php?controller=partner&action=index">Voltar</a>
</body>
</html>