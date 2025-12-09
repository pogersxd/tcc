<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
header("Content-Type: application/json");
require_once __DIR__ . "/conect.php";
require_once __DIR__ . "/functions.php";
$response = [];
if (isset($_SESSION['usuario']) && isset($_POST['id_album'])) {
    $id_album = $_POST['id_album'];
    if (registroExiste($conexao, 'album', 'id_album', $id_album)) {
        if (registroExiste($conexao, 'musica', 'id_album', $id_album)) {
            $tabelaMusica = mysqli_query($conexao, "SELECT * FROM musica WHERE id_album = '$id_album'");
            while ($musica = mysqli_fetch_assoc($tabelaMusica)) {
                $arquivo = $musica['arquivo'];
                $deletouMusica = unlink("./assets/songs/" . $arquivo);
                $id_musica = $musica['id_musica'];
                mysqli_query($conexao, "DELETE FROM musica_playlist WHERE id_musica = '$id_musica'");
                mysqli_query($conexao, "DELETE FROM curtido WHERE id_item = '$id_musica' AND tipo = 'musica'");
                if (!$deletouMusica) {
                    $response["status"] = "error";
                    $response["message"] = "Erro ao deletar o arquivo: $arquivo";
                    $response["nextComponent"] = "editAlbum";
                    $response["id"] = $id_album;
                    echo json_encode($response);
                    exit();
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
                $response["status"] = "error";
                $response["message"] = "Erro ao deletar o arquivo: $arquivo";
                $response["nextComponent"] = "editAlbum";
                $response["id"] = $id_album;
                echo json_encode($response);
                exit();
            }
        }
        mysqli_query($conexao, "DELETE FROM curtido WHERE id_item = '$id_album' AND tipo = 'album'");
        mysqli_query($conexao, "DELETE FROM album WHERE id_album = '$id_album'");
        $response["status"] = "success";
        $response["message"] = "Álbum deletado com sucesso!";
        $response["nextComponent"] = "editAlbum";
        $response["id"] = $id_album;
        echo json_encode($response);
        exit();
    } else {
        $response["status"] = "error";
        $response["message"] = "Erro: álbum não existe mais";
        $response["nextComponent"] = "mainMenu";
        $response["id"] = $id_album;
        echo json_encode($response);
        exit();
    }
} else {
    $response["status"] = "error";
    $response["message"] = "Erro: álbum não existe mais";
    $response["nextComponent"] = "mainMenu";
    $response["id"] = $id_album;
    echo json_encode($response);
    exit();
}
