<?php
require_once __DIR__ . "/../conect.php";
function renderAlbum()
{
    global $conexao;
    $id_album = $_POST['id_album'];
    $html = '';
    $tabelaAlbumQuery = mysqli_query($conexao, "SELECT * FROM album WHERE id_album = $id_album");
    if (mysqli_num_rows($tabelaAlbumQuery) > 0) {
        $tabelaAlbum = mysqli_fetch_assoc($tabelaAlbumQuery);
        $titulo = $tabelaAlbum['titulo'];
        $capa = $tabelaAlbum['capa'];
        $id_usuario = $tabelaAlbum['id_usuario'];
        $usuarioQuery = mysqli_query($conexao, "SELECT * FROM usuario WHERE id_usuario = $id_usuario");
        $usuarioFetch = mysqli_fetch_assoc($usuarioQuery);
        $usuarioNome = $usuarioFetch['nome'];

        $somaMusicasQuery = mysqli_query($conexao, "SELECT COUNT(*) as total_linhas FROM musica WHERE id_album='$id_album'");
        $somaMusicasFetch = mysqli_fetch_assoc($somaMusicasQuery);
        $somaMusicas = $somaMusicasFetch['total_linhas'];
        $somaDuracaoQuery = mysqli_query($conexao, "SELECT SUM(duracao) AS soma_total FROM musica WHERE id_album='$id_album'");
        $somaDuracaoFetch = mysqli_fetch_assoc($somaDuracaoQuery);
        $somaDuracao = $somaDuracaoFetch['soma_total'];
        $minutos = floor($somaDuracao / 60) . 'min';
        $horas = '';
        if ($somaDuracao > 60 * 60) {
            $horas = floor($somaDuracao / (60 * 60)) . 'h e ';
        }
        $somaDuracao = $horas . $minutos;
    }


    return <<<HTML
    <div class="album-page">

        <div class="album-header">
            <img src="./assets/albumCovers/{$capa}" alt="Capa do álbum" class="album-cover">

            <div class="album-info">
                <span class="album-type">Álbum</span>
                <h1 class="album-title">{$titulo}</h1>
                <p class="album-artist">{$usuarioNome}</p>
                <p class="album-meta">{$somaMusicas} música(s) • {$somaDuracao}</p>
            </div>
        </div>

        <div class="album-actions">
            <button class="album-play">
            <i class="fa-solid fa-play"></i> Tocar
            </button>
        </div>

        <div class="album-tracklist">
            <div class="album-track album-track--header">
                <span>#</span>
                <span>Título</span>
                <span>Duração</span>
            </div>

            <div class="album-track">
            <span>1</span>
            <span>Música Exemplo</span>
            <span>3:12</span>
            </div>

            <div class="album-track">
            <span>2</span>
            <span>Outra Música</span>
            <span>2:58</span>
            </div>

        </div>
    </div>
HTML;
}

if (basename(__FILE__) === basename($_SERVER["SCRIPT_FILENAME"])) {
    echo renderAlbum();
}
