<?php
session_start();
if (!isset($_SESSION['usuario']) || !isset($_GET['id_musica']) || (isset($_SESSION['usuario']) && $_SESSION['usuario']['adm'] == 0)) {
    header("Location: ../index.php");
    exit();
}
$id_musica = $_GET['id_musica'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deletar música?</title>
</head>

<body>
    <h2>Deseja deletar a música</h2>
    <a href="./musicas.php">Não </a>
    <a href="./deletarMusica.php?id_musica=<?= $id_musica ?>">Sim</a>
</body>

</html>