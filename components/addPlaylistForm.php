<?php
function renderAddPlaylistForm()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['usuario'])) header("Location: index.php");
    return <<<HTML
        <h2 class="form-title">Cadastrar playlist</h2>
        <form id="add-playlist-form" class="default-form" enctype="multipart/form-data">
            <label>Título da Playlist: <input type="text" name="titulo" required></label><br>
            <label>Capa da playlist: (máximo de 10MB) <input type="file" name="capa" required></label><br>
            <label><input type="submit" value="Adicionar"></label>
            <br><a href="#" onclick="loadComponent('mainMenu')">Voltar à página inicial</a>
        </form>
    HTML;
}
if (basename(__FILE__) === basename($_SERVER["SCRIPT_FILENAME"])) {
    echo renderAddPlaylistForm();
}
