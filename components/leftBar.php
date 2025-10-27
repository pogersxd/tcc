 <?php
  include_once "singleItem.php";
  include_once "conect.php";
  function renderLeftBar()
  {
    global $conexao;
    include "functions.php";
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
        $html .= renderSingleItem($capa, $musica, $titulo, $nome);
      }
    } else {
      $html = "<b>Nenhuma música cadastrada!</b>";
      $style = 'style="padding: 10px;"';
    }
    return <<<HTML
          <div class="left-bar" {$style}>
            $html
          </div>
        HTML;
  }
