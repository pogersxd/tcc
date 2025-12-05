 <?php
    function renderSingleItemAlbum($capa, $titulo, $id_usuario, $id_album, $nome)
    {

        return <<<HTML
              <div class="single-item">
                <div class="single-item__image-button">
                  <img class="single-item__image" src="./assets/albumCovers/{$capa}" alt="Capa do álbum {$titulo}">
                  <a href="#" class="fa-solid fa-circle-play single-item__icon"></a>
                </div>
                <div class="single-item__texts">
                  <a href="#" class="single-item__texts-title">{$titulo}</a><br>
                  <a href="#" onclick="loadProfile('{$id_usuario}')" class="single-item__texts-type">{$nome}</a>
                </div>
              </div>
            HTML;
    }
