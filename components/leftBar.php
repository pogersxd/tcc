 <?php
  require_once __DIR__ . "/singleItemMusica.php";
  require_once __DIR__ . "/../conect.php";
  function renderLeftBar()
  {
    global $conexao;
    $sql = mysqli_query($conexao, "SELECT * FROM musica");
    $style = '';
    $html = '';
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
        $html .= renderSingleItemMusica($capa, $musica, $titulo, $nome);
      }
    } else {
      $html = "<b>Nenhuma música cadastrada!</b>";
      $style = 'style="padding: 10px;"';
    }
    return <<<HTML
          <div id="left-bar" class="left-bar" {$style}>
            $html
          </div>
        HTML;
  }
  if (basename(__FILE__) === basename($_SERVER["SCRIPT_FILENAME"])) {
    echo renderLeftBar();
  }
