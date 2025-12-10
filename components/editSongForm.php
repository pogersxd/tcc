<?php
require_once __DIR__ . '/../conect.php';
function renderEditSongForm()
{
    global $conexao;
    $id_musica = $_POST['id_musica'];
    $musicaQuery = mysqli_query($conexao, "SELECT * FROM musica WHERE id_musica = '$id_musica'");
    $musica = mysqli_fetch_assoc($musicaQuery);
    $titulo = $musica['titulo'];
    $detalhes = $musica['detalhes'];
    $arquivo = $musica['arquivo'];
    return <<<HTML
    <h2 class="form-title">Editar Perfil</h2>
    <form id="edit-song-form" class="default-form" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id_musica" value="{$id_musica}">
        <input type="hidden" name="arquivo_atual" value="{$arquivo}">

        <label>Título:</label>
        <input type="text" name="titulo" value="{$titulo}" required>

        <br>

        <label>Detalhes:</label>
        <textarea name="detalhes" required>{$detalhes}</textarea>

        <br>

        <label>Arquivo atual:</label><br>
        {$arquivo}

        <br>

        <label>Novo arquivo (opcional):</label>
        <input type="file" name="arquivo">

        <br>

        <input type="submit" value="Salvar alterações">
    </form>
    HTML;
}
if (basename(__FILE__) === basename($_SERVER["SCRIPT_FILENAME"])) {
    echo renderEditSongForm();
}
