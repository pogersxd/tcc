<?php
session_start();
include_once "conect.php";
include_once "functions.php";
$nome = $_POST["nome"];
$email = $_POST["email"];

if (!registroExiste($conexao, 'usuario', 'email', $email)) {
    $senha = password_hash($_POST["senha"], PASSWORD_DEFAULT);
    mysqli_query($conexao, "INSERT INTO usuario (nome,email,senha) values ('$nome','$email','$senha')");
    header("Location: ./login.php");
} else {
    $_SESSION["naoUnico"] = true;
    header("Location: ./register.php");
}
