<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . "/../conect.php";
require_once __DIR__ . "/../functions.php";
if (!isset($_SESSION['usuario']) || !isset($_GET['id_playlist']) || (isset($_SESSION['usuario']) && $_SESSION['usuario']['adm'] == 0)) {
    header("Location: ../index.php");
    exit();
}
$id_playlist = $_GET['id_playlist'];
if (registroExiste($conexao, 'playlist', 'id_playlist', $id_playlist)) {
    $sql = mysqli_query($conexao, "SELECT * FROM playlist WHERE id_playlist = '$id_playlist'");
    $playlist = mysqli_fetch_assoc($sql);
    $capa = $playlist['capa'];
    $deletou = unlink(__DIR__ . "/../assets/playlistCovers/" . $capa);
    if ($deletou) {
        mysqli_query($conexao, "DELETE FROM musica_playlist WHERE id_playlist = '$id_playlist'");
        mysqli_query($conexao, "DELETE FROM playlist WHERE id_playlist = '$id_playlist'");
        echo "A playlist foi excluída com sucesso.";
        header("Location: ./playlists.php");
    } else {
        echo "Ocorreu um erro na exclusão da playlist.";
    }
} else {
    echo "A playlist não existe mais.";
}
?>
<br><a href="./playlists.php">Retornar a tela de playlists</a>