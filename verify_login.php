<?php
session_start();
include_once 'conect.php';
$email = $_POST["email"];
$senha = $_POST["senha"];
$sql = mysqli_query($conexao, "SELECT senha from usuario where email = '$email'");
if (mysqli_num_rows($sql) > 0) {
    $senhaBD = mysqli_fetch_assoc($sql)['senha'];
    if (password_verify($senha, $senhaBD)) {
        $banco = mysqli_query($conexao, "SELECT * FROM usuario where email = '$email'");
        $_SESSION["email"] = $email;
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
