<?php

function renderTeste()
{
  return <<<HTML
  <div class="teste-componente">
    <h2>Teste</h2>
    <p>Tela de teste carregada dinamicamente.</p>
    <a href="#" title="Utiliza do mesmo dinamismo" onclick="loadComponent('itemList'); return false;">Voltar para a lista de músicas</a>
  </div>
HTML;
}
echo renderTeste();
