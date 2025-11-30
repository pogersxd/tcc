<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "conect.php";
require_once "functions.php";

header("Content-Type: application/json");
$nome =  mysqli_real_escape_string($conexao, $_POST["nome"]);
$email = mysqli_real_escape_string($conexao, $_POST["email"]);
$response = [];
if (!registroExiste($conexao, 'usuario', 'email', $email)) {
    $senha = password_hash($_POST["senha"], PASSWORD_DEFAULT);
    mysqli_query($conexao, "INSERT INTO usuario (nome,email,senha) values ('$nome','$email','$senha')");
    $response["status"] = "success";
    $response["mensagem"] = "Conta criada com sucesso!";
    $response["nextComponent"] = "login";
} else {
    $response["status"] = "error";
    $response["mensagem"] = "Já existe uma conta com esse email.";
    $response["nextComponent"] = "register";
}
echo json_encode($response);
