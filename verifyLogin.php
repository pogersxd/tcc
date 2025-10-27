<?php
session_start();
include_once 'conect.php';
include_once 'functions.php';
$email = $_POST["email"];
$senha = $_POST["senha"];
if (registroExiste($conexao, 'usuario', 'email', $email)) {
    $sql = mysqli_query($conexao, "SELECT senha from usuario where email = '$email'");
    $senhaBD = mysqli_fetch_assoc($sql)['senha'];
    if (password_verify($senha, $senhaBD)) {
        $banco = mysqli_fetch_assoc(mysqli_query($conexao, "SELECT * FROM usuario where email = '$email'"));
        $_SESSION["usuario"] = $banco;
        header("Location: index.php");
    } else {
        session_start();
        $_SESSION["errou"] = true;
        header("Location: ./login");
    }
} else {
    $_SESSION["errou"] = true;
    header("Location: ./login");
}
