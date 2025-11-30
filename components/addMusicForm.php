<?php
require_once __DIR__ . "/../conect.php";
require_once __DIR__ . "/../functions.php";
function renderAddMusicForm()
{
    global $conexao;
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['usuario']) or !isset($_GET['id_album'])) header("Location: index.php");
    $id_album = $_GET['id_album'];
    $tabelaAlbum = mysqli_query($conexao, "SELECT * FROM album WHERE id_album = '$id_album'");
    $album = mysqli_fetch_assoc($tabelaAlbum);
    $tituloAlbum = $album['titulo'];
    $erro = '';
    $tabelaErro = [];
    if (isset($_GET['erro'])) {
        $tabelaErro = [
            "Arquivo tem um formato inválido.",
            "Arquivo muito grande.",
            "Já existe um álbum com mesmo nome.",
            "A música não existe mais."
        ];
        $erro = "<br>" . $tabelaErro[$_GET['erro']];
    }
?>
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
        if (isset($_GET['erro']) && $erro == ("<br>" . $tabelaErro[3])) echo $erro;
    } else {
        echo "<h4>Nenhuma.</h5>";
    }
    ?>
    <h1>Adicionar música ao álbum</h1>
    <form action="addMusica.php" method="post" enctype="multipart/form-data">
        Título: <input type="text" name="titulo" require_onced><br>
        Arquivo: (máximo de 10MB)<input type="file" name="arquivo" require_onced><br>
        Detalhes: <br><textarea name="detalhes" require_onced></textarea><br>
        <input type="hidden" name="id_album" value="<?= $id_album; ?>">
        <input type="submit" value="Adicionar música">
        <br><a href="index.php">Voltar à página inicial</a>
    </form>
    <?= (isset($_GET['erro']) && $erro != ("<br>" . $tabelaErro[3])) ? $erro : '' ?>

<?php }
if (basename(__FILE__) === basename($_SERVER["SCRIPT_FILENAME"])) {
    echo renderAddMusicForm();
}
