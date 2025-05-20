<?php
include_once "singleItem.php";

function renderItemList() {
  $html = renderSingleItem();

  return <<<HTML
    <div class="item-list">
      <div class="item-list__header">
        <h2>Músicas</h2>
        <a class="item-list__show-more" href="#" onclick="loadComponent('teste'); return false;">Ir ao teste de tela dinâmica</a>
      </div>
      <div class="item-list__container">
        $html
      </div>
    </div>
  HTML;
}

// Quando acessado diretamente via fetch (AJAX)
if (basename(__FILE__) === basename($_SERVER["SCRIPT_FILENAME"])) {
  echo renderItemList();
}
