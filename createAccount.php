<?php
session_start();
include_once "conect.php";
$nome = $_POST["nome"];
$email = $_POST["email"];
$sql = mysqli_query($conexao, "SELECT * FROM usuario WHERE email='$email'");
if (mysqli_num_rows($sql) == 0) {
    $senha = password_hash($_POST["senha"], PASSWORD_DEFAULT);
    mysqli_query($conexao, "INSERT INTO usuario (nome,email,senha) values ('$nome','$email','$senha')");
    header("Location: ./login.php");
} else {
    $_SESSION["naoUnico"] = true;
    header("Location: ./register.php");
}
