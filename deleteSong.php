<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
header("Content-Type: application/json");
require_once __DIR__ . "/conect.php";
require_once __DIR__ . "/functions.php";
$response = [];
if (isset($_SESSION['usuario']) || isset($_POST['id_musica']) || isset($_POST['id_album'])) {
    $id_musica = $_POST['id_musica'];
    $id_album = $_POST['id_album'];
    if (registroExiste($conexao, 'musica', 'id_musica', $id_musica)) {
        $sql = mysqli_query($conexao, "SELECT * FROM musica WHERE id_musica = '$id_musica'");
        $musica = mysqli_fetch_assoc($sql);
        $arquivo = $musica['arquivo'];
        $deletou = unlink(__DIR__ . "/assets/songs/" . $arquivo);

        mysqli_query($conexao, "DELETE FROM musica_playlist WHERE id_musica = '$id_musica'");
        mysqli_query($conexao, "DELETE FROM curtido WHERE id_item = '$id_musica' AND tipo = 'musica'");
        if (!$deletou) {
            $response["status"] = "error";
            $response["message"] = "Erro ao deletar a música";
            $response["nextComponent"] = "addMusicForm";
            $response["id"] = $id_album;
        } else {
            mysqli_query($conexao, "DELETE FROM musica WHERE id_musica = '$id_musica'");
            $response["status"] = "success";
            $response["message"] = "Música deletada com sucesso!";
            $response["nextComponent"] = "addMusicForm";
            $response["id"] = $id_album;
        }
    } else {
        $response["status"] = "error";
        $response["message"] = "A música não existe mais";
        $response["nextComponent"] = "addMusicForm";
        $response["id"] = $id_album;
    }
}
echo json_encode($response);
