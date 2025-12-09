<?php
require_once __DIR__ . "/../conect.php";
require_once __DIR__ . "/../functions.php";
require_once __DIR__ . "/singleItemPlaylist.php";
function renderEditAlbum()
{
    global $conexao;
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['usuario'])) header("Location: index.php");
    echo "<h2>Suas Playlists</h2>";
    if (registroExiste($conexao, 'playlist', 'id_usuario', $_SESSION['usuario']['id_usuario'])) {
        $sql = mysqli_query($conexao, "SELECT * FROM playlist WHERE id_usuario = {$_SESSION['usuario']['id_usuario']}");
        echo "<div class='editPlaylist__list'>";
        while ($linha = mysqli_fetch_assoc($sql)) {
            echo renderSingleItemPlaylist($linha['id_playlist']);
        }
        echo "</div>";
    } else {
        echo "Você não tem nenhuma playlist cadastrada. <br>";
        echo "<a href='#' onclick='loadComponent(\"addPlaylistForm\")'>Cadastrar álbum</a>";
    }
    echo '<br><a href="#" onclick="loadComponent(\'mainMenu\')">Voltar à página inicial</a></div>';
}
if (basename(__FILE__) === basename($_SERVER["SCRIPT_FILENAME"])) {
    echo renderEditAlbum();
}
