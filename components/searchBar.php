<?php
function renderSearchBar(){
  return <<<HTML
          <div class="header__search-bar">
            <form action="./">
              <p>Pesquisar: <input type="text" name="pesquisa"></p>
            </form>
          </div>
        HTML;
}