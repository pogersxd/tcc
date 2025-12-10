 <?php
  require_once __DIR__ . "/singleItemMusica.php";
  require_once __DIR__ . "/singleItemAlbum.php";
  require_once __DIR__ . "/singleItemArtista.php";
  require_once __DIR__ . "/../conect.php";
  require_once __DIR__ . "/../functions.php";
  function renderLeftBar()
  {
    global $conexao;
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }
    $html = '';
    $curtidos = '';
    if (isset($_SESSION['usuario'])) {
      $id_usuario = $_SESSION['usuario']['id_usuario'];
      $curtidosQuery = mysqli_query($conexao, "SELECT * FROM curtido WHERE id_usuario = '$id_usuario'");
      if (mysqli_num_rows($curtidosQuery) > 0) {
        $curtidos = '<h3 style="margin: 10px 0 0 10px">Curtidos:</h3>';
        while ($curtido = mysqli_fetch_assoc($curtidosQuery)) {
          if ($curtido['tipo'] == "musica") {
            $musicaQuery = mysqli_query($conexao, "SELECT * FROM musica WHERE id_musica = {$curtido['id_item']}");
            $musica = mysqli_fetch_assoc($musicaQuery);
            $arquivo = $musica['arquivo'];
            $titulo = $musica['titulo'];
            $id_album = $musica['id_album'];
            $albumQuery = mysqli_query($conexao, "SELECT * FROM album WHERE id_album = '$id_album'");
            $album = mysqli_fetch_assoc($albumQuery);
            $capa = $album['capa'];
            $id_usuario = $album['id_usuario'];
            $usuarioQuery = mysqli_query($conexao, "SELECT * FROM usuario WHERE id_usuario = '$id_usuario'");
            $usuario = mysqli_fetch_assoc($usuarioQuery);
            $nome = $usuario['nome'];
            $html .= renderSingleItemMusica($capa, $arquivo, $titulo, $nome, $id_usuario);
          }
          if ($curtido['tipo'] == "album") {
            $albumQuery = mysqli_query($conexao, "SELECT * FROM album WHERE id_album = {$curtido['id_item']}");
            $album = mysqli_fetch_assoc($albumQuery);
            $capaAlbum = $album['capa'];
            $titulo = $album['titulo'];
            $id_usuario = $album['id_usuario'];
            $id_album = $album['id_album'];
            $usuarioQuery = mysqli_query($conexao, "SELECT * FROM usuario WHERE id_usuario = '$id_usuario'");
            $usuario = mysqli_fetch_assoc($usuarioQuery);
            $nome = $usuario['nome'];
            $html .= renderSingleItemAlbum($capaAlbum, $titulo, $id_usuario, $id_album, $nome);
          }
          if ($curtido['tipo'] == "artista") {
            $sql = mysqli_query($conexao, "SELECT * FROM usuario");
            if (mysqli_num_rows($sql) > 0) {
              while ($linha = mysqli_fetch_assoc($sql)) {
                $id_usuario = $linha['id_usuario'];
                if (registroExiste($conexao, "album", "id_usuario", $id_usuario)) {
                  $foto = $linha['foto'];
                  $nome = $linha['nome'];
                  $html .= renderSingleItemArtista($id_usuario, $nome, $foto);
                }
              }
            }
          }
        }
      } else {
        $html = "<h3 style='margin: 10px'>Não tem nada curtido.</h3>";
      }
    } else {
      $html = "<h3 style='margin: 10px'>Precisa estar logado para usar isso.</h3>";
    }
    return <<<HTML
          <div id="left-bar" class="left-bar">
            $curtidos
            <div class="left-bar__container">
              $html
            </div>
          </div>
        HTML;
  }
  if (basename(__FILE__) === basename($_SERVER["SCRIPT_FILENAME"])) {
    echo renderLeftBar();
  }
