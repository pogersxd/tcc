<?php
function renderAddAlbumForm()
{
    session_start();
    if (!isset($_SESSION['usuario'])) header("Location: index.php");
    $erro = '';
    $tabelaErro = [];
    if (isset($_GET['erro'])) {
        $tabelaErro = [
            "Arquivo tem um formato inválido.",
            "Arquivo muito grande.",
            "Já existe um álbum com mesmo nome."
        ];
        $erro = "<br>" . $tabelaErro[$_GET['erro']];
    }
    $html = <<<HTML
        <h1>Cadastrar álbum</h1>
        <form action="addAlbum.php" method="post" enctype="multipart/form-data">
            Título do álbum: <input type="text" name="titulo" required><br>
            Capa do álbum: (máximo de 10MB) <input type="file" name="capa" required><br>
            <input type="submit" value="Adicionar">
            <br><a href="index.php">Voltar à página inicial</a>
            {$erro}
        </form>
    HTML;
    return $html;
}

echo renderAddAlbumForm();
