<?php

function renderTeste() {
  return <<<HTML
    <div class="teste-componente">
      <h2>Teste</h2>
      <p>Tela de teste carregada dinamicamente.</p>
      <a href="#" onclick="loadComponent('itemList'); return false;">Voltar dinamicamente para a lista de músicas</a>
    </div>
  HTML;
}

echo renderTeste();