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
if (isset($_SESSION['usuario']) || isset($_GET['id_musica'])) {
    $id_musica = $_GET['id_musica'];
    if (registroExiste($conexao, 'musica', 'id_musica', $id_musica)) {
        $sql = mysqli_query($conexao, "SELECT * FROM musica WHERE id_musica = '$id_musica'");
        $musica = mysqli_fetch_assoc($sql);
        $arquivo = $musica['arquivo'];
        $deletou = unlink(__DIR__ . "/../assets/songs/" . $arquivo);

        mysqli_query($conexao, "DELETE FROM musica_playlist WHERE id_musica = '$id_musica'");
        mysqli_query($conexao, "DELETE FROM curtido WHERE id_item = '$id_musica' AND tipo = 'musica'");
        if (!$deletou) {
            echo "Erro ao deletar a música";
        } else {
            mysqli_query($conexao, "DELETE FROM musica WHERE id_musica = '$id_musica'");
            header("Location: ./musicas.php");
        }
    } else {
        echo "A música não existe mais.";
    }
}
?>
<br><a href="./musicas.php">Retornar à tela de músicas</a>