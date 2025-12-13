 <?php
  require_once __DIR__ . "/../conect.php";
  require_once __DIR__ . "/../functions.php";
  require_once __DIR__ . "/searchBar.php";
  function renderHeader()
  {
    global $conexao;
    $html = renderSearchBar();
    $adm = '';
    if (isset($_SESSION['usuario'])) {
      $tabelaUsuario = mysqli_query($conexao, "SELECT * FROM usuario WHERE id_usuario = {$_SESSION['usuario']['id_usuario']}");
      $usuario = mysqli_fetch_assoc($tabelaUsuario);
      $foto = $usuario['foto'];
      $nome = $usuario['nome'];
      $perfil = "<a class='header__icon' href='#' onclick='loadComponent(\"profile\")'><img class='header__icon' src='./assets/pfps/{$foto}' alt='Foto de {$nome}'></a>";
      $logado = '
          <a href="#" onclick="loadComponent(\'addPlaylistForm\');" class="header__link">
            <h2>Adicionar playlist</h2>
          </a>
          <a href="#" onclick="loadComponent(\'editPlaylist\');" class="header__link">
            <h2>Minhas playlists</h2>
          </a>
          <a href="#" onclick="loadComponent(\'addAlbumForm\');" class="header__link">
            <h2>Adicionar álbum</h2>
          </a>
          <a href="#" onclick="loadComponent(\'editAlbum\')" class="header__link">
            <h2>Meus álbuns</h2>
          </a>
          ';
      if ($_SESSION['usuario']['adm'] != 0) {
        $adm = <<<HTML
          <a href="./adm/adm.php" class="header__link">
            <h2>Administrador</h2>
          </a>
        HTML;
      }
    } else {
      $perfil = '<a href="#" onclick="loadComponent(\'login\')"><img class="header__icon" src="./assets/pfps/padrao.jpg" alt="Foto padrão"></a>';
      $logado = '<h2 title="Clique no ícone à esquerda para logar.">Clique à esquerda para logar</h2>';
    }
    return <<<HTML
        <div id="header">
          <div class="header">
            <div class="header__icon-search-bar">
              $perfil
              $html
            </div>  
            $logado 
            $adm
            <a href="#" onclick="loadComponent('mainMenu')" class="header__link">
              <i class="fa-solid fa-house" style="font-size: 40px"></i>
              <h2>Home</h2>
            </a>
          </div>
        </div>
        HTML;
  }
  if (basename(__FILE__) === basename($_SERVER["SCRIPT_FILENAME"])) {
    echo renderHeader();
  }
