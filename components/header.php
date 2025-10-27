 <?php
  include "searchBar.php";
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
      $logout = '<div class="header__link">
            <a href="./logout.php"><h1>Logout</h1></a>
          </div>
          <div class="header__link">
            <a href="./addAlbumForm.php"><h1>Adicionar álbum</h1></a>
          </div>
          <div class="header__link">
            <a href="./editAlbum.php"><h1>Editar álbuns</h1></a>
          </div>';
    } else {
      $perfil = '<a class="header__icon" href="./login.php"><img class="header__icon" src="assets/james.png" alt="Foto da James Sunderland"></a>';
      $logout = '<h2>Não está logado em uma conta, clique no ícone à esquerda para logar.</h2>';
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
