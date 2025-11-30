 <?php
  require_once __DIR__ . "/../conect.php";
  require_once __DIR__ . "/../functions.php";
  require_once __DIR__ . "/searchBar.php";
  function renderHeader()
  {
    global $conexao;
    $html = renderSearchBar();
    if (isset($_SESSION['usuario'])) {
      $tabelaUsuario = mysqli_query($conexao, "SELECT * FROM usuario WHERE id_usuario = {$_SESSION['usuario']['id_usuario']}");
      $usuario = mysqli_fetch_assoc($tabelaUsuario);
      $foto = $usuario['foto'];
      $nome = $usuario['nome'];
      $perfil = "<a class='header__icon' href='./ownProfile.php'><img class='header__icon' src='assets/pfps/{$foto}' alt='Foto de {$nome}'></a>";
      $logout = '
          <a href="#" onclick="loadComponent(\'addAlbumForm\');" class="header__link">
            <h2>Adicionar álbum</h2>
          </a>
          <a href="#" onclick="loadComponent(\'editAlbum\')" class="header__link">
            <h2>Meus álbuns</h2>
          </a>
          <a href="./logout.php" class="header__link">
            <h2>Logout</h2>
          </a>
          ';
    } else {
      $perfil = '<a href="#" onclick="loadComponent(\'login\')"><img class="header__icon" src="assets/james.png" alt="Foto da James Sunderland"></a>';
      $logout = '<h2 title="Clique no ícone à esquerda para logar.">Não está logado</h2>';
    }
    return <<<HTML
        <div class="header">
          <div class="header__icon-search-bar">
            $perfil
            $html
          </div>  
          $logout 
          <div class="header__link">
            <a href="./"><h1>Home</h1></a>
          </div>
        </div>
        HTML;
  }
  if (basename(__FILE__) === basename($_SERVER["SCRIPT_FILENAME"])) {
    echo renderHeader();
  }
