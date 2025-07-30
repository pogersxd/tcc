<?php
include_once "singleItem.php";
function renderLeftBar()
{
  $html = '';
  for ($i = 0; $i < 2; $i++) $html .= renderSingleItem();
  return <<<HTML
          <div class="left-bar">
            $html
          </div>
        HTML;
}
