<?php
require_once __DIR__ . '/../conect.php';
function renderEditPlaylistForm()
{
    global $conexao;
    $id_usuario = $_POST['id_usuario'];
    $usuarioQuery = mysqli_query($conexao, "SELECT * FROM usuario WHERE id_usuario = '$id_usuario'");
    $usuario = mysqli_fetch_assoc($usuarioQuery);
    $nome = $usuario['nome'];
    $foto = $usuario['foto'];
    $bio = $usuario['bio'];
    return <<<HTML
    <h2 class="form-title">Editar Perfil</h2>
    <form id="edit-profile-form" class="default-form" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id_usuario" value="{$id_usuario}">
        <input type="hidden" name="foto_atual" value="{$foto}">

        <label>Nome:</label>
        <input type="text" name="nome" value="{$nome}" required>

        <br>

        <label>Bio:</label>
        <textarea name="bio" required>{$bio}</textarea>

        <br>

        <label>Foto atual:</label><br>
        <img src="assets/pfps/{$foto}" width="150">

        <br>

        <label>Nova capa (opcional):</label>
        <input type="file" name="foto">

        <br>

        <input type="submit" value="Salvar alterações">
    </form>
    HTML;
}
if (basename(__FILE__) === basename($_SERVER["SCRIPT_FILENAME"])) {
    echo renderEditPlaylistForm();
}
