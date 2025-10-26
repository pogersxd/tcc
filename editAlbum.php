<?php
session_start();
include_once "conect.php";
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
    $sql = mysqli_query($conexao, "SELECT * FROM album WHERE id_usuario = {$_SESSION['usuario']['id_usuario']}");
    if (mysqli_num_rows($sql) > 0) {
    ?>
        <form action="addMusicForm.php">
            <select name="id_album" required>
                <?php
                while ($linha = mysqli_fetch_assoc($sql)) {
                    echo "<option value='{$linha['id_album']}'>{$linha['titulo']}</option>";
                }
                ?>
            </select>
            <input type="submit" value="Selecionar álbum">
        </form>

    <?php } else {
        echo "Você não tem nenhum álbum cadastrado. <br>";
        echo "<a href='addAlbumForm.php'>Cadastrar álbum</a>";
    }
    ?>
    <br><a href="index.php">Voltar à página inicial</a>
</body>

</html>