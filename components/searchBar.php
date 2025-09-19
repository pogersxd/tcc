 <?php
function renderSearchBar()
{
  return <<<HTML
          <div class="header__search-bar">
            <form action="./">
              <input type="text" name="pesquisa" placeholder="Pesquisar..." />
            </form>
          </div>
        HTML;
}