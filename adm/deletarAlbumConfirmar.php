<?php
session_start();
if (!isset($_SESSION['usuario']) || !isset($_GET['id_album']) || (isset($_SESSION['usuario']) && $_SESSION['usuario']['adm'] == 0)) {
    header("Location: ../index.php");
    exit();
}
$id_album = $_GET['id_album'];
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deletar álbum?</title>
</head>

<body>
    <h2>Deseja deletar o Álbum e suas músicas?</h2>
    <a href="./albuns.php">Não </a>
    <a href="./deletarAlbum.php?id_album=<?= $id_album ?>">Sim</a>
</body>

</html>