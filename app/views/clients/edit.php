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
        
        <label>Documento:</label>
        <input type="text" name="documento" value="<?php echo htmlspecialchars($client['documento']); ?>" required><br>
        
        <label>CEP:</label>
        <input type="text" name="cep" value="<?php echo htmlspecialchars($client['cep']); ?>" required><br>
        
        <label>Endereço:</label>
        <input type="text" name="endereco" value="<?php echo htmlspecialchars($client['endereco']); ?>" required><br>
        
        <label>Bairro:</label>
        <input type="text" name="bairro" value="<?php echo htmlspecialchars($client['bairro']); ?>" required><br>
        
        <label>Cidade:</label>
        <input type="text" name="cidade" value="<?php echo htmlspecialchars($client['cidade']); ?>" required><br>
        
        <label>UF:</label>
        <input type="text" name="uf" value="<?php echo htmlspecialchars($client['uf']); ?>" required><br>
        
        <label>Telefone:</label>
        <input type="text" name="telefone" value="<?php echo htmlspecialchars($client['telefone']); ?>" required><br>
        
        <label>Email:</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($client['email']); ?>" required><br>
        
        <label>Ativo:</label>
        <input type="checkbox" name="ativo" value="1" <?php echo $client['ativo'] ? 'checked' : ''; ?>><br>

        <button type="submit">Salvar</button>
    </form>
</body>
</html>
