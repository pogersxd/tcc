<?php
function renderAddAlbumForm()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['usuario'])) header("Location: index.php");
    return <<<HTML
        <h2 class="form-title">Cadastrar álbum</h2>
        <form id="add-album-form" class="default-form" enctype="multipart/form-data">
            <label>Título do álbum: <input type="text" name="titulo" required></label><br>
            <label>Capa do álbum: (máximo de 10MB) <input type="file" name="capa" required></label><br>
            <input type="submit" value="Adicionar">
            <br><a href="#" class="form-link" onclick="loadComponent('mainMenu')">Voltar à página inicial</a>
        </form>
    HTML;
}
if (basename(__FILE__) === basename($_SERVER["SCRIPT_FILENAME"])) {
    echo renderAddAlbumForm();
}
