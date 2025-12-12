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
    <title>ADM - Playlists</title>
</head>

<body>
    <a href="./adm.php">Retornar à página anterior</a>
    <h2>Playlists</h2>
    <?php
    require_once __DIR__ . "/../conect.php";
    $id_adm = $_SESSION['usuario']['id_usuario'];
    $playlistsQuery = mysqli_query($conexao, "SELECT * FROM playlist");
    if (mysqli_num_rows($playlistsQuery) > 0) {
        echo <<<HTML
            <table border="1">
                <tr>
                    <th>ID</th>
                    <th>ID dono</th>
                    <th>Titulo</th>
                    <th>Capa Atual</th>
                    <th>Nova Capa(opcional)</th>
                    <th>Operações</th>
                </tr>
        HTML;
        while ($playlist = mysqli_fetch_assoc($playlistsQuery)) {
            echo <<<HTML
            <form action="alterarPlaylist.php" method="post" enctype="multipart/form-data" style="
            display: flex;
            flex-direction: row;
            margin-bottom: 10px;
            gap: 5px
            ">
            <tr>
                <td>{$playlist['id_playlist']}</td>
                <td>{$playlist['id_usuario']}</td>
                <input type="hidden" name="id_playlist" value="{$playlist['id_playlist']}">
                <input type="hidden" name="capa_atual" value="{$playlist['capa']}">
                <td><input type="text" name="titulo" value="{$playlist['titulo']}"></td>
                <td><img src="../assets/playlistCovers/{$playlist['capa']}" height="75px" alt="Capa do playlist {$playlist['titulo']}"></td>
                <td><input type="file" name="capa"></td>
                <td>
                    <input type="submit" value="Alterar">
                    <a href="./deletarPlaylistConfirmar.php?id_playlist={$playlist['id_playlist']}">Deletar</a>
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