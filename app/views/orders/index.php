<!DOCTYPE html>
<html lang="pt-br">
<body>
    <div id="loadingSpinner">
        <i class="fas fa-spinner fa-spin"></i> Carregando dados...
    </div>

    <a href="index.php?controller=order&action=create">
      <i class="fas fa-plus-circle"></i> Novo Pedido
    </a>
    <table id="ordersTable" class="display">
        <thead>
            <tr>
                <th>ID</th>
                <th>Loja</th>
                <th>Cliente</th>
                <th>Produto</th>
                <th>Quantidade</th>
                <th>Valor</th>
                <th>Última Atualização</th>
                <th>Ações</th>
            </tr>
        </thead>
            <tbody>
            <?php foreach($orders as $order): ?>
            <tr>
                <td><?php echo $order['id_order']; ?></td>
                <td><?php echo htmlspecialchars($order['nome_loja'] ?? '- -'); ?></td>
                <td><?php echo htmlspecialchars($order['nome_cliente'] ?? '- -'); ?></td>
                <td><?php echo htmlspecialchars($order['produto']); ?></td>
                <td><?php echo htmlspecialchars($order['quantidade']); ?></td>
                <td><?php echo 'R$ ' . number_format($order['valor'], 2, ',', '.'); ?></td>
                <td><?php echo date('d/m/Y H:i', strtotime($order['ultima_atualizacao'])); ?></td>
                <td class="action-icons">
                    <a href="index.php?controller=order&action=edit&id=<?php echo $order['id_order']; ?>" class="action-edit" data-tooltip="Editar">
                        <i class="fas fa-edit"></i>
                    </a>
                    <a href="index.php?controller=order&action=delete&id=<?php echo $order['id_order']; ?>" class="action-delete" data-tooltip="Deletar" onclick="return confirm('Tem certeza?');">
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

            var table = $('#ordersTable').DataTable({
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