<?php

header("Content-Type: application/json; charset=utf-8");
require_once __DIR__ . "/functions.php";
require_once __DIR__ . "/conect.php";
$response = [];
$id_musica = $_POST['id_musica'];
$id_playlist = $_POST['id_playlist'];
$sqlTeste = mysqli_query($conexao, "SELECT 1 FROM musica_playlist WHERE id_playlist = '$id_playlist' AND id_musica = '$id_musica'");
if (mysqli_num_rows($sqlTeste) == 0) {
    mysqli_query($conexao, "INSERT INTO musica_playlist (id_playlist, id_musica) VALUES ('$id_playlist', '$id_musica')");
    $response['status'] = "success";
    $response['message'] = "Adicionado com sucesso à playlist";
    $response['nextComponent'] = "song";
    $response['id'] = $id_musica;
} else {
    $response['status'] = "error";
    $response['message'] = "A música já existe na playlist";
    $response['nextComponent'] = "song";
    $response['id'] = $id_musica;
}
echo json_encode($response);
