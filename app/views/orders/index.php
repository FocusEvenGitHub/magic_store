<?php
// Mapeamento dos status em inglês para português
$status_translation = [
    'pending' => 'Pendente',
    'processing' => 'Processando',
    'shipped' => 'Enviado',
    'delivered' => 'Entregue'
];
?>

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
                <th>Cliente</th>
                <th>Detalhes do Produto</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
          <?php foreach($orders as $order): ?>
          <tr>
            <td><?php echo $order['id']; ?></td>
            <td><?php echo htmlspecialchars($order['client_name']); ?></td>
            <td><?php echo htmlspecialchars($order['product_details']); ?></td>
            <td><?php echo $status_translation[$order['status']] ?? '<i class="fas fa-question-circle" style="color: gray;"></i> Desconhecido'; ?></td>
            <td class="action-icons">
              <a href="index.php?controller=order&action=edit&id=<?php echo $order['id']; ?>" class="action-edit" data-tooltip="Editar">
                  <i class="fas fa-edit"></i>
              </a>
              <a href="index.php?controller=order&action=delete&id=<?php echo $order['id']; ?>" class="action-delete" data-tooltip="Deletar" onclick="return confirm('Tem certeza?');">
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
