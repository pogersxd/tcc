<?php
session_start();
include_once "conect.php";
include_once "functions.php";
if (!isset($_SESSION['usuario']) or !isset($_GET['id_album'])) header("Location: index.php");
$id_album = $_GET['id_album'];
$tabelaAlbum = mysqli_query($conexao, "SELECT * FROM album WHERE id_album = '$id_album'");
$album = mysqli_fetch_assoc($tabelaAlbum);
$tituloAlbum = $album['titulo'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css" class="rel">
    <title>Adicionar Música ao álbum</title>
</head>

<body>
    <h1>Músicas já presentes no álbum <?= "\"$tituloAlbum\"" ?>: </h1>
    <?php
    if (registroExiste($conexao, 'musica', 'id_album', $id_album)) {
        $sql = mysqli_query($conexao, "SELECT * FROM musica WHERE id_album = $id_album");
        echo "<table>
        <tr>
            <th>Título</th>
            <th>Arquivo</th>
            <th>Duração</th>
            <th>Detalhes</th>
            <th>Operações</th>
        </tr>";
        while ($linha = mysqli_fetch_assoc($sql)) {
            echo "<tr>
                <td>{$linha['titulo']}</td>
                <td>{$linha['arquivo']}</td>
                <td>" . gmdate('i:s', $linha['duracao']) . "</td>
                <td>" . nl2br($linha['detalhes']) . "</td>
                <td><button onclick='" . 'openDeleteModal("music", ' . $linha['id_musica'] . ")'>Excluir</button>
            </tr>
            <div id='confirmModal" . $linha['id_musica'] . "' class='modal' style='display:none'>
                <div class='modal-content'>
                    <h2 id='modalTitle" . $linha['id_musica'] . "'></h2>
                    <p id='modalMessage" . $linha['id_musica'] . "'></p>
                    <div class='modal-buttons'>
                        <a id='confirmDelete' href='deleteSong.php?id_musica={$linha['id_musica']}&id_album={$id_album}'>Excluir</a>
                        <a id='cancelDelete' class='cancelBtn' href='#'>Cancelar</a>
                    </div>
                </div>
            </div>";
        }
        echo "</table>";
    } else {
        echo "<h4>Nenhuma.</h5>";
    }
    ?>
    <h1>Adicionar música ao álbum</h1>
    <form action="addMusica.php" method="post" enctype="multipart/form-data">
        Título: <input type="text" name="titulo" required><br>
        Arquivo: (máximo de 10MB)<input type="file" name="arquivo" required><br>
        Detalhes: <br><textarea name="detalhes" required></textarea><br>
        <input type="hidden" name="id_album" value="<?= $id_album; ?>">
        <input type="submit" value="Adicionar música">
        <br><a href="index.php">Voltar à página inicial</a>
    </form>

</body>
<script src="modal.js">
</script>

</html>