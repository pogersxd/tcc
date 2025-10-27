 <?php
  function renderMainMenu()
  {
    include "itemList.php";
    $html = renderItemList('main-menu');
    return <<<HTML
          <div class="main-menu" id="main-menu">
              $html
          </div>
        HTML;
  }
