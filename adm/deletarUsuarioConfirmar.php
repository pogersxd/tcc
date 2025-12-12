<?php
session_start();
if (!isset($_SESSION['usuario']) || !isset($_GET['id_usuario']) || (isset($_SESSION['usuario']) && $_SESSION['usuario']['adm'] == 0)) {
    header("Location: ../index.php");
    exit();
}
$id_usuario = $_GET['id_usuario'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deletar usuário?</title>
</head>

<body>
    <h2>Deseja deletar o usuário</h2>
    <a href="./usuarios.php">Não </a>
    <a href="./deletarUsuario.php?id_usuario=<?= $id_usuario ?>">Sim</a>
</body>

</html>