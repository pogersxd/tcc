<?php
require_once __DIR__ . "/conect.php";
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header("Content-Type: application/json");
$id_usuario = $_SESSION['usuario']['id_usuario'];
$playslistsSQL = mysqli_query($conexao, "SELECT * FROM playlist WHERE id_usuario = '$id_usuario'");
$p = [];
if (mysqli_num_rows($playslistsSQL) > 0) {
    $a = 0;
    while ($playlist = mysqli_fetch_assoc($playslistsSQL)) {
        $p[$a]["id"] = $playlist['id_playlist'];
        $p[$a]["titulo"] = $playlist['titulo'];
    }
}
echo json_encode($p);
