<?php
require_once __DIR__ . '/../conect.php';
function renderEditPlaylistForm()
{
    global $conexao;
    $id_playlist = $_POST['id_playlist'];
    $playlistQuery = mysqli_query($conexao, "SELECT * FROM playlist WHERE id_playlist = '$id_playlist'");
    $playlist = mysqli_fetch_assoc($playlistQuery);
    $titulo = $playlist['titulo'];
    $capa = $playlist['capa'];
    return <<<HTML
    <h2>Editar Playlist</h2>
    <form class="default-form" action="editar_playlist.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id_playlist" value="{$id_playlist}">
        <input type="hidden" name="capa_atual" value="{$capa}">

        <label>Título:</label>
        <input type="text" name="titulo" value="{$titulo}" required>

        <br>

        <label>Capa atual:</label><br>
        <img src="assets/playlistCovers/{$capa}" width="150">

        <br>

        <label>Nova capa (opcional):</label>
        <input type="file" name="capa">

        <br>

        <input type="submit" value="Salvar alterações">
    </form>
    HTML;
}
if (basename(__FILE__) === basename($_SERVER["SCRIPT_FILENAME"])) {
    echo renderEditPlaylistForm();
}
