<?php
require_once __DIR__ . "/../conect.php";
require_once __DIR__ . "/../functions.php";
require_once __DIR__ . "/../searchByType.php";

function renderSearchResults()
{
    global $conexao;

    if (!isset($_POST['q'])) {
        return "<h2>Busca inválida</h2>";
    }

    $q = mysqli_real_escape_string($conexao, $_POST['q']);
    $html = '';

    /* ========= MÚSICAS ========= */
    $musicas = searchByType("musicas", $q);

    if ($musicas) {
        $html .= "
        <div class='item-list'>
            <div class='item-list__header'>
                <h2>Músicas</h2>
            </div>
            <div class='item-list__container'>
                $musicas
            </div>
        </div>";
    }

    /* ========= ÁLBUNS ========= */
    $albuns = searchByType("albuns", $q);

    if ($albuns) {
        $html .= "
        <div class='item-list'>
            <div class='item-list__header'>
                <h2>Álbuns</h2>
            </div>
            <div class='item-list__container'>
                $albuns
            </div>
        </div>";
    }

    /* ========= ARTISTAS ========= */
    $artistas = searchByType("artistas", $q);

    if ($artistas) {
        $html .= "
        <div class='item-list'>
            <div class='item-list__header'>
                <h2>Artistas</h2>
            </div>
            <div class='item-list__container'>
                $artistas
            </div>
        </div>";
    }

    if ($html === '') {
        $html = "<h2>Nenhum resultado encontrado para <i>$q</i></h2>";
    }

    return $html;
}

/* Permite acesso direto via AJAX */
if (basename(__FILE__) === basename($_SERVER["SCRIPT_FILENAME"])) {
    echo renderSearchResults();
}
