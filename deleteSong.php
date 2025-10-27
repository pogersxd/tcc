<?php
session_start();
include "conect.php";
include "functions.php";
if (isset($_SESSION['usuario']) || isset($_GET['id_musica']) || isset($_GET['id_album'])) {
    $id_musica = $_GET['id_musica'];
    $id_album = $_GET['id_album'];
    if (registroExiste($conexao, 'musica', 'id_musica', $id_musica)) {
        $sql = mysqli_query($conexao, "SELECT * FROM musica WHERE id_musica = '$id_musica'");
        $musica = mysqli_fetch_assoc($sql);
        $arquivo = $musica['arquivo'];
        $deletou = unlink("./assets/songs/" . $arquivo);
        mysqli_query($conexao, "DELETE FROM musica WHERE id_musica = '$id_musica'");
        if (!$deletou) {
            die("Erro ao excluir!");
        }
        header("Location: addMusicForm.php?id_album={$id_album}");
    } else {
        echo "A música não existe mais.";
    }
}
