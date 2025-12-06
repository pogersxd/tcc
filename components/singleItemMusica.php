 <?php

  function renderSingleItemMusica($imagem, $musica, $nomeMusica, $nome, $id_usuario)
  {
    global $conexao;
    $id_albumMusicaTabela = mysqli_query($conexao, "SELECT id_album FROM musica WHERE arquivo = '$musica'");
    $id_albumMusica = mysqli_fetch_assoc($id_albumMusicaTabela);
    $id_album = $id_albumMusica['id_album'];
    return <<<HTML
              <div class="single-item">
                <div class="single-item__image-button">
                  <img class="single-item__image" src="./assets/albumCovers/{$imagem}" alt="Imagem da música {$nomeMusica}">
                  <a href="#" onclick="loadMusica('{$musica}', '{$id_usuario}')" class="fa-solid fa-circle-play single-item__icon"></a>
                </div>
                <div class="single-item__texts">
                  <a href="#" onclick="loadAlbum('{$id_album}')"class="single-item__texts-title">{$nomeMusica}</a><br>
                  <a href="#" onclick="loadProfile('{$id_usuario}')" class="single-item__texts-type">{$nome}</a>
                </div>
              </div>
            HTML;
  }
