 <?php
  function renderHeader()
  {
    include "searchBar.php";
    $html = renderSearchBar();
    if (isset($_SESSION['usuario'])) {
      $perfil = '<a class="header__icon" href="./profile.php"><img class="header__icon" src="assets/james.png" alt="Foto da James Sunderland"></a>';
      $logout = '<div class="header__link">
            <a href="./logout.php"><h1>Logout</h1></a>
          </div>
          <div class="header__link">
            <a href="./addAlbumForm.php"><h1>Adicionar álbum</h1></a>
          </div>
          <div class="header__link">
            <a href="./editAlbum.php"><h1>Editar álbum</h1></a>
          </div>';
    } else {
      $perfil = '<a class="header__icon" href="./login.php"><img class="header__icon" src="assets/james.png" alt="Foto da James Sunderland"></a>';
      $logout = '';
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
