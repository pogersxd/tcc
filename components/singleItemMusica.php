 <?php
  function renderSingleItemMusica($imagem, $musica, $nomeMusica, $nome, $id_usuario)
  {

    return <<<HTML
              <div class="single-item">
                <div class="single-item__image-button">
                  <img class="single-item__image" src="./assets/albumCovers/{$imagem}" alt="Imagem da música {$nomeMusica}">
                  <a href="#" onclick="loadMusica('{$musica}')" class="fa-solid fa-circle-play single-item__icon"></a>
                </div>
                <div class="single-item__texts">
                  <a href="#" class="single-item__texts-title">{$nomeMusica}</a><br>
                  <a href="#" onclick="loadProfile('{$id_usuario}')" class="single-item__texts-type">{$nome}</a>
                </div>
              </div>
            HTML;
  }
