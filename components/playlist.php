<?php
require_once __DIR__ . "/../conect.php";
function renderPlaylist()
{
    $id_playlist = $_POST['id_playlist'];
    global $conexao;
    $playlistQuery = mysqli_query($conexao, "SELECT * FROM playlist WHERE id_playlist = '$id_playlist'");
    if (mysqli_num_rows($playlistQuery) > 0) {
        $playlist = mysqli_fetch_assoc($playlistQuery);
        $capa = $playlist['capa'];
        $titulo = $playlist['titulo'];
        $musicaQuery = mysqli_query(
            $conexao,
            "SELECT COUNT(*) AS quantidade, SUM(duracao) as duracao FROM musica m JOIN musica_playlist mp ON mp.id_musica = m.id_musica WHERE mp.id_playlist = '$id_playlist'"
        );
        $musica = mysqli_fetch_assoc($musicaQuery);
        $quantidade = $musica['quantidade'];
        $somaDuracao = $musica['duracao'];
        $minutos = floor($somaDuracao / 60) . 'min';
        $horas = '';
        if ($somaDuracao > 60 * 60) {
            $horas = floor($somaDuracao / (60 * 60)) . 'h e ';
        }
        $somaDuracao = $horas . $minutos;
        return <<<HTML
        <div class="playlist-page">
            <!-- Cabeçalho da playlist -->
            <div class="playlist-header">
                <img src="./assets/playlistCovers/{$capa}" alt="Capa da playlist {$titulo}" class="playlist-cover">

                <div class="playlist-info">
                <span class="playlist-type">Playlist</span>
                <h1 class="playlist-title">{$titulo}</h1>
                <p class="playlist-meta">{$quantidade} música(s) • {$somaDuracao}</p>
                </div>
            </div>

            <!-- Ações -->
            <div class="playlist-actions">
                <button class="playlist-edit" onclick="loadEditPlaylist('{$id_playlist}')">
                <i class="fa-solid fa-pen"></i> Editar
                </button>

                <button class="playlist-delete">
                <i class="fa-solid fa-trash"></i> Excluir
                </button>
            </div>

            <!-- Lista de músicas -->
            <div class="playlist-tracklist">
                <div class="playlist-track playlist-track--header">
                <span>#</span>
                <span>Título</span>
                <span>Duração</span>
                </div>

                <div class="playlist-track">
                <span>1</span>
                <span>Nome da Música</span>
                <span>3:12</span>
                </div>

                <div class="playlist-track">
                <span>2</span>
                <span>Outra Música</span>
                <span>2:58</span>
                </div>
            </div>

        </div>
    HTML;
    }
}
if (basename(__FILE__) === basename($_SERVER["SCRIPT_FILENAME"])) {
    echo renderPlaylist();
}
