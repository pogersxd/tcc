 <?php
  function renderSingleItemArtista($id_usuario, $nome, $foto)
  {

    return <<<HTML
              <div class="single-item single-item__artist">
                <div class="single-item__image-button">
                  <a onclick="loadProfile('{$id_usuario}')" href="#"><img class="single-item__image single-item__image-artist" src="./assets/pfps/{$foto}" alt="Foto do artista {$nome}"></a>
                </div>
                <div class="single-item__texts">
                  <a href="#" onclick="loadProfile('{$id_usuario}')" class="single-item__texts-title">{$nome}</a><br>
                </div>
              </div>
            HTML;
  }
