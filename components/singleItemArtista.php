 <?php
    function renderSingleItemArtista($id_usuario, $nome, $foto)
    {

        return <<<HTML
              <div class="single-item single-item__artist">
                <a href="#" onclick="loadProfile('{$id_usuario}')" class="single-item__image-button">
                  <img class="single-item__image single-item__image-artist" src="./assets/pfps/{$foto}" alt="Foto do artista {$nome}">
                  <a href="#" class="fa-solid fa-circle-play single-item__icon"></a>
                </a>
                <div class="single-item__texts">
                  <a href="#" class="single-item__texts-title">{$nome}</a><br>
                </div>
              </div>
            HTML;
    }
