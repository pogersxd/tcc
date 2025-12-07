<?php
function renderAddPlaylistForm()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['usuario'])) header("Location: index.php");
    return <<<HTML
        <h1>Cadastrar playlist</h1>
        <form id="add-playlist-form" enctype="multipart/form-data">
            Título da Playlist: <input type="text" name="titulo" required><br>
            Capa da playlist: (máximo de 10MB) <input type="file" name="capa" required><br>
            <input type="submit" value="Adicionar">
            <br><a href="#" onclick="loadComponent('mainMenu')">Voltar à página inicial</a>
        </form>
    HTML;
}
if (basename(__FILE__) === basename($_SERVER["SCRIPT_FILENAME"])) {
    echo renderAddPlaylistForm();
}
