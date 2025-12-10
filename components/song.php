<?php
require_once __DIR__ . '/../conect.php';
function renderSong()
{
  if (session_status() === PHP_SESSION_NONE) {
    session_start();
  }
  global $conexao;
  $id_musica = $_POST['id_musica'];
  $musicaQuery = mysqli_query($conexao, "SELECT * FROM musica WHERE id_musica = '$id_musica'");
  $musicaFetch = mysqli_fetch_assoc($musicaQuery);
  $musicaTitulo = $musicaFetch['titulo'];
  $musicaArquivo = $musicaFetch['arquivo'];
  $musicaDetalhes = nl2br($musicaFetch['detalhes']);
  $id_album = $musicaFetch['id_album'];
  $albumQuery = mysqli_query($conexao, "SELECT * FROM album WHERE id_album = '$id_album'");
  $albumFetch = mysqli_fetch_assoc($albumQuery);
  $albumTitulo = $albumFetch['titulo'];
  $albumCapa = $albumFetch['capa'];
  $id_usuario = $albumFetch['id_usuario'];
  $usuarioQuery = mysqli_query($conexao, "SELECT * FROM usuario WHERE id_usuario = '$id_usuario'");
  $usuarioFetch = mysqli_fetch_assoc($usuarioQuery);
  $usuarioNome = $usuarioFetch['nome'];
  $duracao = gmdate("i:s", $musicaFetch['duracao']);
  $botao = '';
  if (isset($_SESSION['usuario'])) {
    $id_usuarioSessao = $_SESSION['usuario']['id_usuario'];
    $curtido = mysqli_query($conexao, "SELECT * FROM curtido WHERE id_item = '$id_musica' AND tipo = 'musica' AND id_usuario = '$id_usuarioSessao'");
    $curtido = (mysqli_num_rows($curtido) > 0);
    $ativoDesativo = $curtido ? "ativo" : "";
    $botao = <<<HTML
          <button class="song-add-playlist" onclick="openAddToPlaylistModal('{$id_musica}')">
              <i class="fa-solid fa-plus"></i> Adicionar à playlist
          </button>
          <button 
              class="btn-curtir {$ativoDesativo}"
              data-tipo="musica"
              data-id="{$id_musica}"
              onclick="toggleCurtida(this)"
              >
              ❤︎
          </button>
          HTML;
  }


  return <<<HTML
    <div class="song-page">
    
      <!-- Cabeçalho da música -->
      <div class="song-header">
        <img src="./assets/albumCovers/{$albumCapa}" alt="Capa do álbum" class="song-cover">
    
        <div class="song-info">
          <span class="song-type">Música</span>
          <h1 class="song-title">{$musicaTitulo}</h1>
          <p class="song-artist">
            <a href="#" onclick="loadProfile('{$id_usuario}')">{$usuarioNome}</a> •
            <a href="#" onclick="loadAlbum('{$id_album}')">{$albumTitulo}</a>
          </p>
          <p class="song-meta">{$duracao}</p>
        </div>
      </div>
    
      <!-- Ações -->
      <div class="song-actions">
        <a href="#" onclick="loadMusica('{$musicaArquivo}', '{$id_usuario}')" class="song-play">
          <i class="fa-solid fa-play"></i> Tocar
        </a>
        {$botao}
      </div>
    
      <!-- Detalhes -->
      <section class="song-details">
        <h2>Detalhes</h2>
        <p>
          {$musicaDetalhes}
        </p>
      </section>
    
      <div class="modal" id="addToPlaylistModal">
          <div class="modal-content">
              <h3>Adicionar à playlist</h3>

              <div id="playlistList">
              <!-- playlists do usuário via PHP ou JS -->
              </div>

              <div class="modal-buttons">
              <a id="cancelAddPlaylist" onclick="closeAddToPlaylistModal()">Cancelar</a>
              </div>
          </div>
      </div>
    </div>
    HTML;
}
if (basename(__FILE__) === basename($_SERVER["SCRIPT_FILENAME"])) {
  echo renderSong();
}
