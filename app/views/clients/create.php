<!DOCTYPE html>
<body>
    <h1>Novo Client</h1>
    <form action="index.php?controller=client&action=store" method="POST">
        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" required><br>

        <label>Documento:</label>
        <input type="text" name="documento" required>

        <label>CEP:</label>
        <input type="text" name="cep" required>

        <label>Endereço:</label>
        <input type="text" name="endereco" required>

        <label>Bairro:</label>
        <input type="text" name="bairro" required>

        <label>Cidade:</label>
        <input type="text" name="cidade" required>

        <label>UF:</label>
        <input type="text" name="uf" required maxlength="2">

        <label>Telefone:</label>
        <input type="text" name="telefone">

        <label>E-mail:</label>
        <input type="email" name="email" required>

        <label>Ativo:</label>
        <select style="width: auto;" name="ativo">
            <option value="1">Yes</option>
            <option value="0">No</option>
        </select>

        <button type="submit">Salvar</button>
        <a href="index.php">Cancelar</a>
    </form>
</body>
</html>
