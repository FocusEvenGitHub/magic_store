<!DOCTYPE html>
<html lang="pt-br">
<body>
    <a href="index.php?controller=partner&action=create">
      <i class="fas fa-plus-circle"></i> Nova Loja
    </a>

    <form action="index.php?controller=partner&action=import" method="POST" enctype="multipart/form-data" style="margin-bottom: 20px;">
        <input type="file" name="xml_file" accept=".xml" required>
        <button type="submit" class="btn-import">
            <i class="fas fa-file-import"></i> Importar Pedidos via XML
        </button>
    </form>
    <table id="partnersTable" class="display">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Localização</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($partners as $partner): ?>
            <tr>
                <td><?= $partner['id_loja'] ?></td>
                <td><?= htmlspecialchars($partner['nome_loja']) ?></td>
                <td><?= htmlspecialchars($partner['localizacao']) ?></td>
                <td class="action-icons">
                    <a href="index.php?controller=partner&action=edit&id=<?= $partner['id_loja'] ?>" class="action-edit" data-tooltip="Editar">
                        <i class="fas fa-edit"></i>
                    </a>
                    <a href="index.php?controller=partner&action=delete&id=<?= $partner['id_loja'] ?>" class="action-delete" data-tooltip="Deletar" onclick="return confirm('Tem certeza?');">
                        <i class="fas fa-trash"></i>
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <script>
        $(document).ready(function() {
            $('#loadingSpinner').show();

            var table = $('#partnersTable').DataTable({
                "paging": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "lengthMenu": [5, 10, 25, 50],
                "language": {
                    "lengthMenu": "Mostrar _MENU_ registros por página",
                    "zeroRecords": "Nenhum pedido encontrado",
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