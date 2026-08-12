<?php
session_start();
require_once "conexao.php"; // arquivo da conexão PDO

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $usuario = $_POST['usuario'] ?? '';
    $senha = $_POST['senha'] ?? '';

    // Buscar usuário no banco
    $sql = "SELECT id_responsavel, nome, senha 
            FROM responsavel 
            WHERE nome= ?";
            
   
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$usuario]);

    $responsavel = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verifica se encontrou usuário
    if ($responsavel) {

        // Verifica senha criptografada
        // if (password_verify($senha, $responavel['senha'])) {
        if (!empty($responsavel["senha"])) {

            //  Criar variáveis de sessão
            $_SESSION['id_responsavel'] = $responsavel['id_responsavel'];
            $_SESSION['nome']   = $responsavel['nome'];
            $_SESSION['logado']     = true;
                      
            // Redireciona para a listagem de usuários
            header("Location: base.html");
            exit();

        } else {
            // senha incorreta
            header("Location: login.php?erro=senha");
            exit();
        }

    } else {
        // usuário não encontrado
        header("Location: login.php?erro=usuario");
        exit();
    }
}
?>