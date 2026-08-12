<?php
require "conexao.php";

$nome   = $_POST['nome'];
$senha  = $_POST['senha'];
$email  = "";


// CRIPTOGRAFAR SENHA (bcrypt automático)
//$senhaCriptografada = password_hash($senha, PASSWORD_DEFAULT);


// Inserir no banco
$sql = "INSERT INTO responsavel 
        (nome, email, senha)
        VALUES (:nome, :email, :senha)";

$stmt = $pdo->prepare($sql);
$stmt->bindValue(":nome", $nome);
$stmt->bindValue(":email", $email);
$stmt->bindValue(":senha", $senha);

$stmt->execute();

echo "<h2>Usuário cadastrado com sucesso!</h2>";
echo "<a href='login.php'>Voltar</a>";
?>