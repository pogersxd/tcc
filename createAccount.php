<?php
require_once __DIR__ . "/conect.php";
require_once __DIR__ . "/functions.php";

header("Content-Type: application/json");
$nome =  mysqli_real_escape_string($conexao, $_POST["nome"]);
$email = mysqli_real_escape_string($conexao, $_POST["email"]);
$response = [];
if (!isset($_POST['aceitou_termos'])) {
    $response["status"] = "error";
    $response["message"] = "Você precisa aceitar os termos de uso.";
    $response["nextComponent"] = "register";
} else {
    if (!registroExiste($conexao, 'usuario', 'email', $email)) {
        $senha = password_hash($_POST["senha"], PASSWORD_DEFAULT);
        mysqli_query($conexao, "INSERT INTO usuario (nome,email,senha) values ('$nome','$email','$senha')");
        $response["status"] = "success";
        $response["message"] = "Conta criada com sucesso!";
        $response["nextComponent"] = "login";
    } else {
        $response["status"] = "error";
        $response["message"] = "Já existe uma conta com esse email.";
        $response["nextComponent"] = "register";
    }
}
echo json_encode($response);
