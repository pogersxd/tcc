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
    <title>ADM - Músicas</title>
</head>

<body>
    <a href="./adm.php">Retornar à página anterior</a>
    <h2>Músicas</h2>
    <?php
    require_once __DIR__ . "/../conect.php";
    $id_adm = $_SESSION['usuario']['id_usuario'];
    $musicasQuery = mysqli_query($conexao, "SELECT * FROM musica");
    if (mysqli_num_rows($musicasQuery) > 0) {
        echo <<<HTML
            <table border="1">
                <tr>
                    <th>ID</th>
                    <th>Titulo</th>
                    <th>Detalhes</th>
                    <th>Novo Arquivo(opcional)</th>
                    <th>Operações</th>
                </tr>
        HTML;
        while ($musica = mysqli_fetch_assoc($musicasQuery)) {
            echo <<<HTML
            <form action="alterarMusica.php" method="post" enctype="multipart/form-data" style="
            display: flex;
            flex-direction: row;
            margin-bottom: 10px;
            gap: 5px
            ">
            <tr>
                <td>ID: {$musica['id_musica']}</td>
                <input type="hidden" name="id_musica" value="{$musica['id_musica']}">
                <input type="hidden" name="arquivo_atual" value="{$musica['arquivo']}">
                <td><input type="text" name="titulo" value="{$musica['titulo']}"></td>
                <td><textarea name="detalhes" rows="5">{$musica['detalhes']}</textarea></td>
                <td><input type="file" name="arquivo"></td>
                <td>
                    <input type="submit" value="Alterar">
                    <a href="./deletarMusicaConfirmar.php?id_musica={$musica['id_musica']}">Deletar</a>
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