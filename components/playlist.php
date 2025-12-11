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
        $musicasQuery = mysqli_query($conexao, "SELECT * FROM musica m JOIN musica_playlist mp ON mp.id_musica = m.id_musica WHERE mp.id_playlist = '$id_playlist'");
        $html = '';
        if (mysqli_num_rows($musicasQuery) > 0) {
            $numero = 1;
            $html .= <<<HTML
                <div class="playlist-tracklist">
                <div class="playlist-track playlist-track--header">
                    <span>#</span>
                    <span>Título</span>
                    <span>Duração</span>
                </div>
                HTML;
            while ($musica = mysqli_fetch_assoc($musicasQuery)) {
                $duracao = gmdate('i:s', $musica['duracao']);
                $html .= <<<HTML
                    <a href="#" onclick="loadMusicaTela('{$musica['id_musica']}')" class="playlist-track">
                        <span>{$numero}</span>
                        <span>{$musica['titulo']}</span>
                        <span>{$duracao}</span>
                    </a>
                HTML;
                $numero++;
            }
            $html .= "</div>";
        }
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

                    <button class="playlist-delete" onclick="openDeletePlaylistModal()">
                    <i class="fa-solid fa-trash"></i> Excluir
                    </button>
                </div>
                <div id='confirmModal' class='modal' style='display:none'>
                    <div class='modal-content'>
                        <h2 id='modalTitle'>Deletar Playlist</h2>
                        <p id='modalMessage'>Deseja deletar essa playlist</p>
                        <div class='modal-buttons'>
                            <a id='confirmDelete' href='#' class='deleteSongBtn' onclick="deletePlaylist('{$id_playlist}')">Excluir</a>
                            <a id='cancelDelete' class='cancelBtn' href='#' onclick="closeDeletePlaylistModal()">Cancelar</a>
                        </div>
                    </div>
                </div>

                {$html}
            <!-- Lista de músicas -->
            
            HTML;
    }
}
if (basename(__FILE__) === basename($_SERVER["SCRIPT_FILENAME"])) {
    echo renderPlaylist();
}
