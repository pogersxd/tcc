<?php
session_start();
require_once "conect.php";
require_once "functions.php";
if (!isset($_SESSION['usuario'])) header("Location: index.php");
if (isset($_GET['id_album'])) {
    header("Location: addMusicForm.php?id_album={$_GET['id_album']}");
}
$erro = '';
$tabelaErro = [];
if (isset($_GET['erro'])) {
    $tabelaErro = [
        "O álbum não existe mais."
    ];
    $erro = "<br>" . $tabelaErro[$_GET['erro']];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css" class="rel">
    <title>Editar álbuns</title>
</head>

<body>
    <?php
    if (registroExiste($conexao, 'album', 'id_usuario', $_SESSION['usuario']['id_usuario'])) {
        $sql = mysqli_query($conexao, "SELECT * FROM album WHERE id_usuario = {$_SESSION['usuario']['id_usuario']}");
    ?>
        <table>
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
                    <td><a href='addMusicForm?id_album={$linha['id_album']}'>Gerenciar músicas</a>
                    | <button onclick='" . 'openDeleteModal("album", ' . $linha['id_album'] . ")'>Excluir</button></td>
                </tr>
                <div id='confirmModal" . $linha['id_album'] . "' class='modal' style='display:none'>
                    <div class='modal-content'>
                        <h2 id='modalTitle" . $linha['id_album'] . "'></h2>
                        <p id='modalMessage" . $linha['id_album'] . "'></p>
                        <div class='modal-buttons'>
                            <a id='confirmDelete' href='deleteAlbum.php?id_album={$linha['id_album']}'>Excluir</a>
                            <a id='cancelDelete' class='cancelBtn' href='#'>Cancelar</a>
                        </div>
                    </div>
                </div>";
            }
            echo $erro;
            ?>
        </table>
    <?php } else {
        echo "Você não tem nenhum álbum cadastrado. <br>";
        echo "<a href='addAlbumForm.php'>Cadastrar álbum</a>";
    }
    ?>
    <br><a href="index.php">Voltar à página inicial</a>
</body>
<script src="modal.js">
</script>

</html>