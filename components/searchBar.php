
    <?php
    function renderSearchBar()
    {
      return <<<HTML
    <form class="header__search-bar" onsubmit="return false;">
        <input 
            type="text"
            placeholder="Buscar músicas, álbuns ou artistas..."
            oninput="search(this.value)"
        >
    </form>
    HTML;
    }
