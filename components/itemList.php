 <?php
  function renderItemList()
  {
    global $conexao;
    $html = '';
    $sql = mysqli_query($conexao, "SELECT * FROM musica");
    if (mysqli_num_rows($sql) > 0) {
      while ($linha = mysqli_fetch_assoc($sql)) {
        $musica = $linha['arquivo'];
        $titulo = $linha['titulo'];
        $albumQuery = mysqli_query($conexao, "SELECT * FROM album WHERE id_album = {$linha['id_album']}");
        $album = mysqli_fetch_assoc($albumQuery);
        $capa = $album['capa'];
        $id_usuario = $album['id_usuario'];
        $usuarioQuery = mysqli_query($conexao, "SELECT * FROM usuario WHERE id_usuario = '$id_usuario'");
        $usuario = mysqli_fetch_assoc($usuarioQuery);
        $nome = $usuario['nome'];
        $html .= renderSingleItem($capa, $musica, $titulo, $nome);
      }
    } else
      $html = "<b>Nenhuma música cadastrada!</b>";
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
    require_once __DIR__ . "/../conect.php";
    require_once __DIR__ . "/../functions.php";
    require_once __DIR__ . "/singleItem.php";
    echo renderItemList();
  }
