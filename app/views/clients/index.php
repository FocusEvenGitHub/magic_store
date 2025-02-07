<body>
<div class="container">
    <?php if (isset($_SESSION['flash_message'])): ?>
        <div class="alert <?= $_SESSION['flash_message']['type']; ?>">
            <?= htmlspecialchars($_SESSION['flash_message']['message']); ?>
        </div>
        <?php unset($_SESSION['flash_message']); ?>
    <?php endif; ?>

    <a href="index.php?controller=client&action=create"> 
        <i class="fas fa-plus-circle"></i>
        Novo Cliente
    </a>

    <form action="index.php?controller=client&action=import" method="POST" enctype="multipart/form-data" style="margin-top: 10px;">
        <input type="file" name="file" accept=".xlsx">
        <button type="submit">Importar de .xlsx</button>
    </form>

    <div id="loadingSpinner" style="">
        <i class="fas fa-spinner fa-spin"></i> Carregando dados...
    </div>

    <table id="clientsTable" class="display">
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
                <td class="action-icons">
                    <a href="index.php?controller=client&action=edit&id=<?= $client['id']; ?>" class="action-edit" data-tooltip="Editar">
                        <i class="fas fa-edit"></i>
                    </a>
                    <a href="index.php?controller=client&action=delete&id=<?= $client['id']; ?>" class="action-delete" data-tooltip="Deletar" onclick="return confirm('Tem certeza?');">
                        <i class="fas fa-trash"></i>
                    </a>
                    <a href="index.php?controller=email&action=sendEmail&id=<?= $client['id']; ?>" class="action-email" data-tooltip="Enviar Email">
                        <i class="fas fa-envelope"></i>
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function() {

    var table = $('#clientsTable').DataTable({
        "paging": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "lengthMenu": [5, 10, 25, 50],
        "language": {
            "lengthMenu": "Mostrar _MENU_ registros por página",
            "zeroRecords": "Nenhum cliente encontrado",
            "info": "Mostrando página _PAGE_ de _PAGES_",
            "infoEmpty": "Nenhum dado disponível",
            "infoFiltered": "(filtrado de _MAX_ registros no total)",
            "search": "Pesquisar:",
            "paginate": {
                "first": "Primeiro",
                "last": "Último",
                "next": "Próximo",
                "previous": "Anterior"
            }
        },
        "processing": true,  // Ativa o processamento da tabela
        "initComplete": function(settings, json) {
            // Esconde o spinner após a inicialização completa da tabela
            $('#loadingSpinner').hide();
        },
        "drawCallback": function(settings) {
            $('#loadingSpinner').hide();
        }
    });
});

</script>

</body>
</html>
