<?php
session_start();
require_once "conect.php";
require_once "functions.php";
$nome =  mysqli_real_escape_string($conexao, $_POST["nome"]);
$email = mysqli_real_escape_string($conexao, $_POST["email"]);

if (!registroExiste($conexao, 'usuario', 'email', $email)) {
    $senha = password_hash($_POST["senha"], PASSWORD_DEFAULT);
    mysqli_query($conexao, "INSERT INTO usuario (nome,email,senha) values ('$nome','$email','$senha')");
    header("Location: ./login.php");
} else {
    $_SESSION["naoUnico"] = true;
    header("Location: ./register.php");
}
