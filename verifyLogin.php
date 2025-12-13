<?php
header("Content-Type: application/json");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/conect.php';
require_once __DIR__ . '/functions.php';

$email = $_POST["email"];
$senha = $_POST["senha"];
$response = [];
if (registroExiste($conexao, 'usuario', 'email', $email)) {
    $sql = mysqli_query($conexao, "SELECT senha from usuario where email = '$email'");
    $senhaBD = mysqli_fetch_assoc($sql)['senha'];
    if (password_verify($senha, $senhaBD)) {
        $banco = mysqli_fetch_assoc(mysqli_query($conexao, "SELECT * FROM usuario where email = '$email'"));
        $_SESSION["usuario"] = $banco;
        $response["status"] = "success";
        $response["nextComponent"] = "login";
        $response["message"] = "";
        $response["reloadPage"] = true;
    } else {
        $response["status"] = "error";
        $response["message"] = "Email ou senha incorretos.";
        $response["nextComponent"] = "login";
    }
} else {
    $response["status"] = "error";
    $response["message"] = "Email ou senha incorretos.";
    $response["nextComponent"] = "login";
}
echo json_encode($response);
