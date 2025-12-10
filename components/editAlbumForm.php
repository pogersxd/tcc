<?php
require_once __DIR__ . '/../conect.php';
function renderEditAlbumForm()
{
    global $conexao;
    $id_album = $_POST['id_album'];
    $albumQuery = mysqli_query($conexao, "SELECT * FROM album WHERE id_album = '$id_album'");
    $album = mysqli_fetch_assoc($albumQuery);
    $titulo = $album['titulo'];
    $capa = $album['capa'];
    return <<<HTML
    <h2 class="form-title">Editar Perfil</h2>
    <form id="edit-album-form" class="default-form" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id_album" value="{$id_album}">
        <input type="hidden" name="capa_atual" value="{$capa}">

        <label>Título:</label>
        <input type="text" name="titulo" value="{$titulo}" required>

        <br>

        <label>Capa atual:</label><br>
        <img src="assets/albumCovers/{$capa}" width="150">

        <br>

        <label>Nova capa (opcional):</label>
        <input type="file" name="capa">

        <br>

        <input type="submit" value="Salvar alterações">
    </form>
    HTML;
}
if (basename(__FILE__) === basename($_SERVER["SCRIPT_FILENAME"])) {
    echo renderEditAlbumForm();
}
