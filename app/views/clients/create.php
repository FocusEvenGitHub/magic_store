<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Add Client</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body>
    <h1>Add Client</h1>
    <form action="index.php?controller=client&action=store" method="POST">
        <label>Documento:</label>
        <input type="text" name="documento" required>

        <label>CEP:</label>
        <input type="text" name="cep" required>

        <label>Endereço:</label>
        <input type="text" name="endereco" required>

        <label>Bairro:</label>
        <input type="text" name="bairro" required>

        <label>Cidade:</label>
        <input type="text" name="cidade" required>

        <label>UF:</label>
        <input type="text" name="uf" required maxlength="2">

        <label>Telefone:</label>
        <input type="text" name="telefone">

        <label>E-mail:</label>
        <input type="email" name="email" required>

        <label>Ativo:</label>
        <select name="ativo">
            <option value="1">Yes</option>
            <option value="0">No</option>
        </select>

        <button type="submit">Save</button>
        <a href="index.php">Cancel</a>
    </form>
</body>
</html>
