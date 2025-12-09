 <?php
  require_once __DIR__ . "/../conect.php";
  function renderSingleItemPlaylist($id_playlist)
  {
    global $conexao;
    $playlist = mysqli_query($conexao, "SELECT * FROM playlist WHERE id_playlist = '$id_playlist'");
    $playlistArray = mysqli_fetch_assoc($playlist);
    $id_playlist = $playlistArray['id_playlist'];
    $titulo = $playlistArray['titulo'];
    $capa = $playlistArray['capa'];
    return <<<HTML
              <div class="single-item">
                  <a onclick="loadPlaylist('{$id_playlist}')" href="#">
                    <img class="single-item__image" src="./assets/playlistCovers/{$capa}" alt="Foto da playlist {$titulo}">
                  </a>
                <div class="single-item__texts">
                  <div class="single-item__texts-title" title="{$titulo}">{$titulo}</div>
                </div>
              </div>
            HTML;
  }
