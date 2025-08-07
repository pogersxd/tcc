<?php
function renderSingleItem($imagem, $musica, $nomeMusica, $nome)
{
  return <<<HTML
          <div class="single-item">
            <div class="single-item__image-button">
              <img class="single-item__image" src="./assets/{$imagem}" alt="Imagem da música X">
              <a href="?musica={$musica}" class="fa-solid fa-circle-play single-item__icon"></a>
            </div>
            <div class="single-item__texts">
              <p class="single-item__texts-title">{$nome}</p>
              <p class="single-item__texts-type">{$nomeMusica}</p>
            </div>
          </div>
        HTML;
}
