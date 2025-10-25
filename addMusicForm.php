<?php
session_start();
include_once "conect.php";
if (!isset($_SESSION['usuario']) or !isset($_GET['id_album'])) header("Location: index.php");
$id_album = $_GET['id_album'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Música ao álbum</title>
</head>

<body>
    <h1>Músicas já presentes no álbum: </h1>
    <?php
    $sql = mysqli_query($conexao, "SELECT * FROM musica WHERE id_album = $id_album");
    if (mysqli_num_rows($sql) > 0) {
        echo "<tr>
            <th>Título</th>
            <th>Arquivo</th>
            <th>Duração</th>
            <th>Detalhes</th>
        </tr>";
        while ($linha = mysqli_fetch_assoc($sql)) {
            echo "<tr>
                <td>{$linha['titulo']}</td>
                <td>{$linha['arquivo']}</td>
                <td>{$linha['duracao']}</td>
                <td>{$linha['detalhes']}</td>
            </tr>";
        }
    } else {
        echo "<h4>Nenhuma.</h5>";
    }
    ?>
    <h1>Adicionar música ao álbum</h1>
    <form action="addMusica.php" method="post" enctype="multipart/form-data">
        Título: <input type="text" name="titulo"><br>
        Arquivo: <input type="file" name="arquivo"><br>
        Detalhes: <br><textarea name="detalhes"></textarea><br>
        <input type="submit" value="Adicionar música">
    </form>
</body>

</html>