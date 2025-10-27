<?php
session_start();
require_once "conect.php";
require_once "functions.php";
if (isset($_SESSION['usuario']) || isset($_GET['id_album'])) {
    $id_album = $_GET['id_album'];
    if (registroExiste($conexao, 'album', 'id_album', $id_album)) {
        if (registroExiste($conexao, 'musica', 'id_album', $id_album)) {
            $tabelaMusica = mysqli_query($conexao, "SELECT * FROM musica WHERE id_album = '$id_album'");
            while ($musica = mysqli_fetch_assoc($tabelaMusica)) {
                $arquivo = $musica['arquivo'];
                $deletouMusica = unlink("./assets/songs/" . $arquivo);
                if (!$deletouMusica) {
                    die("Erro ao excluir a música {$musica['titulo']}!");
                }
            }
            mysqli_query($conexao, "DELETE FROM musica WHERE id_album = '$id_album'");
        }
        $tabelaAlbum = mysqli_query($conexao, "SELECT * FROM album WHERE id_album = '$id_album'");
        $album = mysqli_fetch_assoc($tabelaAlbum);
        $capa = $album['capa'];
        if ($capa !== 'capa_padrao.jpg') {
            $deletouCapa = unlink("./assets/albumCovers/" . $capa);
            if (!$deletouCapa) {
                die("Erro ao excluir a capa!");
            }
        }
        mysqli_query($conexao, "DELETE FROM album WHERE id_album = '$id_album'");
        header("Location: editAlbum.php");
    } else {
        echo "A música não existe mais.";
    }
}
