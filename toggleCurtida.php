<?php
require_once __DIR__ . "/conect.php";
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header("Content-Type: application/json; charset=utf-8");
$tipo = $_POST['tipo'];
$id_item = $_POST['id_item'];
$id_usuario = $_SESSION['usuario']['id_usuario'];
$sql = mysqli_query($conexao, "SELECT * FROM curtido WHERE id_usuario = '$id_usuario' AND tipo = '$tipo' AND id_item = '$id_item'");
if (mysqli_num_rows($sql) > 0) {
    mysqli_query($conexao, "DELETE FROM curtido WHERE id_usuario = '$id_usuario' AND tipo = '$tipo' AND id_item = '$id_item'");
    echo json_encode(['curtido' => false]);
} else {
    mysqli_query($conexao, "INSERT INTO curtido (id_usuario, tipo, id_item) VALUES ('$id_usuario', '$tipo', '$id_item')");
    echo json_encode(['curtido' => true]);
}
