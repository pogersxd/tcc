 <?php
include_once "singleItem.php";
include "itensArrays.php";
function renderLeftBar()
{
  global $vetorImagens, $vetorMusicas, $vetorNomeMusicas, $vetorNome;
  $a = count($vetorImagens);
  $html = '';
  for ($i = 0; $i < 30; $i++) {
    $html .= renderSingleItem($vetorImagens[$i % $a], $vetorMusicas[$i % $a], $vetorNomeMusicas[$i % $a], $vetorNome[$i % $a]);
  }
  return <<<HTML
          <div class="left-bar">
            $html
          </div>
        HTML;
}