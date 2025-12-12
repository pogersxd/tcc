<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . "/../conect.php";
require_once __DIR__ . "/../functions.php";
if (!isset($_SESSION['usuario']) || (isset($_SESSION['usuario']) && $_SESSION['usuario']['adm'] == 0)) {
    header("Location: ../index.php");
    exit();
}
if (isset($_GET['id_album'])) {
    $id_album = $_GET['id_album'];
    if (registroExiste($conexao, 'album', 'id_album', $id_album)) {
        if (registroExiste($conexao, 'musica', 'id_album', $id_album)) {
            $tabelaMusica = mysqli_query($conexao, "SELECT * FROM musica WHERE id_album = '$id_album'");
            while ($musica = mysqli_fetch_assoc($tabelaMusica)) {
                $arquivo = $musica['arquivo'];
                $deletouMusica = unlink("/../assets/songs/" . $arquivo);
                $id_musica = $musica['id_musica'];
                mysqli_query($conexao, "DELETE FROM musica_playlist WHERE id_musica = '$id_musica'");
                mysqli_query($conexao, "DELETE FROM curtido WHERE id_item = '$id_musica' AND tipo = 'musica'");
                if (!$deletouMusica) {
                    echo "Erro ao deletar uma das músicas do álbum";
                }
            }
            mysqli_query($conexao, "DELETE FROM musica WHERE id_album = '$id_album'");
        }
        $tabelaAlbum = mysqli_query($conexao, "SELECT * FROM album WHERE id_album = '$id_album'");
        $album = mysqli_fetch_assoc($tabelaAlbum);
        $capa = $album['capa'];
        if ($capa !== 'capa_padrao.jpg') {
            $deletouCapa = unlink("/../assets/albumCovers/" . $capa);
            if (!$deletouCapa) {
                echo "Erro ao deletar a capa do álbum";
            }
        }
        mysqli_query($conexao, "DELETE FROM curtido WHERE id_item = '$id_album' AND tipo = 'album'");
        mysqli_query($conexao, "DELETE FROM album WHERE id_album = '$id_album'");
        header("Location: ./albuns.php");
    } else {
        echo "O álbum não existe mais";
    }
} else {
    echo "Erro";
}
?>
<br><a href="./albuns">Retornar à tela de Álbuns</a>