<?php
session_start();
if (!isset($_SESSION['usuario']) || (isset($_SESSION['usuario']) && $_SESSION['usuario']['adm'] == 0)) {
    header("Location: ../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADM</title>
</head>

<body>
    <a href="../index.php">Retornar a tela principal</a><br>
    <a href="./usuarios.php">Lista de usuários</a><br>
    <a href="./albuns.php">Lista de álbuns</a><br>
    <a href="./musicas.php">Lista de músicas</a><br>
    <a href="./playlists.php">Lista de playlists</a>
</body>

</html>