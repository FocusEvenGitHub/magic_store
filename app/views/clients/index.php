<body>

    <a href="index.php?controller=client&action=create">Novo Cliente</a>

    <form action="index.php?controller=client&action=import" method="POST" enctype="multipart/form-data">
        <input type="file" name="file" accept=".xlsx">
        <button type="submit">Importar de .xlsx</button>
    </form>

    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Documento</th>
                <th>CEP</th>
                <th>Endereço</th>
                <th>Bairro</th>
                <th>Cidade</th>
                <th>UF</th>
                <th>Telefone</th>
                <th>E-mail</th>
                <th>Ativo</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($clients as $client): ?>
            <tr>
                <td><?= htmlspecialchars($client['id']); ?></td>
                <td><?= htmlspecialchars($client['nome']); ?></td>
                <td><?= htmlspecialchars($client['documento']); ?></td>
                <td><?= htmlspecialchars($client['cep']); ?></td>
                <td><?= htmlspecialchars($client['endereco']); ?></td>
                <td><?= htmlspecialchars($client['bairro']); ?></td>
                <td><?= htmlspecialchars($client['cidade']); ?></td>
                <td><?= htmlspecialchars($client['uf']); ?></td>
                <td><?= htmlspecialchars($client['telefone']); ?></td>
                <td><?= htmlspecialchars($client['email']); ?></td>
                <td><?= $client['ativo'] ? 'Sim' : 'Não'; ?></td>
                <td>
                    <a href="index.php?controller=client&action=edit&id=<?= $client['id']; ?>">Editar</a>
                    <a href="index.php?controller=client&action=delete&id=<?= $client['id']; ?>" onclick="return confirm('Tem certeza?');">Deletar</a>
                    <!-- Novo link para enviar e-mail -->
                    <a href="index.php?controller=email&action=sendEmail&id=<?= $client['id']; ?>">Enviar Email</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>


</body>
</html>
