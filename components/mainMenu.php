 <?php
  include_once "itemList.php";
  function renderMainMenu()
  {
    $html = renderItemList();
    return <<<HTML
          <div class="main-menu" id="main-menu">
              $html
          </div>
        HTML;
  }
