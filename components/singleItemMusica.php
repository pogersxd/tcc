 <?php

  function renderSingleItemMusica($imagem, $musica, $nomeMusica, $nome, $id_usuario)
  {
    global $conexao;
    $id_musicaQuery = mysqli_query($conexao, "SELECT id_musica FROM musica WHERE arquivo = '$musica'");
    $id_musicaFetch = mysqli_fetch_assoc($id_musicaQuery);
    $id_musica = $id_musicaFetch['id_musica'];
    return <<<HTML
              <div class="single-item">
                <div class="single-item__image-button">
                  <a href="#" onclick="loadMusicaTela('{$id_musica}')">
                    <img class="single-item__image" src="./assets/albumCovers/{$imagem}" alt="Imagem da música {$nomeMusica}">
                  </a>
                  <a href="#" onclick="loadMusica('{$musica}', '{$id_usuario}')" class="fa-solid fa-circle-play single-item__icon"></a>
                </div>
                <div class="single-item__texts">
                  <a href="#" onclick="loadMusicaTela('{$id_musica}')"class="single-item__texts-title">{$nomeMusica}</a><br>
                  <a href="#" onclick="loadProfile('{$id_usuario}')" class="single-item__texts-type">{$nome}</a>
                </div>
              </div>
            HTML;
  }
