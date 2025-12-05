 <?php
  require_once __DIR__ . "/../conect.php";
  require_once __DIR__ . "/../functions.php";
  require_once __DIR__ . "/singleItemMusica.php";
  require_once __DIR__ . "/singleItemAlbum.php";
  require_once __DIR__ . "/singleItemArtista.php";
  function renderItemList($tipo)
  {
    global $conexao;
    $html = '';
    switch ($tipo) {
      case "musicas": {
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
              $html .= renderSingleItemMusica($capa, $musica, $titulo, $nome, $id_usuario);
            }
          } else $html = "<b>Nenhuma música cadastrada!</b>";
          break;
        }
      case "albuns": {
          $sql = mysqli_query($conexao, "SELECT * FROM album");
          if (mysqli_num_rows($sql) > 0) {
            while ($linha = mysqli_fetch_assoc($sql)) {
              $capaAlbum = $linha['capa'];
              $titulo = $linha['titulo'];
              $id_usuario = $linha['id_usuario'];
              $id_album = $linha['id_album'];
              $usuarioQuery = mysqli_query($conexao, "SELECT * FROM usuario WHERE id_usuario = '$id_usuario'");
              $usuario = mysqli_fetch_assoc($usuarioQuery);
              $nome = $usuario['nome'];
              $html .= renderSingleItemAlbum($capaAlbum, $titulo, $id_usuario, $id_album, $nome);
            }
          } else $html = "<b>Nenhum álbum cadastrado!</b>";
          break;
        }
      case "artistas": {
          $teste = false;
          $sql = mysqli_query($conexao, "SELECT * FROM usuario");
          if (mysqli_num_rows($sql) > 0) {
            while ($linha = mysqli_fetch_assoc($sql)) {
              $id_usuario = $linha['id_usuario'];
              if (registroExiste($conexao, "album", "id_usuario", $id_usuario)) {
                $foto = $linha['foto'];
                $nome = $linha['nome'];
                $teste = true;
                $html .= renderSingleItemArtista($id_usuario, $nome, $foto);
              }
            }
          }
          if (!$teste) {
            $html = "<b>Nenhum artista com músicas lançadas!</b>";
          }
          break;
        }
    }

    return <<<HTML
        <div class="item-list">
          <div class="item-list__header">
            <h2 id="tipo-item-list">Músicas</h2>
            <div class="item-list__buttons">
              <a class="item-list__show-more" href="#" onclick="loadItemList('musicas'); return false;">Músicas</a>
              <a class="item-list__show-more" href="#" onclick="loadItemList('albuns'); return false;">Álbuns</a>
              <a class="item-list__show-more" href="#" onclick="loadItemList('artistas'); return false;">Artistas</a>
            </div>
          </div>
          <div class="item-list__container">
            $html
          </div>
        </div>
      HTML;
  }

  // Quando acessado diretamente via fetch (AJAX)
  if (basename(__FILE__) === basename($_SERVER["SCRIPT_FILENAME"])) {
    $tipo = $_POST['tipo'];
    echo renderItemList($tipo);
  }
