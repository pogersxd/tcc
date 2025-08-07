<?php
include_once "singleItem.php";
include "itensArrays.php";

function renderItemList()
{
	global $vetorImagens, $vetorMusicas, $vetorNomeMusicas, $vetorNome;
	$a = count($vetorImagens);
	$html = '';
	for ($i = 0; $i < 30; $i++) {
		$html .= renderSingleItem($vetorImagens[$i % $a], $vetorMusicas[$i % $a], $vetorNomeMusicas[$i % $a], $vetorNome[$i % $a]);
	}
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
