 <?php
  function renderSingleItemAlbum($capa, $titulo, $id_usuario, $id_album, $nome)
  {

    return <<<HTML
              <div class="single-item">
                  <a href="#" onclick="renderAlbum('{$id_album}')">
                    <img class="single-item__image" src="./assets/albumCovers/{$capa}" alt="Capa do álbum {$titulo}">
                  </a>
                <div class="single-item__texts">
                  <a href="#" onclick="renderAlbum('{$id_album}')" class="single-item__texts-title" title="{$titulo}">{$titulo}</a>
                  <a href="#" onclick="loadProfile('{$id_usuario}')" class="single-item__texts-type" title="{$nome}">{$nome}</a>
                </div>
              </div>
            HTML;
  }
