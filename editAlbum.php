<?php
session_start();
include_once "conect.php";
include_once "functions.php";
if (!isset($_SESSION['usuario'])) header("Location: index.php");
if (isset($_GET['id_album'])) {
    header("Location: addMusicForm.php?id_album={$_GET['id_album']}");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar álbuns</title>
</head>

<body>
    <?php
    if (registroExiste($conexao, 'album', 'id_usuario', $_SESSION['usuario']['id_usuario'])) {
        $sql = mysqli_query($conexao, "SELECT * FROM album WHERE id_usuario = {$_SESSION['usuario']['id_usuario']}");
    ?>
        <table border=1>
            <tr>
                <th>Título</th>
                <th>Capa</th>
                <th>Operações</th>
            </tr>
            <?php
            while ($linha = mysqli_fetch_assoc($sql)) {
                echo "<tr>
                    <td>{$linha['titulo']}</td>
                    <td>{$linha['capa']}</td>
                    <td><a href='addMusicForm?id_album={$linha['id_album']}'>Adicionar música</a>
                    | <a href='deleteAlbum?id_album={$linha['id_album']}'>Excluir</a></td>
                </tr>";
            }
            ?>
        </table>
    <?php } else {
        echo "Você não tem nenhum álbum cadastrado. <br>";
        echo "<a href='addAlbumForm.php'>Cadastrar álbum</a>";
    }
    ?>
    <br><a href="index.php">Voltar à página inicial</a>
</body>

</html>