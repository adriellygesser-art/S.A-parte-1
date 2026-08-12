<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Sistema de login</title>
    <link rel="stylesheet" href="css/style.css">
</head>


<body class="login-body">
    <div class="login-container">
        <h2>Cadastro do responsável</h2>        

        <form method="POST" action="salvar-usuario.php">
            <label for="usuario">Usuário:</label>
            <input type="text" name="nome" id="usuario"  required>

            <label for="senha">Senha:</label>
            <input type="password" name="senha" id="senha"  required>

            <button type="submit">Cadastrar</button>
            

        </form>
    </div>
</body>
</html>
