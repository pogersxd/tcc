<?php
function renderHeader()
{
  include "searchBar.php";
  $html = renderSearchBar();
  return <<<HTML
        <div class="header">
          <div class="header__icon-search-bar">
            <a class="header__icon" href="./"><img class="header__icon" src="assets/james.png" alt="Foto da James Sunderland"></a>
            $html
          </div>     
          <div class="header__link">
            <a href="./"><h1>RESET</h1></a>
          </div>
        </div>
        HTML;
}
