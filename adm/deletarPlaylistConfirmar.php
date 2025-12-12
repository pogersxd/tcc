<?php
session_start();
if (!isset($_SESSION['usuario']) || !isset($_GET['id_playlist']) || (isset($_SESSION['usuario']) && $_SESSION['usuario']['adm'] == 0)) {
    header("Location: ../index.php");
    exit();
}
$id_playlist = $_GET['id_playlist'];
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deletar playlist?</title>
</head>

<body>
    <h2>Deseja deletar o playlist e suas músicas?</h2>
    <a href="./playlists.php">Não </a>
    <a href="./deletarPlaylist.php?id_playlist=<?= $id_playlist ?>">Sim</a>
</body>

</html>