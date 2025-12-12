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
    <title>ADM - Álbuns</title>
</head>

<body>
    <a href="./adm.php">Retornar à página anterior</a>
    <h2>Álbuns</h2>
    <?php
    require_once __DIR__ . "/../conect.php";
    $id_adm = $_SESSION['usuario']['id_usuario'];
    $albunsQuery = mysqli_query($conexao, "SELECT * FROM album");
    if (mysqli_num_rows($albunsQuery) > 0) {
        echo <<<HTML
            <table border="1">
                <tr>
                    <th>ID</th>
                    <th>Titulo</th>
                    <th>Capa Atual</th>
                    <th>Nova Capa(opcional)</th>
                    <th>Operações</th>
                </tr>
        HTML;
        while ($album = mysqli_fetch_assoc($albunsQuery)) {
            echo <<<HTML
            <form action="alterarAlbum.php" method="post" enctype="multipart/form-data" style="
            display: flex;
            flex-direction: row;
            margin-bottom: 10px;
            gap: 5px
            ">
            <tr>
                <td>ID: {$album['id_album']}</td>
                <input type="hidden" name="id_album" value="{$album['id_album']}">
                <input type="hidden" name="capa_atual" value="{$album['capa']}">
                <td><input type="text" name="titulo" value="{$album['titulo']}"></td>
                <td><img src="../assets/albumCovers/{$album['capa']}" height="75px" alt="Capa do álbum {$album['titulo']}"></td>
                <td><input type="file" name="arquivo"></td>
                <td>
                    <input type="submit" value="Alterar">
                    <a href="./deletarAlbumConfirmar.php?id_album={$album['id_album']}">Deletar</a>
                </td>
            </tr>
            </form>
            HTML;
        }
        echo "</table>";
    }
    ?>
</body>

</html>