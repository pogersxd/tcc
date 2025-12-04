 <?php
  require_once __DIR__ . "/itemList.php";
  function renderMainMenu()
  {
    $html = renderItemList('musicas');
    return <<<HTML
          <div class="main-menu" id="main-menu">
            $html
          </div>
          HTML;
  }
  if (basename(__FILE__) === basename($_SERVER["SCRIPT_FILENAME"])) {
    echo renderMainMenu();
  }
