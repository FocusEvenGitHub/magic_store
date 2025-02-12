<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Editar Pedido</title>
  <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body>
  <h1>Editar Pedido</h1>
  <form action="index.php?controller=order&action=edit&id=<?php echo $order['id_order']; ?>" method="POST">
    <label for="id_loja">ID da Loja:</label>
    <input type="number" name="id_loja" value="<?php echo $order['id_loja']; ?>" required><br>
    
    <label for="id_cliente">ID do Cliente:</label>
    <input type="number" name="id_cliente" value="<?php echo $order['id_cliente']; ?>" required><br>
    
    <label for="produto">Produto:</label>
    <input type="text" name="produto" value="<?php echo htmlspecialchars($order['produto']); ?>" required><br>
    
    <label for="quantidade">Quantidade:</label>
    <input type="number" name="quantidade" value="<?php echo $order['quantidade']; ?>" required><br>
    
    <label for="valor">Valor:</label>
    <input type="number" step="0.01" name="valor" value="<?php echo $order['valor']; ?>" required><br>

    <button type="submit">Atualizar Pedido</button>
  </form>
  <a href="index.php?controller=order&action=index">Voltar para Pedidos</a>
</body>
</html>
<script>
$(document).ready(function() {
    const $idLoja = $('input[name="id_loja"]');
    const $idCliente = $('input[name="id_cliente"]');
    
    function updateInputStates() {
        const lojaVal = $idLoja.val().trim();
        const clienteVal = $idCliente.val().trim();
        
        $idCliente.prop('disabled', lojaVal !== '');
        $idLoja.prop('disabled', clienteVal !== '');
    }
    
    $('input[name="id_loja"], input[name="id_cliente"]').on('input', function() {
        updateInputStates();
    });
    
    updateInputStates();
});
</script>