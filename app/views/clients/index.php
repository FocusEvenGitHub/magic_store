<body>
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
                <th>E-mail</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($clients as $client): ?>
            <tr>
                <td><?= htmlspecialchars($client['id_cliente']); ?></td>
                <td><?= htmlspecialchars($client['nome_cliente']); ?></td>
                <td><?= htmlspecialchars($client['email']); ?></td>
                <td class="action-icons">
                    <a href="index.php?controller=client&action=edit&id=<?= $client['id_cliente']; ?>" class="action-edit" data-tooltip="Editar">
                        <i class="fas fa-edit"></i>
                    </a>
                    <a href="index.php?controller=client&action=delete&id=<?= $client['id_cliente']; ?>" class="action-delete" data-tooltip="Deletar" onclick="return confirm('Tem certeza?');">
                        <i class="fas fa-trash"></i>
                    </a>
                    <a href="index.php?controller=email&action=sendEmail&id=<?= $client['id_cliente']; ?>" class="action-email" data-tooltip="Enviar Email">
                        <i class="fas fa-envelope"></i>
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
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
            "processing": true,  
            "initComplete": function(settings, json) {
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