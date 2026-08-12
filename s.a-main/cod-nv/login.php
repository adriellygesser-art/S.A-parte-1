<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Sistema de login</title>
    <link rel="stylesheet" href="css/style.css">
</head>


<body class="login-body">
    <div class="login-container">
        <h2>Login do Vetket</h2>        

        <form method="POST" action="verificalogin.php">
            <label for="usuario">Usuário:</label>
            <input type="text" name="usuario" id="usuario"  required>

            <label for="senha">Senha:</label>
            <input type="password" name="senha" id="senha"  required>

            <button type="submit">Entrar</button>
            <div class="conta">
                <span class="mensagem">Não tem conta?</span> <a href="cadastro.php">cadastre-se</a>   
            </div>

        </form>
    </div>
</body>
</html>
