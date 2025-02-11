<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Confirmar Importação</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <h1>Confirmar Valores dos Pedidos</h1>
    <form method="POST">
        <table class="import-preview">
            <thead>
                <tr>
                    <th>Loja</th>
                    <th>Produto</th>
                    <th>Quantidade</th>
                    <th>Valor Unitário</th>
                </tr>
            </thead>
            <tbody>
                <?php if (isset($_SESSION['import_data']['pedidos']) && is_array($_SESSION['import_data']['pedidos'])): ?>
                    <?php foreach ($_SESSION['import_data']['pedidos'] as $key => $pedido): ?>
                        <tr>
                            <td><?= htmlspecialchars($pedido['nome_loja']) ?></td>
                            <td><?= htmlspecialchars($pedido['produto']) ?></td>
                            <td><?= $pedido['quantidade'] ?></td>
                            <td>
                                <input type="number" step="0.01" 
                                       name="valores[<?= $key ?>]" 
                                       placeholder="Digite o valor" 
                                       required>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" style="text-align: center; color: red;">
                            Nenhum pedido encontrado para importação. Por favor, verifique o arquivo XML.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <div class="form-actions">
            <button type="submit" name="confirm" class="btn-confirm">
                <i class="fas fa-check"></i> Confirmar Importação
            </button>
            <a href="index.php?controller=partner&action=index" class="btn-cancel">
                <i class="fas fa-times"></i> Cancelar
            </a>
        </div>
    </form>
    <script>
    document.querySelector('form').addEventListener('submit', function(e) {
        document.getElementById('loadingSpinner').style.display = 'block';
    });
    </script>
</body>
</html>