<body>
    
    <a href="index.php?controller=client&action=create">Add Client</a>
    <form action="index.php?controller=client&action=import" method="POST" enctype="multipart/form-data">
        <input type="file" name="file" accept=".xlsx">
        <button type="submit">Import from XLSX</button>
    </form>

    <table border="1">
        <tr>
            <th>ID</th>
            <th>DOCUMENTO</th>
            <th>CEP</th>
            <th>ENDEREÇO</th>
            <th>BAIRRO</th>
            <th>CIDADE</th>
            <th>UF</th>
            <th>TELEFONE</th>
            <th>E-MAIL</th>
            <th>ATIVO</th>
            <th>Actions</th>
        </tr>
        <?php foreach($clients as $client): ?>
        <tr>
            <td><?php echo $client['id']; ?></td>
            <td><?php echo $client['documento']; ?></td>
            <td><?php echo $client['cep']; ?></td>
            <td><?php echo $client['endereco']; ?></td>
            <td><?php echo $client['bairro']; ?></td>
            <td><?php echo $client['cidade']; ?></td>
            <td><?php echo $client['uf']; ?></td>
            <td><?php echo $client['telefone']; ?></td>
            <td><?php echo $client['email']; ?></td>
            <td><?php echo $client['ativo'] ? 'Yes' : 'No'; ?></td>
            <td>
                <a href="index.php?controller=client&action=edit&id=<?php echo $client['id']; ?>">Edit</a>
                <a href="index.php?controller=client&action=delete&id=<?php echo $client['id']; ?>" onclick="return confirm('Tem certeza?');">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
