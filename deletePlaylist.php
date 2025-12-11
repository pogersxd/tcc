<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
header("Content-Type: application/json");
require_once __DIR__ . "/conect.php";
require_once __DIR__ . "/functions.php";
$response = [];
if (isset($_POST['id_playlist'])) {
    $id_playlist = $_POST['id_playlist'];
    if (registroExiste($conexao, 'playlist', 'id_playlist', $id_playlist)) {
        $sql = mysqli_query($conexao, "SELECT capa FROM playlist WHERE id_playlist = '$id_playlist'");
        $playlist = mysqli_fetch_assoc($sql);
        $capa = $playlist['capa'];
        $deletou = unlink(__DIR__ . "/assets/playlistCovers/" . $capa);

        mysqli_query($conexao, "DELETE FROM musica_playlist WHERE id_playlist = '$id_playlist'");
        if (!$deletou) {
            $response["status"] = "error";
            $response["message"] = "Erro ao deletar a playlist";
            $response["nextComponent"] = "editPlaylist";
        } else {
            mysqli_query($conexao, "DELETE FROM playlist WHERE id_playlist = '$id_playlist'");
            $response["status"] = "success";
            $response["message"] = "Playlist deletada com sucesso!";
            $response["nextComponent"] = "editPlaylist";
        }
    } else {
        $response["status"] = "error";
        $response["message"] = "A playlist não existe mais";
        $response["nextComponent"] = "editPlaylist";
    }
}
echo json_encode($response);
