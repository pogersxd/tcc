<?php
function renderSingleItem(){
  return <<<HTML
          <a class="single-item" href="#">
            <div class="single-item__image-button">
              <img class="single-item__image" src="./assets/vincent.png" alt="Imagem da música X">
              <i class="fa-solid fa-circle-play single-item__icon"></i>
            </div>
            <div class="single-item__texts">
              <p class="single-item__texts-title">Nome</p>
              <p class="single-item__texts-type">Artista</p>
            </div>
          </a>
        HTML;
}