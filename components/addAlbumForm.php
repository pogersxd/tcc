<?php
function renderAddAlbumForm()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['usuario'])) header("Location: index.php");
    return <<<HTML
        <h1>Cadastrar álbum</h1>
        <form id="add-album-form" enctype="multipart/form-data">
            Título do álbum: <input type="text" name="titulo" required><br>
            Capa do álbum: (máximo de 10MB) <input type="file" name="capa" required><br>
            <input type="submit" value="Adicionar">
            <br><a href="index.php">Voltar à página inicial</a>
        </form>
    HTML;
}
if (basename(__FILE__) === basename($_SERVER["SCRIPT_FILENAME"])) {
    echo renderAddAlbumForm();
}
